<?php 
session_start();
include '../dbConnect.php';	
include("../dbClass.php");

$dbClass = new dbClass;	
extract($_POST);

if($q=="insert_review"){
	$comments	 = htmlspecialchars($_POST['comment'],ENT_QUOTES);
	$review_name	 = htmlspecialchars($_POST['review_name'],ENT_QUOTES);	
	
	$columns_value = array(
		'product_id'=>$product_id_review,
		'review_details'=>$comments,
		'review_point'=>$rating_point,
		'review_by_name'=>$review_name,
		'review_by_email'=>$review_email
	);	
	$return = $dbClass->insert("product_review", $columns_value);	
	if($return) echo "1";
	else 	echo "0";	
}

if($q=="get_comments"){
	$sql = "select *, DATE_FORMAT(review_date, '%W %M %e %Y') r_date from product_review where product_id=$product_id order by id desc ";	
	//echo $sql;die;		
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//	var_dump($data);
	echo json_encode($data);	
}

if($q=="getOrder_status"){
	$sql = "select order_status,order_noticed, payment_status, ifnull(payment_method,3) payment_method from order_master where invoice_no='$order_tracking_number'";			
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
	foreach ($result as $row) {
		$data['records'][] = $row;
	}	
	//	var_dump($data);
	echo json_encode($data);	
}

?>