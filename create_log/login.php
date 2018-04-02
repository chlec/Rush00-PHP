<?php
	include '../lib/init.php';
	if (isset($_SESSION['logged_in_user'])) {
		header("Location: /index.php");
		die;
	}
?>
<!DOCTYPE html>
<html>
<?php include '../lib/header.php'; ?>
<body>
	<?php include '../lib/navbar.php'; ?>
	<div class="login_content">
		<h2><u>Connexion</u></h2>
		<form action="login_form.php" method="post">
			<div class="input"><p>Identifiant</p> <input class="input_text" type="text" name="login" /></div>
			<div class="input"><p>Mot de passe</p> <input class="input_text" type="password" name="passwd" /></div>
			<input type="submit" name="submit" value="Connexion" class="button" />
		</form>
	</div>
</body>
</html>
