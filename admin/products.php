<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($_GET['add'])){
$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
if($_POST){
	$title = sanitize($_POST['title']);
	$brand = sanitize($_POST['brand']);
	$category = sanitize($_POST['child']);
	$price = sanitize($_POST['price']);
	$list_price = sanitize($_POST['list_price']);
	$sizes = sanitize($_POST['sizes']);
	$description = sanitize($_POST['description']);
	$dbpath = '';
	$errors = array();
	if(!empty($_POST['sizes'])){
		$sizeString = sanitize($_POST['sizes']);
		$sizeString = rtrim($sizeString, ',');
		$sizesArray = explode(',', $sizeString);
		$sArray = array();
		$qArray = array();
		foreach($sizesArray as $ss){
			$s = explode(':', $ss);
			$sArray[] = $s[0];
			$qArray[] = $s[1];
		}
	} else {
		$sizesArray = array();
	}
	$require = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
	foreach ($require as $field) {
		if($_POST[$field] == '') {
			$errors[] = 'All Fields With and Astrisk are required.';
			break;
		}
	}
	if(!empty($_FILES)){
		var_dump($_FILES);
		$photo = $_FILES['photo'];
		$name = $photo['name'];
		$nameArray = explode('.',$name);
		$fileName = $nameArray[0];
		$fileExt = $nameArray[1];
		$mime = explode('/', $photo['type']);
		$mimeType = $mime[0];
		$mimeExt = $mime[1];
		$tmpLoc = $photo['tmp_name'];
		$fileSize = $photo['size'];
		$allowed = array('png', 'jpg', 'jpeg', 'gif');
		$uploadName = md5(microtime()) . '.' . $fileExt;
		$uploadPath = BASEURL.'images/products/' . $uploadName;
		$dbpath = 'images/products/' . $uploadName;
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
	if(!empty($errors)){
		echo display_errors($errors);
	} else {
		//Upload file and insert into database
	move_uploaded_file($tmpLoc, $uploadPath);
	$insertSql = "INSERT INTO products(`title`, `price`, `list_price`, `brand`, `categories`, `sizes`, `images`, `description`) VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$sizes', '$dbpath', '$description')";
	if(isset($_GET['edit'])){
		$insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id = '$edit_id'";
	}
	$db->query($insertSql);
	header('Location: products.php');
}
}
?>
<h2 class="text-center">Add a New Product</h2>
<form action="products.php?add=1" method="post" enctype="multipart/form-data">
	<div class="form-group col-md-3">
		<label for="title">Title*:</label>
		<input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title'])))?sanitize($_POST['title']):''; ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="brand">Brand*:</label>
		<select class="form-control" name="brand" id="brand">
			<option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '') ?'selected':'');?>></option>
			<?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
				<option value="<?=$brand['id']; ?>" <?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id']))?'selected':'' ?>><?=$brand['brand']; ?>
				</option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="parent">Parent Category*:</label>
		<select class="form-control"  id="parent" name="parent">
			<option value="<?=((isset($_POST['parent']) && $_POST['parent'] == ''))?'selected':''; ?>"></option>
			<?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
				<option value="<?=$parent['id'];?>" <?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id']))?'select':''; ?>><?=$parent['category']; ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="child">Child Category *</label>
		<select id="child" name="child" class="form-control"></select>
	</div>
	<div class="form-group col-md-3">
		<label for="price">Price*:</label>
		<input type="text" id="price" name="price" class="form-control" value="<?=((isset($_POST['price'])))?$_POST['price']:''; ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="list_price">List Price:</label>
		<input type="text" id="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?$_POST['list_price']:''); ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="quantity">Quantity & Sizes*:</label>
		<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
	</div>
	<div class="form-gorup col-md-3">
		<label for="sizes">Sizes & Quantity Preview</label>
		<input type="text" name="sizes" class="form-control" id="sizes" value="<?=((isset($_POST['sizes']))?sanitize($_POST['sizes']):''); ?>" readonly>
	</div>
	<div class="form-group col-md-6">
		<label for="photo">Product Photo:</label>
		<input type="file" name="photo" id="photo" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="discription">Description</label>
		<textarea name="description" id="description" class="form-control" cols="30" rows="10"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
	</div>
	<div class="form-group pull-right">
		
	<input type="submit" value="Add Product" class="form-control btn btn-success" >

	</div>
	<div class="clearfix"></div>
</form>

<!-- Modal -->
<div class=" modal fade " id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Size & Quantity</h4>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        <?php for($i = 1; $i <= 12 ;$i++): ?>
        	<div class="form-group col-md-4">
        		<label for="size<?=$i;?>">Size:</label>
        		<input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1] :'' );?>" class="form-control">
        	</div>
        	<div class="form-group col-md-2">
        		<label for="qty<?=$i;?>">Quantity:</label>
        		<input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1] :'' );?>" min="0" class="form-control"> 
        	</div>
        <?php endfor; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- End Modal -->

<?php
} else {
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);
if(isset($_GET['featured'])){
	$id = (int)$_GET['id'];
	$featured = (int)$_GET['featured'];
	$featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
	$db->query($featuredsql);
	header('Location: products.php');
}
?>

<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a>
<div class="clearfix"></div>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th>
		<th>Products</th>
		<th>Price</th>
		<th>Category</th>
		<th>Feature</th>
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
					<a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default">X</a>

				</td>
				<td>
					<?=$product['title']; ?>
				</td>
				<td><?=money($product['price']); ?></td>
				<td><?=$category; ?></td>
				<td><a href="products.php?featured=<?=(($product['featured'] == 0))?'1':'0' ;?>&id=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featured'] == 1))?'minus':'plus' ;?>"></span>
				</a>&nbsp <?= (($product['featured'] == 1)? 'Featured Product':''); ?></td>
				<td>0</td>
			</tr>

		<?php endwhile; ?>
	</tbody>
</table>



 <?php } include 'includes/footer.php'; ?>

 <script>
	jQuery('document').ready(function() {
		get_child_options('<?=$category;?>');
		
	});
</script>