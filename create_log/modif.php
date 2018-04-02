<?PHP

include "../lib/init.php";
function	verif_user($newpw, $oldpw, $log, $mysqli)
{
	$found = false;
	$data = mysqli_query($mysqli, "SELECT login,passwd FROM users");
	while ($tab = mysqli_fetch_assoc($data))
	{
		foreach ($tab as $key => $value)
		{
			if ($key == "login")
			{
				if ($value == $log)
					$found = true;
			}
			if ($key == "passwd" && $found == true)
			{
				if (hash("whirlpool", $oldpw) == $value)
					return (true);
				else
					return (false);
			}
		}
	}
	return (false);
}

function	modif_user($newpw, $oldpw, $log, $mysqli)
{
	$data = mysqli_query($mysqli, "SELECT login, passwd FROM users");
	$found = false;
	while ($tab = mysqli_fetch_assoc($data))
	{
		foreach ($tab as $key => $value)
		{
			if ($key == "login")
			{
				if ($value == $log)
					$found = true;
			}
			if ($key == "passwd" && $found == true)
			{
				$passwd = hash("whirlpool", $newpw);
				mysqli_query($mysqli, "UPDATE users SET passwd='$passwd' WHERE login='$log'");
				return ;
			}
		}
	}
}

$log = "";
$newpw = "";
$oldpw = "";
$submit = false;
foreach ($_POST as $key => $value)
{
	if ($key == "submit")
	{
		if ($value == "Modifier")
			$submit = true;
	}
}
if ($submit == true)
{
	foreach ($_POST as $key => $value)
	{
		if ($key == "login")
			$log = $value;
		if ($key == "oldpw")
			$oldpw = $value;
		if ($key == "newpw" && strlen($value) > 5 && strlen($value) < 32 && ctype_alnum($value) == true)
			$newpw = $value;
	}
	if ($newpw != "" && $oldpw != "" && $log != "")
	{
		if (verif_user($newpw, $oldpw, $log, $mysqli) == true)
		{
			modif_user($newpw, $oldpw, $log, $mysqli);
			echo 'Votre compte a bien été modifié. Redirection... <meta http-equiv="refresh" content="2; URL=/index.php">';;
		}
		else
			echo 'Error: Identifiant ou mot de passe incorrect. Redirection... <meta http-equiv="refresh" content="2; URL=./myaccount.php">';

	}
	else
		echo 'Error: Remplissez les champs. Redirection... <meta http-equiv="refresh" content="2; URL=./myaccount.php">';
}
else if ($submit == false)
	echo "ERROR\n";

?>
