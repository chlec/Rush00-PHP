<?php
	include 'lib/init.php';
?>
<!DOCTYPE html>
<html>
<?php include 'lib/header.php'; ?>
<body>
	<?php include 'lib/navbar.php'; ?>
	<div class="main_div">
		<div class="fade">
			<div class="text">
				<h3>Bienvenue sur site de DVD !</h3>
				<p>Ici vous trouverez tout les DVD que vous souhaitez à prix attractif.</p>
			</div>
		</div>
	</div>
	<div class="part">
		<div class="part_content">
			<h2>Vous souhaitez acheter un DVD ?</h2>
			<p>Commander sur notre site et vous serez livrer dans les 48 heures !</p>
			<a href="/products.php" class="button">Commander</a>
		</div>
		<div class="part_content">
			<h2>Vous n'avez pas de compte ?</h2>
			<p>Inscrivez vous dès maintenant !</p>
			<a href="/create_log/register.php" class="button">Inscription</a>
		</div>
		<div class="part_content">
			<h2>J'ai un compte !</h2>
			<p>Vous pouvez vous connecter dans ce cas.</p>
			<a href="/create_log/login.php" class="button">Connexion</a>
		</div>
	</div>
</body>
</html>