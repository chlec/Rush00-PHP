<?php
	include '../lib/init.php';

	function	verif_user($passwd, $log, $mail, $tel, $cp, $address, $city, $first, $last, $mysqli)
	{
		$data = mysqli_query($mysqli, "SELECT login,email,telephone FROM users");
		while ($tab = mysqli_fetch_assoc($data))
		{
			foreach ($tab as $key => $value)
			{
				if ($key == "login")
					if ($value == $log)
						return (false);
				if ($key == "email")
					if ($value == $mail)
						return (false);
				if ($key == "telephone")
					if ($value == $tel)
						return (false);
			}
		}
		return (true);
	}

	function	add_user($passwd, $log, $mail, $tel, $cp, $address, $city, $first, $last, $mysqli)
	{
		$passwd = hash("whirlpool", $passwd);
		$query = "INSERT INTO users VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
		$sql = mysqli_prepare($mysqli, $query);
		mysqli_stmt_bind_param($sql, 'sssssssss', $log, $passwd, $first, $last, $mail, $tel, $address, $cp, $city);
		mysqli_stmt_execute($sql);
		mysqli_stmt_close($sql);
	}

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
	if (isset($_POST['action']))
	{
		if ($_POST['action'] == "Modifier") {
			$log = "";
			$mail = "";
			$tel = "";
			$cp = "";
			$address = "";
			$city = "";
			$first = "";
			$last = "";
			$userID = "";
			foreach ($_POST as $key => $value)
			{
				if ($key == "login" && strlen($value) > 5 && strlen($value) < 32 && ctype_alnum($value) == true)
					$log = $value;
				if ($key == "mail" && filter_var($value, FILTER_VALIDATE_EMAIL) != false)
					$mail = $value;
				if ($key == "tel" && strlen($value) == 10 && is_numeric($value) == true)
					$tel = $value;
				if ($key == "cp" && strlen($value) == 5 && is_numeric($value) == true)
					$cp = $value;
				if ($key == "address" && strlen($value) < 32)
					$address = $value;
				if ($key == "city" && strlen($value) < 32 && ctype_alnum($value) == true)
					$city = $value;
				if ($key == "first" && strlen($value) < 32 && ctype_alnum($value) == true)
					$first = $value;
				if ($key == "last" && strlen($value) < 32 && ctype_alnum($value) == true)
					$last = $value;
				if ($key == "user_id")
					$userID = $value;
			}
			if ($userID != "" && $log != "" && $mail != "" && $tel != "" && $cp != "" && $address != "" && $city != "" && $last != "" && $first != "")
			{
				$query = "UPDATE users SET login = ?, first_name = ?, last_name = ?, email = ?, telephone = ?, adress = ?, zip = ?, city = ? WHERE ID = ?";
				$sql = mysqli_prepare($mysqli, $query);
				mysqli_stmt_bind_param($sql, 'ssssssssi', $log, $first, $last, $mail, $tel, $address, $cp, $city, $userID);
				mysqli_stmt_execute($sql);
				mysqli_stmt_close($sql);
				if (isset($_POST['passwd']))
				{
					if (strlen($_POST['passwd']) > 5 && strlen($_POST['passwd']) > 5 && strlen($_POST['passwd']) < 32 && ctype_alnum($_POST['passwd']) == true)
					{
						$query = "UPDATE users SET passwd = ? WHERE ID = ?";
						$sql = mysqli_prepare($mysqli, $query);
						$passwd = hash('whirlpool', $_POST['passwd']);
						mysqli_stmt_bind_param($sql, 'si', $passwd, $userID);
						mysqli_stmt_execute($sql);
						mysqli_stmt_close($sql);
					}
					else {
						echo 'Le format du mot de passe est invalide, il n\'a pas été modifié<br />';
					}
				}
				echo 'Le compte a été modifié! Redirection... <meta http-equiv="refresh" content="3; URL=./admin_users.php">';
				die;
			}
			else {
				echo 'Error: Champ invalide. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_users.php">';
				die;
			}
		} else if ($_POST['action'] == "del") {
			if (isset($_POST['ID'])) {
				$query = mysqli_prepare($mysqli, "DELETE FROM users WHERE ID = ?");
				mysqli_stmt_bind_param($query, 'i', $_POST['ID']);
				mysqli_stmt_execute($query);
				mysqli_stmt_close($query);
			}
		} else if ($_POST['action'] == "Ajouter") {
			$log = "";
			$passwd = "";
			$mail = "";
			$tel = "";
			$cp = "";
			$address = "";
			$city = "";
			$first = "";
			$last = "";
			foreach ($_POST as $key => $value)
			{
				if ($key == "login" && strlen($value) > 5 && strlen($value) < 32 && ctype_alnum($value) == true)
					$log = $value;
				if ($key == "passwd" && strlen($value) > 5 && strlen($value) < 32 && ctype_alnum($value) == true)
					$passwd = $value;
				if ($key == "mail" && filter_var($value, FILTER_VALIDATE_EMAIL) != false)
					$mail = $value;
				if ($key == "tel" && strlen($value) == 10 && is_numeric($value) == true)
					$tel = $value;
				if ($key == "cp" && strlen($value) == 5 && is_numeric($value) == true)
					$cp = $value;
				if ($key == "address" && strlen($value) < 32)
					$address = $value;
				if ($key == "city" && strlen($value) < 32 && ctype_alnum($value) == true)
					$city = $value;
				if ($key == "first" && strlen($value) < 32 && ctype_alnum($value) == true)
					$first = $value;
				if ($key == "last" && strlen($value) < 32 && ctype_alnum($value) == true)
					$last = $value;
			}
			if ($passwd != "" && $log != "" && $mail != "" && $tel != "" && $cp != "" && $address != "" && $city != "" && $last != "" && $first != "")
			{
				if (verif_user($passwd, $log, $mail, $tel, $cp, $address, $city, $first, $last, $mysqli) == true)
				{
					add_user($passwd, $log, $mail, $tel, $cp, $address, $city, $first, $last, $mysqli);
					echo 'Un nouveau compte a été crée! Redirection... <meta http-equiv="refresh" content="3; URL=./admin_users.php">';
					die;
				}
				else {
					echo 'Error: Ce compte existe déjà. Redirection... <meta http-equiv="refresh" content="2; URL=./admin_users.php">';
					die;
				}
			}
			else {
				echo 'Error: Champ invalide. Redirection... <meta http-equiv="refresh" content="2; URL=./create_user.php">';
				die;
			}
		}
	}
	header('Location: ./admin_users.php');
	die;
?>