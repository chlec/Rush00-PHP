<?php
include 'lib/init.php';
if (isset($_POST['add']) && isset($_POST['item_id']))
{
	$item_id = $_POST['item_id'];
	if (isset($_SESSION['cart']))
	{
		$arr = json_decode($_SESSION['cart']);
		$arr = json_decode(json_encode($arr), true);
		if (isset($arr[$item_id]))
			$arr[$item_id] = $arr[$item_id] + 1;
		else
			$arr[$item_id] = 1;
		$_SESSION['cart'] = json_encode($arr); 
	}
	else
	{
		$arr = array();
		$arr[$item_id] = 1;
		$_SESSION['cart'] = json_encode($arr);
	}
	if (isset($_SESSION['item_in_cart']))
	{
		$_SESSION['item_in_cart'] += 1;
	}
	else
	{
		$_SESSION['item_in_cart'] = 1;
	}
}
header('Location: products.php');
?>