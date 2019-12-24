<?php 
ob_start();
try{
	$servername = "localhost";
	$dbname = "search_engine";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOExeption $e){
	echo "Connection failed: " . $e->getMessage();
}