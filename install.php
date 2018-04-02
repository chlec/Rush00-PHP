<?php
	if (isset($_POST['submit']) && $_POST['submit'] == 'OK')
	{
		if (isset($_POST['server']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['bdd']))
		{
			$server = $_POST['server'];
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			$bdd = $_POST['bdd'];
			$db = @new mysqli($server, $user, $pass, $bdd);
			if ($db->connect_errno) {
			    echo "Error: Les données sont incorrectes.";
			}
			else {
				$templine = '';

				$lines = file("db.sql");
				foreach ($lines as $line)
				{
					if (substr($line, 0, 2) == '--' || $line == '')
					    continue;

					$templine .= $line;
					if (substr(trim($line), -1, 1) == ';')
					{
					    mysqli_query($db, $templine);
					    $templine = '';
					}
				}
				file_put_contents('lib/db.php',
					'<?php' . "\n" .
					'$db_host = "' . $server . '";' . "\n" .
					'$db_user = "' . $user . '";' . "\n" .
					'$db_pass = "' . $pass . '";' . "\n" .
					'$db_name = "' . $bdd . '";' . "\n" .
					'?>');
				unlink("install.php");
				header('Location: index.php');
				die;
			}
		}
	}
?>
<html>
<head>
	<title>Installation</title>
</head>
<body>
	<center>
		<h3>Installation de la base de donnée</h3>
		<form method="POST" action="install.php">
			Serveur: <input type="text" name="server">
			<br />
			Nom d'utilisateur: <input type="text" name="user">
			<br />
			Mot de passe: <input type="password" name="pass">
			<br />
			Base de donnée: <input type="text" name="bdd">
			<br />
			<input type="submit" name="submit" value="OK">
		</form>
	</center>
</body>
</html>