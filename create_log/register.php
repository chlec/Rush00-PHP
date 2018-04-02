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
		<h2><u>Inscription</u></h2>
		<form action="register_form.php" method="post">
			<div class="input"><p>Identifiant</p> <input class="input_text" type="text" name="login" /></div>
			<div class="input"><p>Mot de passe</p> <input class="input_text" type="password" name="passwd" /></div>
			<div class="input"><p>Prenom</p> <input class="input_text" type="text" name="first" /></div>
			<div class="input"><p>Nom</p> <input class="input_text" type="text" name="last" /></div>
			<div class="input"><p>Email</p> <input class="input_text" type="text" name="mail" /></div>
			<div class="input"><p>Telepone</p> <input class="input_text" type="text" name="tel" /></div>
			<div class="input"><p>Code Postal</p> <input class="input_text" type="text" name="cp" /></div>
			<div class="input"><p>Adresse</p> <input class="input_text" type="text" name="address" /></div>
			<div class="input"><p>Ville</p> <input class="input_text" type="text" name="city" /></div>
			<input type="submit" name="submit" value="Inscription" class="button" />
		</form>
	</div>
</body>
</html>