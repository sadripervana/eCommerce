<?php 

$db = mysqli_connect('localhost','admin','admin','supermario');
if(mysqli_connect_errno()){
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
}

define('BASEURL', '/PHPeCommerce1/');