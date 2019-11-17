<?php 
	$servername = "localhost.test";
	$username = "root";
	$password = "kajol1234";
	$dbname = "cakencookies";
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Cannot Connect to Database : " . $e->getMessage();
	}
?>