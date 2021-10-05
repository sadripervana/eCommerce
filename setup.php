<!DOCTYPE html> <!-- Database setup.php -->
<html>
<head>
	<title>Setting up database</title>
</head>
<body>
	<h3>Setting up...</h3>

	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$host = 'localhost';      // Change as necessary
  $user = 'admin';    		  // Change as necessary
  $pass = 'admin';          // Change as necessary
  $database = 'ecommerce';  // Change as necessary
  $db = mysqli_connect($host, $user, $pass, $database);
  if(mysqli_connect_errno()){
  	echo 'Database connection failed with following errors: ' . mysqli_connect_error();
  	die();
  }

	//function to execute
  function queryMysql($query)
  {
  	global $db;
  	return $db->query($query);
  }

  queryMysql(
  	'CREATE TABLE `brand` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`brand` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;'
);
  echo "Table <strong> brand </strong> created ! <br>";

  queryMysql(
  	"CREATE TABLE `cart` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`items` text NOT NULL,
  	`expire_date` datetime NOT NULL,
  	`paid` tinyint NOT NULL DEFAULT '0',
  	`shipped` tinyint NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
  echo "Table <strong> cart </strong> created ! <br>";


  queryMysql("
  	CREATE TABLE `categories` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`category` varchar(255) NOT NULL,
  	`parent` int NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
  echo "Table <strong> categories </strong> created ! <br>";


  queryMysql(
  	"CREATE TABLE `products` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`title` varchar(255) NOT NULL,
  	`price` decimal(10,2) NOT NULL,
  	`list_price` double(10,2) NOT NULL,
  	`brand` int NOT NULL,
  	`categories` varchar(255) NOT NULL,
  	`image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  	`description` text NOT NULL,
  	`featured` tinyint DEFAULT '0',
  	`sizes` text NOT NULL,
  	`deleted` tinyint NOT NULL DEFAULT '0',
  	`sold` int NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
  echo "Table <strong> products </strong> created ! <br>";


  queryMysql(
  	"CREATE TABLE `transactions` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`charge_id` varchar(255) NOT NULL,
  	`cart_id` int NOT NULL,
  	`full_name` varchar(255) NOT NULL,
  	`email` varchar(175) NOT NULL,
  	`street` varchar(255) NOT NULL,
  	`street2` varchar(255) NOT NULL,
  	`city` varchar(175) NOT NULL,
  	`state` varchar(175) NOT NULL,
  	`zip_code` int NOT NULL,
  	`country` varchar(175) NOT NULL,
  	`sub_total` decimal(10,0) NOT NULL,
  	`tax` decimal(10,0) NOT NULL,
  	`grand_total` decimal(10,0) NOT NULL,
  	`description` text NOT NULL,
  	`txn_type` varchar(255) NOT NULL,
  	`txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
  echo "Table <strong> transactions </strong> created ! <br>";


  queryMysql(
  	"CREATE TABLE `users` (
  	`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	`full_name` varchar(255) NOT NULL,
  	`email` varchar(175) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  	`last_login` datetime DEFAULT NULL,
  	`permissions` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;"
);
  echo "Table <strong> users </strong> created ! <br>";

  ?>
  <br>...done.
</body>
</html>