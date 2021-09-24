<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/PHPProjects/PHPeCommerce1/core/init.php';
unset($_SESSION['SBUser']);
header('Location: login.php');
?>