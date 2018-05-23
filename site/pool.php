<?php include 'header.php' ?>
<?php disconnect() ?>
<body>
	<div id="main">
		<ul id="header">
			<img class="logo" src="src/picto-piscine_white.png" alt="">
			<li>
				<a href="#home">Accueil</a>
			</li>
			<li>
				<a href="#statement">Relevés</a>
			</li>
			<li>
				<a href="#correction">Correction</a>
			</li>
			<li>
				<a href="#setting" class="fontawesome-cog"></a>
			</li>
		</ul>
		<div id="home">
			<div class="row">
				<div class="col">
					<h2>Température</h2>
					<div id="chart_temp_div"></div>
				</div>
				<div class="col">
					<h2>Ph</h2>
					<div id="chart_ph_div"></div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h2>Taux de Chlore</h2>
					<div id="chart_cl_div"></div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){google.charts.setOnLoadCallback(initDrawChart);});
				</script>
			</div>
		</div>
		<div id="statement">
			<table>
				<tr>
					<th>Date</th><th>Température (°C)</th><th>Ph</th><th>Taux de chlore</th>
				</tr>
				<tr>
					<?php 
					$bdd =mysqli_connect("localhost","root","raspberry","pool3k");
					$query='SELECT temp, ph, cl,
					UNIX_TIMESTAMP(CONCAT_WS(" ",sample_date,sample_time)) AS datetime
					FROM statements ORDER BY sample_date DESC, sample_time DESC';
					$bddData = mysqli_query($bdd,$query);
					$english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'Décember');
					$french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
					while($dataRow=mysqli_fetch_array($bddData))
					{
						$date=date("j F Y \à H:i:s",$dataRow['datetime']);
						$date=str_replace($english_months, $french_months, $date);
						echo '<tr><td>'.$date.'</td><td>'.$dataRow['temp'].'</td><td>'.$dataRow['ph'].'</td><td>'.$dataRow['cl'].'</td></tr>';
					}

					?>
				</tr>
				
			</table>
		</div>
		<div id="correction">
			====WIP====
		</div>
		<div id="setting">
			<form name="changePass" id="changePass" method="post">
				<h2>Changer de mot de passe :</h2>
				<input type="password" name="oldPass" placeholder="Ancien mot de passe">
				<input type="password" name="newPass" placeholder="Nouveau mot de passe">
				<input type="password" name="newPassVerif" placeholder="Confirmation">
				<input type="submit" name="changePass" value="Valider">
			</form>
			<script type="text/javascript">infoBox(<?php passwordChange() ?>)</script>
			<div id = "changeStyle">
				<!-- Work in progreCss  -->
			</div>
			<form name="deconnexion" id="deconnexion" method="post">
				<input type="submit" name="deconnexion" value="Se déconnecter" class="formButton">
			</form>
		</div>
		<?php include 'version.php' ?>
		<div id="infobox"></div>
	</div>
</body>