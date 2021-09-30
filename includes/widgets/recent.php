<h3 class="text-center">Popular Items</h3>
<?php 
$productN = $db->query("SELECT id,title,sold FROM products WHERE deleted = 0 ORDER BY sold DESC LIMIT 5");
?>
<table class="table table-condensed" id="recent_widget">
	<?php while($product2 = mysqli_fetch_assoc($productN)):
		?>
		<tr>
			<td><?=$product2['title'];?></td>
			<td><a class="text-primary" onclick="detailsmodal('<?=$product2['id'];?>')">View</a></td>
		</tr>
	<?php endwhile;?>
</table>