<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
// require_once $_SERVER['DOCUMENT_ROOT'].'/eCommerce/core/init.php';
if(!is_loged_in()){
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

//Delete Product
if(isset($_GET['delete'])){
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted = 1 WHERE id ='$id'");
	$_SESSION['success_flash'] = 'Product successfuly deleted.';
	header('Location: products.php');
}
$dbpath = '';


if(isset($_GET['add']) || isset($_GET['edit'])){

	$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
	$desc = $db->query("DESCRIBE products");
	$describes = [];
	$variablesAdd = [];

	while ($describe = mysqli_fetch_assoc($desc)) {
		$describes[] = $describe['Field'];
	}

	$countColons = count($describes, COUNT_NORMAL );;
	for ($i = 1; $i < $countColons ; $i++) {
		// [] = [ ['title'] => ((isset($_POST['title'])?$_POST['title']:'') ];
		$variablesAdd[] = [$describes[$i] =>  issetParameter($_POST,$describes[$i])]	;
		extract($variablesAdd[$i-1]);
	}

	$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
	$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
	$sizes = rtrim($sizes, ',');
	$saved_image = '';


	if(isset($_GET['edit'])){
		$variablesEdit = [];
		$edit_id = (int)$_GET['edit'];
		$productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");

		$product = mysqli_fetch_assoc($productResults);
		if(isset($_GET['delete_image'])){
			$imgi = (int)$_GET['imgi'] - 1;
			$images = explode(',', $product['image']);
			$image_url = BASEURL . $images[$imgi];
			unlink($image_url);
			unset($images[$imgi]);
			$imageString = implode(',',$images);
			$db->query("UPDATE products SET image = '{$imageString}' WHERE id = '$edit_id'");
			$_SESSION['success_flash'] = 'Product successfuly updated!';
			header('Location: products.php?edit='.$edit_id);
		}

		$countColons = count($product);
		for ($i = 1; $i < $countColons ; $i++) {
			// [] = [ ['title'] => ((isset($_POST['title'])?$_POST['title']:$product['title']) ];
			$variablesEdit[] = [ $describes[$i] => issetParameter($_POST,$describes[$i],$product[$describes[$i]]) ]	;
			extract($variablesEdit[$i-1]);
		}
		$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
		$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
		$parentResult = mysqli_fetch_assoc($parentQ);
		$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
		$sizes = rtrim($sizes, ',');
		$saved_image = (($product['image'] != '')?$product['image']:'');
		$dbpath = $saved_image;
	}

	if(!empty($sizes)){
		$sizeString = sanitize($sizes);
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
		$sizesArray = [];
	}

	if($_POST){
		$errors = [];
		$require = ['title', 'brand', 'price', 'parent', 'child', 'sizes'];
		$allowed = ['png', 'jpg', 'jpeg', 'gif'];
		$tmpLoc = [];
		$uploadPath = [];
		foreach ($require as $field) {
			if($_POST[$field] == '') {
				$errors[] = 'All Fields With and Astrisk are required.';
				break;
			}
		}


		if($saved_image == '' ){
			if($_FILES["photo"]["error"][0] != 4){
				$photoCount = count($_FILES['photo']['name']);
				$values =	 makePhoto($photoCount,$dbpath,$allowed,$errors);
				extract($values);
			}
		}

		if(!empty($errors)){
			echo display_errors($errors);
		} else {
			if($_FILES["photo"]["error"][0] != 4){
			// Upload file and insert into database
				for ($i=0; $i < $photoCount; $i++) {
					move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
				}
			}

			$insertSql = "INSERT INTO products(`title`, `price`, `list_price`, `brand`, `categories`, `sizes`, `image`, `description` ) VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$sizes', '$dbpath', '$description')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', sizes = '$sizes', image = '$dbpath', description = '$description'  WHERE id = '$edit_id'";
			}
			// var_dump($insertSql);die;
			$db->query($insertSql);
			header('Location: products.php');
		}
	}
	?>
	<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add a New');?> Product</h2>
	<form action="products.php?<?=((isset($_GET['edit']))?'edit=' . $edit_id :'add=1'); ?>" method="post" enctype="multipart/form-data">
		<div class="form-group col-md-3">
			<label for="title">Title*:</label>
			<input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="brand">Brand*:</label>
			<select class="form-control" name="brand" id="brand">
				<option value=""<?=(($brand == '')?'selected':'');?>></option>
				<?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
					<option value="<?=$b['id'];?>" <?=(($brand == $b['id'])?'selected':''); ?>><?=$b['brand']; ?>
				</option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="parent">Parent Category*:</label>
		<select class="form-control"  id="parent" name="parent">
			<option value="<?=(($parent == '')?'selected':''); ?>"></option>
			<?php while($p = mysqli_fetch_assoc($parentQuery)): ?>

				<option value="<?=$p['id'];?>" <?=(($parent == $p['id'])?'selected':'');?>><?=$p['category']; ?></option>
			<?php	 endwhile;?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="child">Child Category *</label>
		<select id="child" name="child" class="form-control"></select>
	</div>
	<div class="form-group col-md-3">
		<label for="price">Price*:</label>
		<input type="text" id="price" name="price" class="form-control" value="<?=$price; ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="list_price">List Price:</label>
		<input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price; ?>">
	</div>
	<div class="form-group col-md-3">
		<label for="quantity">Quantity & Sizes*:</label>
		<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
	</div>
	<div class="form-gorup col-md-3">

		<label for="sizes">Sizes & Quantity Preview</label>
		<input type="text" name="sizes" class="form-control" id="sizes" value="<?=$sizes; ?>" readonly>
	</div>
	<div class="form-group col-md-6">
		<?php if($saved_image != ''): ?>
			<?php
			$imgi = 1;
			$images = explode(',',$saved_image);
			foreach($images as $image):
				?>
				<div class="saved-image col-md-4">
					<img src="<?=$image;?>" alt="saved-image" class="img-thumb"/>
					<a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete image</a>
				</div>
				<?php
				$imgi++;
			endforeach; ?>
		<?php else: ?>
			<label for="photo">Product Photo:</label>
			<input type="file" name="photo[]" id="photo" class="form-control" multiple>
		<?php endif; ?>
	</div>

	<div class="form-group col-md-3">
		<label for="discription">Description</label>
		<textarea name="description" id="description" class="form-control" cols="30" rows="5"><?=$description;?></textarea>
	</div>
	<div class="form-group pull-right">
		<a href="products.php" class="btn btn-default">Cancel</a>
		<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add a New');?> Product" class="btn btn-success " >
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
			<th>Product</th>
			<th>Price</th>
			<th>Category</th>
			<th>Featured</th>
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
						<a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="far fa-edit"></i></a>
						<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="fal fa-times"></i></a>
					</td>
					<td>
						<?=$product['title']; ?>
						<?php $photos = explode(',', $product['image']);?>
						<img style="height: 20px; width: auto; float: right;" src="../<?=$photos[0];?>" alt="<?=$product['title'];?>" class="img-thumb" />
					</td>
					<td><?=money($product['price']); ?></td>
					<td><?=$category; ?></td>
					<td><a href="products.php?featured=<?=(($product['featured'] == 0))?'1':'0' ;?>&id=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featured'] == 1))?'minus':'plus' ;?>"></span>
					</a>&nbsp <?= (($product['featured'] == 1)? 'Featured Product':''); ?></td>
					<td><?=$product['sold']; ?></td>
				</tr>

			<?php endwhile; ?>
		</tbody>
	</table>



<?php } include 'includes/footer.php'; ?>

<script>
	jQuery('document').ready(function() {
		get_child_options('<?=$category;?>');
		// updateSizes();
	});
</script>
