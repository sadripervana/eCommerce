<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'eCommerce/');

define('CART_COOKIE','SwHbNDP3dmIX8P0XB');
define('CART_COOKIE_EXPIRE', time() + (86400 * 30));
define('TAXRATE',0.13);

define('CURRENCY', 'usd');
define('CHECKOUTMODE','TEST'); //Change Test to LIVE when you are ready to go ive

// if(CHECKOUTMODE == 'TEST'){
// 	define('STRIPE_PRIVATE','sk_test_51JedxEDpChr5XswgNUt0a7laW2eMZoFdSYj0cIRtBN1LiYZIb38zBs8riu3e1yHudkf4aXzmWrdP51XswYFt4Ecz00xSHN1bBW');
// 	define('STRIPE_PUBLIC','pk_test_51JedxEDpChr5XswgpHwqjfRwaazGBSzj8QdIvgnE6UBmFlhxD62Gvwjyszs15ZqahxK5AqvEr4eH4Dk8QfnhJQFO00RTex0p80');
// }

if(CHECKOUTMODE == 'TEST'){
	define('STRIPE_PRIVATE','sk_test_51JdCW1H8CibGKmXC9JaX4tmTFPZeXfpyCU3foBGHzPyZgwj4RQcFdilC65sxi1yyX8yUL18py65Ex1LP5UP0DRnf00jFbdf4pZ');
	define('STRIPE_PUBLIC','pk_test_51JdCW1H8CibGKmXCn3MJVrTFze1qnlAc6EL2IaBWgHOj7asJ0Zg7Qwrrt6N63xGP2XiKj6L2OvBWhuA2FujeEEwx00PWqCe4uE');
}

if(CHECKOUTMODE == 'LIVE'){
	define('STRIPE_PRIVATE','');
	define('STRIPE_PUBLIC','');
}
?>
