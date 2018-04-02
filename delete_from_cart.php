<?php
include 'lib/init.php';
if (isset($_GET['id']) && isset($_SESSION['cart'])) {
	$id = $_GET['id'];
	$arr = json_decode($_SESSION['cart']);
	$arr = json_decode(json_encode($arr), true);
	if (isset($arr[$id])) {
		$qty = $arr[$id];
		unset($arr[$id]);
		$_SESSION['cart'] = json_encode($arr);
		if (isset($_SESSION['item_in_cart'])) {
			$_SESSION['item_in_cart'] -= $qty;
			if ($_SESSION['item_in_cart'] < 0)
				$_SESSION['item_in_cart'] = 0;
		}
	}
}
header('Location: cart.php');
?>