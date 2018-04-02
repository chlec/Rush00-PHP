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
	if (isset($_POST['action']))
	{
		if ($_POST['action'] == 'add') {
			if (isset($_POST['name']) && strlen($_POST['name']) > 1 && strlen($_POST['name']) <= 20) {
				$query = mysqli_prepare($mysqli, "INSERT INTO products_category VALUES(NULL, ?)");
				mysqli_stmt_bind_param($query, 's', $_POST['name']);
				mysqli_stmt_execute($query);
				mysqli_stmt_close($query);
			} else {
				echo 'Error: Le nom de la catégorie doit faire entre 2 et 20 caractères. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
				die;
			}
		}
		else if ($_POST['action'] == 'update') {
			if (isset($_POST['ID']) && isset($_POST['name'])) {
				if (strlen($_POST['name']) > 1 && strlen($_POST['name']) <= 20) {
					$query = mysqli_prepare($mysqli, "UPDATE products_category SET name = ? WHERE ID = ?");
					mysqli_stmt_bind_param($query, 'si', $_POST['name'], $_POST['ID']);
					mysqli_stmt_execute($query);
					mysqli_stmt_close($query);
				} else {
					echo 'Error: Le nom de la catégorie doit faire entre 2 et 20 caractères. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
					die;
				}
			}
		}
		else if ($_POST['action'] == 'del') {
			if (isset($_POST['ID'])) {
				$query = mysqli_prepare($mysqli, "DELETE FROM products_category WHERE ID = ?");
				mysqli_stmt_bind_param($query, 'i', $_POST['ID']);
				mysqli_stmt_execute($query);
				mysqli_stmt_close($query);
			}
		}
	}
	header('Location: ./admin_product.php');
?>