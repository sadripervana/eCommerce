
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT']. '/PHPProjects/PHPeCommerce1/core/init.php';
$parentID = (int)$_POST['parentID'];
$selected = sanitize($_POST['selected']);
$childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
ob_start();
?>

<option value=""></option>
<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
	<option value="<?=$child['id'];?>"<?=(($selected == $child['id'])?' selected':'');?>><?=$child['category'];?></option>
<?php endwhile; ?>

<?php 
echo ob_get_clean();
?>