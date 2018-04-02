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
		header("Location: ./admin_product.php");
		die;
	}
	$ID = intval($_GET['id']);
	$query = mysqli_query($mysqli, "SELECT *, COUNT(*) as nb FROM products WHERE ID = '" . $ID . "' LIMIT 1");
	$data = mysqli_fetch_assoc($query);
	if ($data['nb'] == 0) {
		header("Location: ./admin_product.php");
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
			<h3><u>Modifier un produit</u></h3>
			<form action="update_product.php" method="POST">
				<input type="hidden" name="item_id" value="<?php echo $ID; ?>">
				<div class="input"><p>Nom</p> <input class="input_text" type="text" name="name" value="<?php echo $data['name']; ?>" /></div>
				<div class="input"><p>Image actuelle</p> <img height="125" width="125" src="data:image/png;base64,<?php echo $data['img'] ?>" /></div>
				<div class="input"><p>Nouvelle image (indiquer l'URL)</p> <input class="input_text" type="text" name="new_img" /></div>
				<div class="input"><p>Prix (en euros)</p> <input class="input_text" type="text" name="price" value="<?php echo $data['price']; ?>"/></div>
				<div class="input">
					<p>Categories</p>
					<select name="categories[]" multiple>
						<?php
							$item_categories = explode("-", $data['category']);
							$data = mysqli_query($mysqli, "SELECT ID, name FROM products_category");
							while ($tab = mysqli_fetch_assoc($data))
							{
								$selected = in_array($tab['ID'], $item_categories) ? 'selected' : '';
								echo '<option value="' . $tab['ID'] . '" ' . $selected . '>' . $tab['name'] . '</option>';
							}
						?>
					</select>
				</div>
				<input style="margin-top: 50px;" type="submit" name="action" value="Modifier" class="button" />
			</form>
		</center>
</body>
</html>