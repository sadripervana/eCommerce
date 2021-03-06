<?php 
require_once 'core/init.php';

if(empty($_POST)){
	header("Location: index.php");
}

// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Get the rest of the post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
$charge_amount = number_format((int)$grand_total,2)*100;
$metadata = array(
	"cart_id" 	=> $cart_id,
	"tax" 		=> $tax,
	"sub_total" => $sub_total,
);

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = \Stripe\Charge::create(array(
		"amount" => $charge_amount, //amount in cents, again
		"currency" => CURRENCY,
		"source" => $token,
		"description" => $description,
		"receipt_email" => $email,
		"metadata" => $metadata)
);

//adjust inventory
	$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$iresults = mysqli_fetch_assoc($itemQ);
	$items = json_decode($iresults['items'],true);
	foreach ($items as $item) {
		$newSizes = array();
		$item_id = $item['id'];
		$productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
		$product = mysqli_fetch_assoc($productQ);
		$sizes = sizesToArray($product['sizes']);
		foreach($sizes as $size){
			if($size['size'] == $item['size']){
				$q = $size['quantity'] - $item['quantity'];
				$newSizes[] = array('size' => $size['size'], 'quantity' => $q);
			} else {
				$newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
			}
		}
		$sizeString = sizesToString($newSizes);
		$db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
	}

//update cart
	$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
	$db->query("UPDATE products SET sold = '{$item['quantity']}' WHERE id = '{$item['id']}'");
	$db->query("INSERT INTO transactions 
		(charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,tax,grand_total,description,txn_type) VALUES 
		('$charge->id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$charge->object')");
	$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	setcookie(CART_COOKIE,'',1,"/",$domain,false);

	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerpartial.php';

	?>

	<h1 class="text-center text-success">Thank You!</h1>
	<p> Your card has been successfully charged <strong><?=money($grand_total);?></strong>. You have been emailed a receipt. Please check your spam folder if it's not in your inbox. <br>
	Additionally you can print this page as a receipt. </p>
	<p>Your receipt number is: <strong><?=$cart_id;?></strong></p>
	<p>Your order will be shipped to the address below.</p>
	<address>
		<label for="full_name">Full Name:</label>
		<?=$full_name;?><br>
		<label for="street">Street Addres:</label>
		<?=$street;?><br>
		<?=(($street2 != '')?'<label for="street">Street Addres 2:</label>
		'.$street2.'<br>':'');?>
		<label for="city">City:</label><?=$city.', '.$state.' '.$zip_code;?><br>
		<label for="state">State:</label><?=$country;?><br>
	</address>

	<?php
	include 'includes/footer.php';

} catch(\Stripe\Error\Card $e) {
	// The card has been declined
	echo $e;
} 

?>
