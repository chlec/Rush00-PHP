<?php
	include '../lib/init.php';
	function	verif_product($name, $img, $price, $category, $mysqli)
	{
		$data = mysqli_query($mysqli, "SELECT * FROM products");
		while ($tab = mysqli_fetch_assoc($data))
		{
			foreach ($tab as $key => $value)
			{
				if ($key == "name")
					if ($value == $name)
						return (false);
			}
		}
		return (true);
	}

	function	add_product($name, $img, $price, $category, $mysqli)
	{
		$img = base64_encode(@file_get_contents($img));
		$query = "INSERT INTO products VALUES(NULL, ?, ?, ?, ?)";
		$sql = mysqli_prepare($mysqli, $query);
		mysqli_stmt_bind_param($sql, 'ssds', $name, $img, $price, $category);
		mysqli_stmt_execute($sql);
		mysqli_stmt_close($sql);
	}

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
		if ($_POST['action'] == "Modifier") {
			if (isset($_POST['name'], $_POST['price'], $_POST['categories'], $_POST['item_id'])) {
				$name = $_POST['name'];
				$price = $_POST['price'];
				$ID = $_POST['item_id'];
				if (count($_POST['categories']) > 0 && is_numeric($price) && strlen($price) <= 4) {
					$categories = implode('-', $_POST['categories']);
					$query = mysqli_prepare($mysqli, "UPDATE products SET name = ?, price = ?, category = ? WHERE ID = ?");
					mysqli_stmt_bind_param($query, 'sdsi', $name, $price, $categories, $ID);
					mysqli_stmt_execute($query);
					mysqli_stmt_close($query);
					if (isset($_POST['new_img'])) {
						$url = $_POST['new_img'];
						if (filter_var($url, FILTER_VALIDATE_URL)) {
							$data = @file_get_contents($url);
							$data = base64_encode($data);
							$query = mysqli_prepare($mysqli, "UPDATE products SET img = ? WHERE ID = ?");
							mysqli_stmt_bind_param($query, 'si', $data, $ID);
							mysqli_stmt_execute($query);
							mysqli_stmt_close($query);
						}
					}
				} else {
					echo 'Error: Le format des champs est incorrects. <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
					die;
				}
			} else {
				echo 'Error: Remplissez les champs. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
				die;
			}
		} else if ($_POST['action'] == "del") {
			if (isset($_POST['ID'])) {
				$query = mysqli_prepare($mysqli, "DELETE FROM products WHERE ID = ?");
				mysqli_stmt_bind_param($query, 'i', $_POST['ID']);
				mysqli_stmt_execute($query);
				mysqli_stmt_close($query);
			}
		} else if ($_POST['action'] == "Ajouter") {
			$name = "";
			$img = "";
			$price = "";
			$category = "";
			foreach ($_POST as $key => $value)
			{
				if ($key == "name")
					$name = $value;
				if ($key == "img")
					$img = $value;
				if ($key == "price" && is_numeric($value) == true && strlen($value) <= 4)
					$price = $value;
				if ($key == "categories")
					$category = $value;
			}
			if (isset($category) && $category != "")
				$category = implode('-', $category);
			if ($name != "" && $img != "" && $price != "" && $category != "")
			{
				if (verif_product($name, $img, $price, $category, $mysqli) == true)
				{
					add_product($name, $img, $price, $category, $mysqli);
					echo 'Le produit a bien été ajouté! Redirection... <meta http-equiv="refresh" content="3; URL=./admin_product.php">';
					die;
				}
				else {
					echo 'Error: Ce produit existe déjà. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
					die;
				}

			}
			else {
				echo 'Error: Champ invalide. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_product.php">';
				die;
			}
		}
	}
	header('Location: ./admin_product.php');
	die;
?>
