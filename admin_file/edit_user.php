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
	if (!isset($_GET['id']))
	{
		header("Location: ./admin_users.php");
		die;
	}
	$ID = intval($_GET['id']);
	$query = mysqli_query($mysqli, "SELECT *, COUNT(*) as nb FROM users WHERE ID = '" . $ID . "' LIMIT 1");
	$data = mysqli_fetch_assoc($query);
	if ($data['nb'] == 0) {
		header("Location: ./admin_users.php");
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
			<h3><u>Modifier un utilisateur</u></h3>
			<form action="update_user.php" method="POST">
				<input type="hidden" name="user_id" value="<?php echo $ID; ?>">
				<div class="input"><p>Identifiant</p> <input class="input_text" type="text" name="login" value="<?php echo $data['login']; ?>" /></div>
				<div class="input"><p>Mot de passe</p> <input class="input_text" type="password" name="passwd" /></div>
				<div class="input"><p>Prenom</p> <input class="input_text" type="text" name="first" value="<?php echo $data['first_name']; ?>" /></div>
				<div class="input"><p>Nom</p> <input class="input_text" type="text" name="last" value="<?php echo $data['last_name']; ?>" /></div>
				<div class="input"><p>Email</p> <input class="input_text" type="text" name="mail" value="<?php echo $data['email']; ?>" /></div>
				<div class="input"><p>Telepone</p> <input class="input_text" type="text" name="tel" value="<?php echo $data['telephone']; ?>" /></div>
				<div class="input"><p>Code Postal</p> <input class="input_text" type="text" name="cp" value="<?php echo $data['zip']; ?>" /></div>
				<div class="input"><p>Adresse</p> <input class="input_text" type="text" name="address" value="<?php echo $data['adress']; ?>" /></div>
				<div class="input"><p>Ville</p> <input class="input_text" type="text" name="city" value="<?php echo $data['city']; ?>" /></div>
				<input style="margin-top: 50px" type="submit" name="action" value="Modifier" class="button" />
			</form>
		</center>
</body>
</html>