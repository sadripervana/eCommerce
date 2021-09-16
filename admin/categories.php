<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
?>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
	<div class="col-md-6"></div>

	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Category</th>
				<th>Parent</th>
				<th></th>
			</thead>
			<tbody>
				<tr>
					<td>Shirts</td>
					<td>Men</td>
					<td>
						<a href="categories.php?edit=1" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>	
						<a href="categories.php?delete=1" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span>X</a>

					</td>
				</tr>
			</tbody>
	  </table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>