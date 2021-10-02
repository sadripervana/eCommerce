<?php
function display_errors($errors){
	$display = '<ul style="margin-top: 60px;" class="bg-danger">';
	foreach($errors as $error){
		$display .= '<li class="text-danger">'.$error.'</li>';
	}
	$display .= '</ul>';
	return $display;
}

function sanitize($dirty) {
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function money($number){
	return '$'.number_format($number,2);
}

function login($user_id){
	$_SESSION['SBUser'] = $user_id;
	global $db;
	$date = date("Y-m-d H:i:s");
	$db->query("UPDATE users SET last_login = '$date' WHERE id = '$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in!';
	header('Location: index.php');
}

function is_loged_in(){
	if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
		return true;
	}
	return false;
}

function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must be logged in to access that page.';
	header('Location: '.$url);
}

function permission_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You do not have permission to access that page.';
	header('Location: '.$url);
}

function has_permission($permission = 'admin'){
	global $user_data;
	$permissions = explode(',', $user_data['permissions']);
	if(in_array($permission, $permissions,true)){
		return true;
	}
	return false;
}

function pretty_date($date){
	return date("M d, Y h:i A", strtotime($date));
}

function get_category($child_id){
	global $db;
	$id = sanitize($child_id);
	$sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
	FROM categories c
	INNER JOIN categories p
	ON c.parent = p.id
	WHERE c.id = '$id'";
	$query = $db->query($sql);
	$category = mysqli_fetch_assoc($query);
	return $category;
}


function sizesToArray($string){
	$sizesArray = explode(',',$string);
	$returnArray = array();
	foreach($sizesArray as $size){
		$s = explode(':',$size);
		$returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
	}
	return $returnArray;
}


function sizesToString($sizes){
	$sizeString = '';
	foreach($sizes as $size){
		$sizeString .= $size['size'].':'.$size['quantity'].',';
	}
	$trimmed = rtrim($sizeString, ',');
	return $trimmed;
}

function issetParameter($post, $key, $returnValue = ''){
		// $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	if(isset($post[$key]) && $post[$key] != ''){
		return sanitize($post[$key]);
	} else {
		return $returnValue;
	}
}

function makePhoto($photoCount,$dbpath,$allowed,$errors){
 if($_FILES["photo"]["error"][0] != 4){
	 for($i = 0; $i < $photoCount; $i++){
		 $name = $_FILES['photo']['name'][$i];
		 $nameArray = explode('.',$name);
		 $fileName = $nameArray[0];
		 $fileExt = $nameArray[1];
		 $mime = explode('/', $_FILES['photo']['type'][$i]);
		 $mimeType = $mime[0];
		 $mimeExt = $mime[1];
		 $tmpLoc[] = $_FILES['photo']['tmp_name'][$i];

		 $fileSize = $_FILES['photo']['size'][$i];
		 $uploadName = md5(microtime().$i) . '.' . $fileExt;
		 $uploadPath[] = BASEURL.'images/products/' . $uploadName;
		 if($i != 0){
			 $dbpath .= ',';
		 }
		 $dbpath .= '/eCommerce/images/products/' . $uploadName;
		 if($mimeType != 'image'){
			 $errors[] = 'The File must be an image.';
		 }
		 if(!in_array($fileExt, $allowed)){
			 $errors[] = 'The photo extension must be a png, jpg, jpeg, or gif.';
		 }
		 if($fileSize > 150000000){
			 $errors[] = 'The fileSize must be under 15MB';
		 }
		 if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
			 $errors[] = 'File extension does not match the file.';
		 }
	  }
	}

	$variables = [
		'tmpLoc'=>$tmpLoc,
    'uploadPath'=>$uploadPath,
    'dbpath'=>$dbpath ,
	  'errors' => $errors
	];
 return $variables;
}
?>
