<?php
include 'lib/init.php';
if (!isset($_SESSION['logged_in_user'])) {
	header("Location: /cart.php");
	die;
}
if (isset($_POST['checkout']) && $_POST['checkout'] == "Commander") {
	if (isset($_SESSION['cart'])) {
		$json = json_decode($_SESSION['cart']);
		$json = json_decode(json_encode($json), true);
		$total = 0;
		foreach ($json as $item_id => $qty) {
			$res = mysqli_query($mysqli, "SELECT name, price, img FROM products WHERE ID = " . intval($item_id));
			if ($row = mysqli_fetch_assoc($res)) {
				$total += ($qty * $row['price']);
			}
		}
		$user = $_SESSION['logged_in_user'];
		$query = mysqli_prepare($mysqli, "INSERT INTO orders VALUES(NULL, ?, ?, ?)");
		mysqli_stmt_bind_param($query, 'sds', $user, $total, json_encode($json));
		mysqli_stmt_execute($query);
		mysqli_stmt_close($query);
		unset($_SESSION['cart']);
		unset($_SESSION['item_in_cart']);
	}
}
header('Location: /cart.php');
?>