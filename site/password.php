<?php require("phpMailer/PHPMailerAutoload.php") ; ?>
<?php include 'header.php' ?>
<body>
	<div id="connect">
		<div id="header">
			<img class="logo" src="src/picto-piscine_white.png" alt="">
			<h1>Récupération</h1>
		</div>
		<div id="content">
			<h2>Veuillez saisir votre adresse e-mail ou votre nom d'utilisateur</h2>
			<form name="retrievePass" id="retrievePass" method="post" action="password.php">
				<input type="text" name="loginOrMail" placeholder="Adresse e-mail ou Identifiant">
				<input type="submit" name="retrievePass" value="Valider">
			</form>
		</div>
		<?php include 'version.php' ?>
	</div>
</body>
</html>
