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
			<h3><u>Crée un produit</u></h3>
			<form action="update_product.php" method="POST">
				<input type="hidden" name="item_id" value="<?php echo $ID; ?>">
				<div class="input"><p>Nom</p> <input class="input_text" type="text" name="name" /></div>
				<div class="input"><p>Image (indiquer un URL)</p> <input class="input_text" type="text" name="img" /></div>
				<div class="input"><p>Prix (en euros)</p> <input class="input_text" type="text" name="price" /></div>
				<div class="input">
					<p>Categories</p>
					<select name="categories[]" multiple>
						<?php
							$data = mysqli_query($mysqli, "SELECT ID, name FROM products_category");
							while ($tab = mysqli_fetch_assoc($data))
								echo '<option value="' . $tab['ID'] . '">' . $tab['name'] . '</option>';
						?>
					</select>
				</div>
				<input style="margin-top: 50px;" type="submit" name="action" value="Ajouter" class="button" />
			</form>
		</center>
</body>
</html>