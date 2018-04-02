<?php
	include 'lib/init.php';
?>
<!DOCTYPE html>
<html>
<?php include 'lib/header.php'; ?>
<body>
	<?php include 'lib/navbar.php'; ?>
	<div class="cart_content">
		<h2>Votre panier</h2>
		<hr />
		<?php
			if (isset($_SESSION['item_in_cart']) && $_SESSION['item_in_cart'] > 0) {
				$json = json_decode($_SESSION['cart']);
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
									'<a class="delete" href="delete_from_cart.php?id=' . $item_id . '">X</a>' .
								'</div>' .
								'<p class="total">Prix total: ' . ($qty * $row['price']) . '€</p>' .
							'</div>' .
						'</div>';
					}
				}
				echo '<div class="summary">' .
				'<p>Total: ' . $nb_items . ' articles.</p>' .
				'<p>Montant dû: <font color="#B20000">' . $total . '€</font>.</p>';
				echo isset($_SESSION['logged_in_user']) ?
				'<form method="POST" action="submit_order.php">' .
					'<input class="checkout" name="checkout" type="submit" value="Commander">' .
				'</form>' : "Vous devez être connecter pour passer une commmande.";
				echo '</div>';
			} else {
				echo "Vous n'avez pas d'articles dans votre panier.";
			}
		?>
	</div>
</body>
</html>