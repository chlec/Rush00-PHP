<?php
	include '../lib/init.php';
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
?>
<!DOCTYPE html>
<html>
<?php include '../lib/header.php'; ?>
<body>
	<?php include '../lib/navbar.php'; ?>
	<div class="admin_users_content">
		<table style="width: 100%;">
			<caption>All Users <a class="button_add right" href="create_user.php">Add User</a></caption>
			<tr>
				<th>Login</th>
				<th>Email</th>
				<th>First name</th>
				<th>Last Name</th>
				<th>Edit</th>
			</tr>
				<?php
					$data = mysqli_query($mysqli, "SELECT * FROM users ORDER BY ID DESC");
					while ($tab = mysqli_fetch_assoc($data))
					{
						echo '<tr>';
						echo '<td><center>' . $tab['login'] . '</center></td>';
						echo '<td><center>' . $tab['email'] . '</center></td>';
						echo '<td><center>' . $tab['first_name'] . '</center></td>';
						echo '<td><center>' . $tab['last_name'] . '</center></td>';
						echo '<td><center>' . '<a class="edit" href="edit_user.php?id='. $tab['ID'].'">Edit</a> / <a class="edit" id="delete_user" user_id="'. $tab['ID'].'">Delete</a>' . '</center></td>';
						echo '</tr>';
					}
				?>
		</table>
		<script type="text/javascript">

			document.querySelectorAll('#delete_user').forEach(link => {
				link.onclick = function() {
					let ID = this.getAttribute('user_id')
					let confirmation = confirm("Confirmer la suppression de l'utilisateur ?")
					if (confirmation)
						post('update_user.php', { action: 'del', ID: ID })
				}
			})

			function post(path, params, method) {
			    method = method || "post"
			    let form = document.createElement("form")
			    form.setAttribute("method", method)
			    form.setAttribute("action", path)

			    for (let key in params) {
			        if (params.hasOwnProperty(key)) {
			            let hiddenField = document.createElement("input")
			            hiddenField.setAttribute("type", "hidden")
			            hiddenField.setAttribute("name", key)
			            hiddenField.setAttribute("value", params[key])

			            form.appendChild(hiddenField)
			        }
			    }

			    document.body.appendChild(form)
			    form.submit()
			}
		</script>
</body>
</html>