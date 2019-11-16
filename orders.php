<?php 
session_start();
include("includes/dbConnect.php");
include("includes/dbClass.php");
$dbClass = new dbClass;	
$is_logged_in_customer = "";

if(!isset($_SESSION['customer_id']) && $_SESSION['customer_id']!=""){ ob_start(); header("Location:index.php"); exit();}
else $is_logged_in_customer = 1; 
$customer_id = $_SESSION['customer_id'];	
$orders_info = $dbClass->getResultList("SELECT invoice_no order_no, order_id, order_date,delivery_date, 
										CASE delivery_type WHEN 1 THEN 'Takeout' WHEN 2 THEN 'Delevery' END delevery_type, 
										CASE order_status WHEN 1 THEN 'Ordered' WHEN 2 THEN 'Ready' WHEN 3 THEN 'Delevered' END order_status, 
										total_order_amt,total_paid_amount
										FROM order_master
										WHERE customer_id=$customer_id 
										order by order_id desc
										");
if(empty($orders_info)){
	echo "<h6 class='center'>Your have no orders </h6>";
}
else{
	
?>
	<h6 class="center">Your Order List </h6>
	<hr>
	<section class="home-icon shop-cart bg-skeen">
		<div class="container" style="max-width:100%" id="oredrs_div">		
			<table class="table table-bordered table-hover">
				  <thead>
					<tr>
					  <th>Order No</th>
					  <th>Order Date</th>
					  <th>Delevery date</th>
					  <th>Type</th>
					  <th>Amount</th>
					  <th>Paid</th>
					  <th>Status</th>
					  <th></th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					 <?php
					 foreach($orders_info as $order){ 	
						$order_no = '"'.$order['order_no'].'"';						 
						echo 
						"<tr>
							  <td>".$order['order_no']."</td>
							  <td>".$order['order_date']."</td>
							  <td>".$order['delivery_date']."</td>
							  <td>".$order['delevery_type']."</td>
							  <td>".$order['total_order_amt']."</td>
							  <td>".$order['total_paid_amount']."</td>
							  <td>".$order['order_status']."</td>
							  <td><i class='fa fa-search-plus pointer' onclick='view_order(".$order_no.")'></i></td>
						  </tr>
						";
					  }
					  ?>
					</tr>
				  </tbody>
			</table>		
		</div>
	</section>
<?php
}
?>

