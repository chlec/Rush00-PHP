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
	<div class="cart_content_admin">
		<h2>Commandes effectuées</h2>
		<?php
				$data = mysqli_query($mysqli, "SELECT * FROM orders ORDER BY ID DESC");
				while ($tab = mysqli_fetch_assoc($data))
				{
					echo '<div class="order_div">';
					$json = json_decode($tab['products']);
					$json = json_decode(json_encode($json), true); //stdClass to array
					$total = 0;
					$nb_items = 0;
					foreach ($json as $item_id => $qty) {
						$res = mysqli_query($mysqli, "SELECT name, price, img FROM products WHERE ID = " . intval($item_id));
						if ($row = mysqli_fetch_assoc($res)) {
							$total += ($qty * $row['price']);
							$nb_items += $qty;
							echo '<div class="cart_item">' .
								'<img height="100" width="100" src="data:image/png;base64,' . $row['img'] . '" />' .
								'<div class="item_data">' .
									'<p class="name">' . $row['name'] . '</p>' .
									'<div style="display: flex; width: 100%;">' .
										'<p class="price">Prix unitaire: ' . $row['price'] . '€</p>' .
										'<p class="qty">Quantité: ' . $qty . '</p>' .
									'</div>' .
									'<p class="total">Prix total: ' . ($qty * $row['price']) . '€</p>' .
								'</div>' .
							'</div>';
						}
					}
					echo '<div class="summary">' .
					'<p>Total: ' . $nb_items . ' articles.</p>' .
					'<p>Montant dû: <font color="#B20000">' . $total . '€</font>.</p>';
					echo "Effectué par <b>" . $tab['user'] . "</b>.";
					echo '</div>';
					echo '</div>';
				}
		?>
	</div>
</body>
</html>