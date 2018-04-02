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
	<div class="admin_content">
		<div class="admin_part">
			<table>
				<caption>Products <a class="button_add right" href="create_product.php">Add product</a></caption>
				<tr>
					<th>Name</th>
					<th>Img</th>
					<th>Price</th>
					<th>Category</th>
					<th>Edit</th>
				</tr>
					<?php
						$data = mysqli_query($mysqli, "SELECT * FROM products ORDER BY name");
						while ($tab = mysqli_fetch_assoc($data))
						{
							$categories = array();
							$item_categories = explode('-', $tab['category']);
							$get_cat = mysqli_query($mysqli, "SELECT * FROM products_category");
							while ($cat = mysqli_fetch_assoc($get_cat)) {
								if (in_array($cat['ID'] , $item_categories)) {
									$categories[] = $cat['name'];
								}
							}
							$categories = implode(', ', $categories);
							echo '<tr>';
							echo '<td><center>' . $tab['name'] . '</center></td>';
							echo '<td><center><img height="75" width="75" src="data:image/png;base64,' . $tab['img'] . '" /></center></td>';
							echo '<td><center>' . $tab['price'] . '€</center></td>';
							echo '<td><center>' . $categories . '</center></td>';
							echo '<td><center>' . '<a class="edit" href="edit_product.php?id='. $tab['ID'].'">Edit</a> / <a class="edit" id="delete_product" product_id="'. $tab['ID'].'">Delete</a>' . '</center></td>';
							echo '</tr>';
						}
					?>
			</table>
		</div>
		<div class="admin_part">
			<table width="100%">
				<caption>Categories <a class="button_add right" onclick="add_category()">Add category</a></caption>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Edit</th>

				</tr>
					<?php
						$data = mysqli_query($mysqli, "SELECT * FROM products_category");
						while ($tab = mysqli_fetch_assoc($data))
						{
							echo '<tr>';
							echo '<td><center>' . $tab['ID'] . '</center></td>';
							echo '<td><center>' . $tab['name'] . '</center></td>';
							echo '<td><center>' . '<a class="edit" id="edit_cat" category_id="'. $tab['ID'].'">Edit</a> / <a class="edit" id="delete_cat" category_id="'. $tab['ID'].'">Delete</a>' . '</center></td>';
							echo '</tr>';
						}
					?>
			</table>
		</div>
		<script type="text/javascript">
			document.querySelectorAll('#edit_cat').forEach(link => {
				link.onclick = function() {
					let ID = this.getAttribute('category_id')
					let newName = prompt("Indiquer le nouveau nom")
					post('update_category.php', { action: 'update', ID: ID, name: newName })
				}
			})
			document.querySelectorAll('#delete_cat').forEach(link => {
				link.onclick = function() {
					let ID = this.getAttribute('category_id')
					let confirmation = confirm("Confirmer la suppression de la catégorie ?")
					if (confirmation)
						post('update_category.php', { action: 'del', ID: ID })
				}
			})

			document.querySelectorAll('#delete_product').forEach(link => {
				link.onclick = function() {
					let ID = this.getAttribute('product_id')
					let confirmation = confirm("Confirmer la suppression du produit ?")
					if (confirmation)
						post('update_product.php', { action: 'del', ID: ID })
				}
			})

			function add_category() {
				let name = prompt("Indiquer le nom de la nouvelle catégorie :")
				if (name.length > 0)
					post('update_category.php', { action: 'add', name: name })
			}

			function post(path, params, method) {
			    method = method || "post"
			    let form = document.createElement("form")
			    form.setAttribute("method", method)
			    form.setAttribute("action", path)

			    for (let key in params) {
			        if (params.hasOwnProperty(key)) {
			            let hiddenField = document.createElement("input")
			            hiddenField.setAttribute("type", "hidden")
			            hiddenField.setAttribute("name", key)
			            hiddenField.setAttribute("value", params[key])

			            form.appendChild(hiddenField)
			        }
			    }

			    document.body.appendChild(form)
			    form.submit()
			}
		</script>
</body>
</html>