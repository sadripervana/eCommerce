<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
if(!is_loged_in()){
	login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed =  password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = [];
?>
<style>
body{
	background-image: url(/PHPProjects/PHPeCommerce1/images/headerlogo/bg1.jpg);
	background-size: 100vh 100vh;
	background-attachment: fixed;
}
</style>
<div id="login-form">
	<div>
		
		<?php 
		if($_POST){
				//Form validation
			if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = "You must fill out all fields.";
			}
			
				//password is more than 6 characters
			if(strlen($password) < 6){
				$errors[] = "Password must be at least 6 characters.";
			}

				//if new password matches confirm
			if($password != $confirm){
				$errors[] = 'The new password and confrim new password does not match!';
			}


			if(!password_verify($old_password, $hashed)){
				$errors[] = "The old password does ont match our records.";	
			}

				//check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			} else {
					//change password
				$db->query("UPDATE users SET password = '$new_hashed' WHERE id ='$user_id'");
				$_SESSION['success_flash'] = 'Your password has been updated!';
				header('Location: index.php');
			}

		}

		?>

	</div>
	<h2 class="text-center">
		Change Password
	</h2> <hr>
	<form action="change_password.php" method="post" >
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<label for="confirm">Confirm New Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>
		<div class="form-group">
			<a href="index.php" class="btn tbn-default">Cancel</a>
			<input type="submit" value="Change Password" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/PHPProjects/PHPeCommerce1/index.php" alt="home">Visiti Site</a></p>
</div>

<?php include 'includes/footer.php'; ?>
