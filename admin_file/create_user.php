<?php
	include '../lib/init.php';
	if (!isset($_SESSION['logged_in_user'])) {
		header("Location: /index.php");
		die;
	}
	$query = mysqli_query($mysqli, "SELECT rank FROM users WHERE login = '" . $_SESSION['logged_in_user'] . "' LIMIT 1");
	$row = mysqli_fetch_assoc($query);
	$rank = $row['rank'];
	if ($rank != 1) {
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
		<center>
			<h3><u>Crée un utilisateur</u></h3>
			<form action="update_user.php" method="POST">
				<div class="input"><p>Identifiant</p> <input class="input_text" type="text" name="login" /></div>
			<div class="input"><p>Mot de passe</p> <input class="input_text" type="password" name="passwd" /></div>
			<div class="input"><p>Prenom</p> <input class="input_text" type="text" name="first" /></div>
			<div class="input"><p>Nom</p> <input class="input_text" type="text" name="last" /></div>
			<div class="input"><p>Email</p> <input class="input_text" type="text" name="mail" /></div>
			<div class="input"><p>Telepone</p> <input class="input_text" type="text" name="tel" /></div>
			<div class="input"><p>Code Postal</p> <input class="input_text" type="text" name="cp" /></div>
			<div class="input"><p>Adresse</p> <input class="input_text" type="text" name="address" /></div>
			<div class="input"><p>Ville</p> <input class="input_text" type="text" name="city" /></div>
			<input type="submit" name="action" value="Ajouter" class="button" />
			</form>
		</center>
</body>
</html>