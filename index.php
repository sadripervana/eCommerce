<?php 
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';

$sql ="SELECT * FROM products WHERE featured = 1";

$featured = $db-> query($sql);
?>

<!-- Main content -->
<div class="col-md-8">
	<div class="row">
		<h2 class="text-center">
			Feature Products
		</h2>
		<?php while($product = mysqli_fetch_assoc($featured)) : ?>
			<div class="col-md-3"> 
				<h4><?= $product['title']; ?></h4>
				<?php $photos = explode(',',$product['image']); ?>
				<img src="<?=$photos[0];?>" alt="<?=$product['title'];?>" class="img-thumb" />
				<p class="list-price text-danger">
					<?php 
					if($product['list_price'] != '0.00'){
						echo	'List Price <s>$'.	$product['list_price'] .'</s>';
					}
					?>
				</p>
				<p class="price">
					Our Price: $<?= $product['price']; ?>
				</p>
				<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id'];?>)">
					Details
				</button>
			</div>
		<?php endwhile; ?>
	</div>				
</div>
<p></p>
<?php 
include 'includes/rightbar.php';
include 'includes/footer.php';
?>