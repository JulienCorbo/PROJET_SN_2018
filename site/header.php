<?php 
session_start();

$fileName = basename($_SERVER['SCRIPT_FILENAME']);
echo "<script type='text/javascript'>console.log('".$fileName."')</script>";
if($fileName=='pool.php'){
	if($_SESSION['isAuth']!='OK'){
		header('Location: index.php');
	}
}

function connect(){
	if(isset($_POST['connect'])){
		$bdd =mysqli_connect("localhost","root","raspberry","pool3k");
		$query='SELECT login, pass, id FROM users ';
		$bddData = mysqli_query($bdd,$query);
		$Login=htmlspecialchars($_POST['login']);
		$Pass=htmlspecialchars($_POST['pass']);
		while($bddDataRow=mysqli_fetch_array($bddData)){
			if(($Login==$bddDataRow['login'])&&(password_verify($Pass,$bddDataRow['pass']))){
				$_SESSION['id']=$bddDataRow['id'];
				$_SESSION['isAuth']='OK';
				header('Location: pool.php');
				die();
			}
		}
		echo "Identifiant ou mot de passe incorrect";
	}
}
function disconnect(){
	if(isset($_POST['deconnexion'])){ 
		session_destroy(); 
		$_SESSION['isAuth']='KO'; 
		header('Location: index.php'); 
	}
}

function passwordChange(){ // Changement de mot de passe
	if(isset($_POST['changePass'])){
		$connect = mysqli_connect("localhost","root","raspberry","pool3k");
		$query = "SELECT * FROM users WHERE id={$_SESSION['id']}";
		$bddData = mysqli_query($connect,$query);

		$oldPass = htmlspecialchars($_POST['oldPass']);
		$newPass = htmlspecialchars($_POST['newPass']);
		$newPassConfirm = htmlspecialchars($_POST['newPassVerif']);
		$bddDataRow = mysqli_fetch_array($bddData);

		if (password_verify($oldPass,$bddDataRow['pass'])){
			if($newPass == $newPassConfirm){
				$query = "UPDATE users SET pass = '".password_hash($newPass,PASSWORD_DEFAULT)."' WHERE id = {$_SESSION['id']}";
				mysqli_query($connect,$query);
				echo "'Votre mot de passe a bien été modifié',true";
			}
			else{
				echo "'Le nouveau mot de passe et la confirmation doivent être identiques',true";
			}
		}
		else{
			echo "'Votre ancien mot de passe est incorrect',true";
		}
	}
}

function randomPassword(
	$length,
	$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
) {
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$str .= $keyspace[rand(0, $max)];
	}
	return $str;
}

function sendPassMail($toAddress,$password){
	$mail=new PHPmailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host='smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth=true;
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->Username='pool3ksn@gmail.com';
	$mail->Password='raspberry';
	$mail->setFrom('pool3ksn@gmail.com','pool3k');
	$mail->addReplyTo('pool3ksn@gmail.com','pool3k');
	$mail->addAddress($toAddress);
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Subject='Récupération de mot de passe Piscine3000';
	$mail->Body='Votre nouveau mot de passe est : ';
	$mail->Body.="<b>".$password."</b>";
	if(!$mail->send()){
		echo $mail->ErrorInfo;
	}
	else{
	}
	$mail->SmtpClose();
	unset($mail);
}

function retrievePass(){
	if(isset($_POST['retrievePass'])){
		$connect =mysqli_connect("localhost","root","raspberry","pool3k");
		$query="SELECT * FROM users WHERE (login='{$_POST['loginOrMail']}' OR mail='{$_POST['loginOrMail']}')";
		$bddData = mysqli_query($connect,$query);
		$bddDataRow=mysqli_fetch_array($bddData);

		$userId=$bddDataRow['id'];
		$mail=$bddDataRow['mail'];
		$password=randomPassword(6);
		sendPassMail($mail,$password);
		$query = "UPDATE users SET pass = '".password_hash($password,PASSWORD_DEFAULT)."' WHERE id =".$userId;
		mysqli_query($connect,$query);
		echo "'Un e-mail contenant un nouveau mot de passe vous a été envoyé.<br>Vous allez être redirigé vers l\'écran de connexion dans 5 secondes.',true";
		header('Refresh: 5; URL=index.php');
	}
} 
?>


<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Piscine 3000</title>
	<link rel="icon" href="src/picto-piscine.png">
	<link rel="stylesheet" type="text/css" href="style/day.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>	
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

	<!-- Script Onglet pool.php -->
	<script type="text/javascript"> 
		$(document).ready(function() {
			$("#main").tabs({
				classes:{
					"ui-tabs-active":"active"
				}
			});
		});
	</script>

	<!-- Script toast information -->
	<script type="text/javascript"> 
		function infoBox(msg,show=false){
			$(document).ready(function(){
				console.log(msg);
				var div = document.getElementById('infobox');
				$('#infobox').html(msg);
				if(show){
					div.className='show';
					setTimeout(function(){ div.className = div.className.replace('show', ''); }, 5000);
				}
			});
		}
	</script>

	<!-- Script Graphiques Google Charts -->
	<script type="text/javascript"> 
		function initDrawChart(){
			var chartTemp = new google.visualization.LineChart(document.getElementById('chart_temp_div'));
			var chartPh = new google.visualization.LineChart(document.getElementById('chart_ph_div'));
			var chartCl = new google.visualization.LineChart(document.getElementById('chart_cl_div'));
			drawChart('temp',chartTemp);
			drawChart('ph',chartPh);
			drawChart('cl',chartCl);
		};
		function drawChart(selectedData,chart){
			var jsonData = $.ajax({
				url: "sample.php",
				type: "get",
				data:{selectedData:selectedData}
			});
			jsonData.done(
				function(){
					var json = jsonData.responseText;
					console.log("DATA_"+selectedData+": "+json);
					var data = new google.visualization.DataTable(json);
					if (selectedData!='table') {
						var options = 
						{
							baselineColor:'none',
							height:140,
							chartArea: {'width': '85%', 'height': '85%'},
							pointSize:3,
							fontName:'Varela Round',
							legend:{position:'none'}
						}
					} else { var options = 
						{
							width:'100%',
							fontName:'Varela Round'
						} 
					};
					chart.draw(data,options);
				}
				);
		};
		google.charts.load('current', {'packages':['corechart'],'language':'fr'});
		google.charts.load('current', {'packages': ['table'],'language':'fr'});
	</script>
</head>