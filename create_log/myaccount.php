<?php
	include '../lib/init.php';
	if (!isset($_SESSION['logged_in_user'])) {
		header("Location: /index.php");
		die;
	}
	if (isset($_POST['del']) && isset($_SESSION['logged_in_user']))
	{
		mysqli_query($mysqli, "DELETE FROM users WHERE login='" . $_SESSION['logged_in_user'] . "'");
		unset($_SESSION['logged_in_user']);
		header("Location: /index.php");
		die;
	}
?>
<!DOCTYPE html>
<html>
<?php include '../lib/header.php'; ?>
<body>
	<?php include '../lib/navbar.php'; ?>
	<div class="login_content">
		<h3><u>Changer mon mot de passe</u></h3>
		<form action="modif.php" method="post">
			<input type="hidden" value="<?php echo $_SESSION['logged_in_user']; ?>" name="login" />
			<div class="input"><p>Ancien mot de passe</p> <input class="input_text" type="password" name="oldpw" /></div>
			<div class="input"><p>Nouveau mot de passe</p> <input class="input_text" type="password" name="newpw" /></div>
			<input type="submit" name="submit" value="Modifier" class="button" />
		</form>
		<form action="myaccount.php" id="deleteForm" method="POST">
			<input type="submit" name="del" value="Supprimer mon compte" class="button_warning" />
		</form>
	</div>
	<script type="text/javascript">
		document.getElementsByName("del")[0].addEventListener("click", function(event){
    		let confirmation = confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irreversible.')
    		if (!confirmation)
    			event.preventDefault()
		})
	</script>
</body>
</html>