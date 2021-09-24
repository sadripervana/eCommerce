<?php 
	require_once '../core/init.php';
	if(!is_loged_in()){
		login_error_redirect();
	}
	include 'includes/head.php';
	include 'includes/navigation.php';
	if(isset($_GET['delete'])){
		$delete_id = sanitize($_GET['delete']);
		$db->query("DELETE FROM users WHERE id = '$delete_id'");
		$_SESSION['success_flash'] = 'USER has been deleted!';
		header('Location: users.php');
	}
	if(isset($_GET['add']) || isset($_GET['edit'])){
		$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
		$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
		$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
		$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
		$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
		$errors = [];

		if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$userResults = $db->query("SELECT * FROM users WHERE id = '$edit_id'");
			$users = mysqli_fetch_assoc($userResults);

			$name = ((isset($_POST['name']) && $_POST['name'] != '')?sanitize($_POST['name']):$users['full_name']);
			$email = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):$users['email']);
			$password = ((isset($_POST['password']) && $_POST['password'] != '')?sanitize($_POST['password']):'');;
			$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] != '')?sanitize($_POST['confirm']):'');;
			$permissions = ((isset($_POST['permissions']) && $_POST['permissions'] != '')?sanitize($_POST['permissions']):$users['permissions']);

		}

		if($_POST){
			$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
			$emailCount = mysqli_num_rows($emailQuery);

			if($emailCount != 0 && isset($_GET['add'])){
				$errors[] = 'That email already exists in our database.';
			}
			$required = ['name', 'email', 'password','confirm', 'permissions'];
			foreach ($required as $f) {
				if(empty($_POST[$f])  && isset($_GET['add'])){
					$errors[] = 'You must fill out all fields.';
					break;
				}
			}
			if(strlen($password) < 6  && isset($_GET['edit']) && $password != '') {
				$errors[] = 'Your password must be at least 6 characters.';
			}


			if($password != $confirm){
				$errors[] = "Your passwords do not match.";
			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = "You must enter a valid email";
			}



			if(!empty($errors)){
				echo display_errors($errors);
			} else {
				// add user to database
				$hashed = password_hash($password, PASSWORD_DEFAULT);
				$insertSql = ("INSERT INTO users (full_name, email, password, permissions) VALUES ('$name', '$email', '$hashed', '$permissions')");
				$_SESSION['success_flash'] = 'User has been added!';

				if(isset($_GET['edit']) && $password != ''){
				$insertSql = "UPDATE users SET full_name = '$name', email = '$email', password = '$hashed', permissions = '$permissions' WHERE id = '$edit_id'";
				$_SESSION['success_flash'] = 'User has been modified!';
				} else {
					$insertSql = "UPDATE users SET full_name = '$name', email = '$email', permissions = '$permissions' WHERE id = '$edit_id'";
					$_SESSION['success_flash'] = 'User has been modified without password!';
				}
				
				$db->query($insertSql);
				header('Location: users.php');
			}
		}

?>
	<h2 class="text-center">Add A New User</h2><hr>
	<form action="users.php?<?=((isset($_GET['edit']))?'edit=' . $edit_id :'add=1'); ?>" method="post">
		<div class="form-group col-md-6 ">
			<label for="name">Full Name:</label>
			<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
		</div>
		<div class="form-group col-md-6 ">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group col-md-6 ">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group col-md-6 ">
			<label for="confirm">Confirm Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>
		<div class="form-group col-md-6 ">
			<label for="name">Permissions:</label>
			<select name="permissions" id="permissions" class="form-control">
				<option value=""<?=(($permissions == '')?' selected': '');?>></option>
				<option value="editor"<?=(($permissions == 'editor')?' selected': '');?>>Editor</option>
        <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected': '');?>>Admin</option>
      </select>
		</div>
		<div class="form-group col-md-6 text-right" id="add-users-btn">
			<a href="users.php" class="btn btn-default">Cancel</a>
			<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add a New');?> User" class="btn btn-primary">
		</div>
	</form>
<?php
	} else {


	$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");

?>
<h2 class="text-center">Users</h2><hr>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add New User</a>
<table class="table table-bordered table-striped table-condensed">
	<thead>
		<th></th>
		<th>Name</th>
		<th>Email</th>
		<th>Join Date</th>
		<th>Last Login</th>
		<th>Permissions</th>
	</thead>
	<tbody>
		<?php while($user = mysqli_fetch_assoc($userQuery)): ?>
			<tr>
				<td>
					<?php if($user['id'] != $user_data['id']): ?>
						<a href="users.php?edit=<?=$user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href="users.php?delete=<?=$user['id'];?>" class="btn btn-default btn-xs">X</a>
					<?php endif; ?>
				</td>
				<td><?=$user['full_name'];?></td>
				<td><?=$user['email'];?></td>
				<td><?=pretty_date($user['join_date']);?></td>
				<td><?=(($user['last_login'] == '')?'Never':pretty_date($user['last_login']));?></td>
				<td><?=$user['permissions'];?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php } include 'includes/footer.php'; ?>