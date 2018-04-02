<?php
include "../lib/init.php";
$logged = false;
foreach ($_SESSION as $key => $value)
{
	if ($key == "logged_in_user")
		$logged = true;
}
if ($logged == true)
	unset($_SESSION["logged_in_user"]);
header("Location: /index.php");

?>
