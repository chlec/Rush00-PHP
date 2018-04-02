<?php

function	auth($login, $passwd, $mysqli)
{
	$found = false;
	$data = mysqli_query($mysqli, "SELECT login, passwd FROM users");
	while ($tab = mysqli_fetch_assoc($data))
	{
		foreach ($tab as $key => $value)
		{
			if ($key == "login")
			{
				if ($value == $login)
					$found = true;
			}
			if ($key == "passwd" && $found == true)
			{
				if (hash("whirlpool", $passwd) == $value)
					return (true);
				else
					return (false);
			}
		}
	}
	return (false);
}

?>
