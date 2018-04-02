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
			<h3><u>Panneau administrateur</u></h3>
			<p style="margin-top: 50px;"><a class="button" href="./admin_product.php">Gestion des produits</a></p>
			<p style="margin-top: 50px;"><a class="button" href="./admin_users.php">Gestion des utilisateurs</a></p>
			<p style="margin-top: 50px;"><a class="button" href="./admin_orders.php">Gestion des commandes</a></p>
		</center>
</body>
</html>