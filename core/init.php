<?php 

$db = mysqli_connect('localhost','admin','admin','supermario');
if(mysqli_connect_errno()){
	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/config.php';
require_once BASEURL . 'helpers/helpers.php';