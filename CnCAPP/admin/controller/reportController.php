<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	

extract($_REQUEST);

switch ($q){
	
	case "orderReport":
		if(isset($start)){
			$start = ($page_no*$limit)-$limit;
			$end   = $limit;
		}
		else{
			$limit = 1; 
			$start = 0;
			$end   = 100;
		}
		$search = '';
		if(isset($search_txt) && $search_txt != '' && $search_txt != 'Print'){
			$search = $search_txt;
		}

		$condition = "";
		if(!isset($ad_customer_id))    												   $ad_customer_id = '';
	 if(isset($ad_customer_id) && ($ad_customer_id != '' && $ad_customer_name != ''))  $condition  .=" and customer_id = $ad_customer_id ";
		if(isset($ad_product_id) && ($ad_product_id != '' && $ad_product_name != ''))  $condition  .=" and p_name LIKE '%$ad_product_name%'";
		if(isset($ad_order_date) && $ad_order_date != '')  							   $condition  .=" and date(order_date) ='$ad_order_date'";
		if(isset($ad_delivery_date) && $ad_delivery_date != '')   				 	   $condition  .=" and date(delivery_date) = '$ad_delivery_date'";
		if((isset($report_type) && $report_type = 'order_vs_payment')){
			if(isset($start_date) && $start_date != '') 							   $condition  .=" and ((date(order_date) between '$start_date' and '$end_date'))";
		}
		else{
			if(isset($start_date) && $start_date != '')  							   $condition  .=" and ((date(order_date) between '$start_date' and '$end_date') || (date(delivery_date) between '$start_date' and '$end_date'))";
		}
		if(isset($ad_is_payment) && $ad_is_payment != 0)  							   $condition  .=" and payment_status = $ad_is_payment";
		if(isset($ad_is_order) && $ad_is_order != 0)  								   $condition  .=" and order_status = $ad_is_order";
		if(isset($order_id) && $order_id != '')  								 	   $condition  .=" and invoice_no = '$order_no'";
		if(isset($ad_order_id) && ($ad_order_id != '' && $ad_order_no != '')) 	  	   $condition  .=" and invoice_no = '$ad_order_no'";
		
		$data = array();
		
		if(isset($order_id) && $order_id != ''){
			$sql="SELECT m.order_id, m.customer_id, 
				c.full_name customer_name, d.product_id, c.contact_no customer_contact_no, c.address customer_address, 
				GROUP_CONCAT(ca.name,' >> ',ca.id,'#',ca.id,'#',p.name,' (',ca.name,' )','#',p.product_id,'#',s.name,'#',d.size_rate_id,'#',d.product_rate,'#',d.quantity) order_info,
				m.order_date, m.delivery_date, m.delivery_type, m.discount_amount, m.total_paid_amount,
				m.outlet_id, o.address, m.address, m.delivery_charge_id, m.tax_amount, m.delivery_charge,
				m.remarks, m.order_status, m.payment_status, m.payment_method, 
				m.payment_reference_no, m.invoice_no, m.total_order_amt
				FROM order_master m
				LEFT JOIN order_details d ON d.order_id = m.order_id
				LEFT JOIN customer_infos c ON c.customer_id = m.customer_id
				LEFT JOIN outlets o ON o.id = m.outlet_id
				LEFT JOIN products p ON p.product_id = d.product_id
				LEFT JOIN product_rate r on r.id = d.size_rate_id
				LEFT JOIN size s ON s.id = r.size_id
				LEFT JOIN category ca ON ca.id = p.category_id
				WHERE m.order_id= $order_id $condition
				GROUP BY d.order_id
				ORDER BY m.order_id";
		}
		else{
			$sql="SELECT order_id, customer_id, customer_name, product_id, product_rate, size_rate_id, p_name, order_date, total_balance_amount,
				delivery_date, delivery_type, outlet_id, outlet_name, address, remarks, order_status, payment_status, total_order_amt,
				payment_method, payment_reference_no, invoice_no, payment_status_text, order_status_text, total_paid_amount, delivery_charge
				FROM(
					SELECT m.order_id, m.customer_id, c.full_name as customer_name, (total_order_amt+delivery_charge-total_paid_amount) as total_balance_amount,
					d.product_id,d.product_rate, d.size_rate_id, m.total_paid_amount, m.total_order_amt, m.delivery_charge,
					CASE m.payment_status WHEN 1 THEN 'Not Paid' WHEN 2 THEN 'Paid' END payment_status_text,
					CASE m.order_status WHEN 1 THEN 'Ordered' WHEN 2 THEN 'Ready' WHEN 3 THEN 'Picked' END order_status_text,
					GROUP_CONCAT(p.name,' (',s.name,' - ',format(d.product_rate,2),')' SEPARATOR '#') p_name, m.order_date, m.delivery_date, 
					m.delivery_type, m.outlet_id, CONCAT(m.outlet_id,' >> ',o.address) outlet_name, m.address, m.remarks, m.order_status, 
					m.payment_status, m.payment_method, m.payment_reference_no, m.invoice_no
					FROM order_master m
					LEFT JOIN order_details d ON d.order_id = m.order_id
					LEFT JOIN customer_infos c ON c.customer_id = m.customer_id
					LEFT JOIN outlets o ON o.id = m.outlet_id
					LEFT JOIN product_rate r on r.id = d.size_rate_id
					LEFT JOIN products p ON p.product_id = d.product_id
					LEFT JOIN size s ON s.id = r.size_id
					GROUP BY d.order_id
					ORDER BY m.order_id
				)A
				WHERE CONCAT(order_id, invoice_no, customer_name, p_name, product_rate) LIKE '%$search%' $condition
				ORDER BY order_id ASC
				LIMIT $start, $end";	
		}	
		//echo $sql;die;
		$details = $dbClass->getResultList($sql);
		
		$total_records = count($details);
		$data['total_records'] = $total_records;
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		
		$data['total_order_no'] = count($details);
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "order_no_info":
		$sql_query = "SELECT order_id, invoice_no FROM order_master m";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["order_id"],'label' => $row["invoice_no"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Order No Found !!!");
		}						
		echo json_encode($json);
	break;
	
	case "customerReport":		
		$con = "";
		$condition = "";
		if($is_active_status != 2)  $condition = ' WHERE c.status = "'.$is_active_status.'" ';
		if(isset($report_type)){
			$con = "limit 10";
		}
		$data = array();		
		$sql="SELECT c.customer_id, c.full_name, c.age, c.email, c.contact_no, COUNT(m.order_id) no_of_order,
			CASE c.status WHEN 1 THEN 'Active' WHEN 0 THEN 'In-active' END status_text, ifnull(cc.cupon_no,'') coupon_no
			FROM customer_infos c 
			LEFT JOIN order_master m on m.customer_id = c.customer_id
			LEFT JOIN cupons cc on cc.customer_id = c.customer_id
			$condition
			GROUP BY c.customer_id
			ORDER BY no_of_order DESC $con";	
			//echo $sql;die;
		$details = $dbClass->getResultList($sql);		
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "productReport":		
		$condition = "";
		if($is_active_status != 2)  				 $condition .= ' c.status = "'.$is_active_status.'" ';
		if($is_active_status == 2)  				 $condition .= ' (c.status = 1 || c.status = 0) ';		
		if($category_id != 0)  						 $condition .= ' and p.category_id = "'.$category_id.'" ';
		if(isset($product_id) && $product_id != '')  $condition .= ' and p.product_id = "'.$product_id.'" ';
		
		$data = array();		
		$sql="SELECT p.product_id, p.name, c.name c_name, ifnull(p.short_description,'') details, 
			GROUP_CONCAT(s.name,' >> ',r.discounted_rate) p_rate,
			CASE availability WHEN 1 THEN 'Available' WHEN 0 THEN 'Not Available' END status_text
			FROM products p
			LEFT JOIN category c on c.id = p.category_id
			LEFT JOIN product_rate r on r.product_id = p.product_id
			LEFT JOIN size s on s.id = r.size_id
			WHERE $condition
			GROUP BY p.product_id
			ORDER BY p.product_id ASC";	
		//echo $sql;die;
		$details = $dbClass->getResultList($sql);		
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "productSellReport":		
		$condition = "";
		if(isset($product_id) && ($product_id != '' && $product_name != ''))  $condition  .=" and d.product_id = $product_id ";
		if(isset($category_id) && ($category_id != 0))  					  $condition  .=" and p.category_id = $category_id ";		
		if(isset($start_date) && $start_date != '')  						  $condition  .=" and ((date(order_date) between '$start_date' and '$end_date') || (date(delivery_date) between '$start_date' and '$end_date'))";
		
		$data = array();		
		$sql="SELECT d.product_id, format(d.product_rate,2) p_rate, SUM(d.quantity) quantity, s.name s_name,
			CONCAT(p.name,' (',s.name,' - ',format(d.product_rate,2),')') p_name
			FROM order_details d
			LEFT JOIN order_master m ON d.order_id = m.order_id
			LEFT JOIN product_rate r on r.id = d.size_rate_id
			LEFT JOIN products p ON p.product_id = d.product_id
			LEFT JOIN size s ON s.id = r.size_id
			LEFT JOIN category c on c.id = p.category_id
			WHERE CONCAT(d.product_id, d.product_rate, p.name) LIKE '%%' $condition
			GROUP BY d.product_id
			ORDER BY d.product_id ASC";	
		//echo $sql;die;
		$details = $dbClass->getResultList($sql);		
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	
}
?>