<?php 
	require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';
 ?>

<!-- Main content -->
<div class="col-md-8">
	<div class="row">
		<h2 class="text-center">
			Feature Products
		</h2>
		<div class="col-md-3">
			<h4>Levis Jeans</h4>
			<img src="images/products/s1.png" alt="Levis Jeans" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$54.99</s>
			</p>
			<p class="price">
			Our Price: $19.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Hollister Shirt</h4>
			<img src="images/products/s2.jpg" alt="Levis Jeans" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$24.99</s>
			</p>
			<p class="price">
			Our Price: $19.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Fancy SHoes</h4>
			<img src="images/products/s3.jpg" alt="Fancy SHoes" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$69.99</s>
			</p>
			<p class="price">
			Our Price: $49.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Boys Hoodie</h4>
			<img src="images/products/s4.png" alt="Boys Hoodie" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$24.99</s>
			</p>
			<p class="price">
			Our Price: $18.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Girls Dress</h4>
			<img src="images/products/s5.png" alt="Girls Dress" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$34.99</s>
			</p>
			<p class="price">
			Our Price: $22.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>


		<div class="col-md-3">
			<h4>Woman's Shirt</h4>
			<img src="images/products/s6.png" alt="Woman's Shirt" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$45.99</s>
			</p>
			<p class="price">
			Our Price: $29.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Women's Skirt</h4>
			<img src="images/products/s7.png" alt="Women's Skirt" class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$19.99</s>
			</p>
			<p class="price">
			Our Price: $8.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>

		<div class="col-md-3">
			<h4>Purse</h4>
			<img src="images/products/s8.jpg" alt="Purse"  class="img-thumb" />
			<p class="list-price text-danger">
				List Price <s>$49.99</s>
			</p>
			<p class="price">
			Our Price: $39.99
			</p>
			<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
			Details
			</button>
		</div>
	</div>				
</div>

<?php 
	include 'includes/detailsmodal.php';
	include 'includes/rightbar.php';
	include 'includes/footer.php';
?>