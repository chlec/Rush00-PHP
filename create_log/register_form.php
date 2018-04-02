<?PHP

include "../lib/init.php";
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

$log = "";
$passwd = "";
$submit = false;
$mail = "";
$tel = "";
$cp = "";
$address = "";
$city = "";
$first = "";
$last = "";
foreach ($_POST as $key => $value)
{
	if ($key == "submit")
	{
		if ($value == "Inscription")
			$submit = true;
	}
}
if ($submit == true)
{
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
			echo 'Votre compte à été crée avec succès! Redirection... <meta http-equiv="refresh" content="3; URL=/index.php">';
			$_SESSION['logged_in_user'] = $log;
		}
		else
			echo 'Error: Ce compte existe déjà. Redirection... <meta http-equiv="refresh" content="2; URL=./register.php">';

	}
	else
		echo 'Error: Champ invalide. Redirection... <meta http-equiv="refresh" content="2; URL=./register.php">';
}
else if ($submit == false)
	echo "ERROR\n";

?>
