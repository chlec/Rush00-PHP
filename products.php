<?php
	include 'lib/init.php';
?>
<!DOCTYPE html>
<html>
<?php include 'lib/header.php'; ?>
<body>
	<?php include 'lib/navbar.php'; ?>
	<div class="content">
		<div class="category">
			<u><h3>Catégorie</h3></u>
			<ul class="leftmenu">
				<?php
					$res = mysqli_query($mysqli, "SELECT ID, name FROM products_category ORDER BY name");
					while ($row = mysqli_fetch_assoc($res)) {
				        echo '<li><input name="category" id="category_' . $row['ID'] . '" type="checkbox" checked>' . $row['name'] . '</li>';
					}
				?>
			</ul>
		</div>
		<div class="products">
			<h2>Nos produits</h2>
			<hr />
			<div class="item_lists">
			<?php
				$res = mysqli_query($mysqli, "SELECT * FROM products ORDER BY name");
				while ($row = mysqli_fetch_assoc($res)) {
					echo '<div class="item" category="' . $row['category'] . '">' .
						'<form method="POST" action="add_to_cart.php">' .
						'<center><img height="125" width="125" src="data:image/png;base64,' . $row['img'] . '" /></center>' .
						'<p class="item_name">' . $row['name'] . '</p>' .
						'<input type="hidden" name="item_id" value="' . $row['ID'] . '">' .
						'<input type="submit" class="buy" name="add" value="Acheter (' . $row['price'] .'€)">' .
						'</form>' .
					'</div>';
				}
			?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		const visible = []
		document.querySelectorAll('[name="category"]').forEach(el => {
			let category = el.getAttribute('id').split('_')[1]
			visible.push(category)

			el.onclick = function() {
				let checked = this.checked
				if (!checked)
				{
					let idx = visible.indexOf(category)
					visible.splice(idx, 1)
				}
				else
					visible.push(category)
				let items = document.querySelectorAll('.item')
				items.forEach(item => {
					let num_visible = 0
					for (let cat of item.getAttribute('category').split('-'))
					{
						if (visible.indexOf(cat) > -1)
							num_visible++
					}
					if (num_visible === 0)
						item.style.display = 'none'
					else
						item.style.display = 'block'
				})
			}
		})
	</script>
</body>
</html>