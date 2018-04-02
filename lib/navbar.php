<div class="navbar">
	<ul class="menu">
		<li><a href="/index.php">Accueil</a></li>
		<li><a href="/products.php">Produits</a></li>
		<li><a href="/cart.php">Panier<?php echo isset($_SESSION['item_in_cart']) ? ' ('.$_SESSION['item_in_cart'].')' : ''; ?></a></li>
		<?php
			if (isset($_SESSION['logged_in_user']))
			{
				echo '<li><a href="/create_log/myaccount.php">Mon compte</a></li>';
				$query = mysqli_query($mysqli, "SELECT rank FROM users WHERE login = '" . $_SESSION['logged_in_user'] . "' LIMIT 1");
				$row = mysqli_fetch_assoc($query);
				$rank = $row['rank'];
				if ($rank == 1)
					echo '<li><a href="/admin_file/">Admin</a></li>';
				echo '<li><a href="/create_log/logout.php">Déconnexion</a></li>';
			}
			else 
			{
		?>
		<li><a href="/create_log/login.php">Connexion</a></li>
		<li><a href="/create_log/register.php">Inscription</a></li>
		<?php
			}
		?>
	</ul>
</div>