<?php
include "../lib/init.php";
include("auth.php");
$log = "";
$passwd = "";
$find = false;
foreach ($_POST as $key => $value)
{
	if ($key == "login")
		$log = $value;
	if ($key == "passwd")
		$passwd = $value;
}
if ($passwd != "" && $log != "")
{
	if (auth($log, $passwd, $mysqli) == true)
		$find = true;
}
else {
	echo 'Error: Remplissez les champs. Redirection... <meta http-equiv="refresh" content="2; URL=./login.php">';
	die;
}
if ($find == true)
{
	$_SESSION["logged_in_user"] = $log;
	header("Location: ../index.php");
}
else
{
	echo 'Error: Identifiant ou mot de passe incorrect. Redirection... <meta http-equiv="refresh" content="2; URL=./login.php">';
}

?>
