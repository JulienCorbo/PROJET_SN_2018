<?php include 'header.php' ?>
<body>
	<div id="connect">
		<div id="header">
			<img class="logo" src="src/picto-piscine_white.png" alt="">
			<h1>Bienvenue</h1>
		</div>
		<div id="content">
			<h2>Veuillez vous identifier</h2>
			<form name="connection" id="connection" method="post" action="index.php">
				<input type="text" name="login" placeholder="Adresse e-mail ou Identifiant" autocomplete="username" class="user topBorder">
				<input type="password" name="pass" placeholder="Mot de passe" autocomplete="current-password" class="password botBorder">
				<h3 id="error"><?php connect() ?></h3>
				<a href="password.php" class="link">Mot de passe oublié ?</a>
				<input type="submit" name="connect" value="Connexion" class="formButton">
			</form>
		</div>
		<?php include 'version.php' ?>
	</div>
</body>