<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
if(!is_loged_in()){
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//Restore Product
if(isset($_GET['delete'])){
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted = 0 WHERE id ='$id'");
	header('Location: archived.php');
}

$sql = "SELECT * FROM products WHERE deleted = 1";
$presults = $db->query($sql);
?>

<h2 class="text-center">Archived</h2>

<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th>
		<th>Product</th>
		<th>Price</th>
		<th>Category</th>
		<th>Sold</th>
	</thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($presults)):
			$childID = $product['categories'];
			$catSql = "SELECT * FROM categories WHERE id = '$childID'";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id = '$parentID'";
			$presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].' ~ '.$child['category']; 
			?>
			<tr>
				<td>
					<a href="archived.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="fas fa-undo-alt"></i> Restore</a>
				</td>
				<td>
					<?=$product['title']; ?>
					<img src="../<?=$product['image']; ?>" style="float:right" width="25px" height="25px" alt="">
				</td>
				<td><?=money($product['price']); ?></td>
				<td><?=$category; ?></td>
				<td><?=$product['sold']; ?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
