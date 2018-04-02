<?php
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install.php'))
	{
		header('Location: /install.php');
		die;
	}
	include 'db.php';
	session_start();
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if (isset($_SESSION['logged_in_user'])) {
		$query = mysqli_query($mysqli, "SELECT COUNT(*) as nb FROM users WHERE login = '" . $_SESSION['logged_in_user'] . "' LIMIT 1");
		$row = mysqli_fetch_assoc($query);
		if ($row['nb'] == 0)
		{
			unset($_SESSION['logged_in_user']);
		}
	}
?>