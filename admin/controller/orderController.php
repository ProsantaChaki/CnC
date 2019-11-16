<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	
$c_date = date('Y-m-d H:i:s');

extract($_REQUEST);

switch ($q){
	case "insert_or_update":
		if(isset($order_id) && $order_id == ""){
			//var_dump($_REQUEST);die;			
			//------------ generate invoice no  -------------------
			$c_y_m = date('my');
			$last_invoice_no = $dbClass->getSingleRow("SELECT max(RIGHT(invoice_no,5)) as invoice_no FROM order_master");
			
			if($last_invoice_no == null){
				$inv_no = '00001';
			}
			else{
				$inv_no = $last_invoice_no['invoice_no']+1;
			}
			
			$str_length = 5;
			$str = substr("00000{$inv_no}", -$str_length);

			$invoice_no = "INV$c_y_m$str";
			
			//-----------------------------------------------------

			$remarks	 = htmlspecialchars($remarks,ENT_QUOTES);
			
			$columns_value = array(
				'customer_id'=>$customer_id,
				'order_date'=>$order_date,
				'delivery_date'=>$delivery_date,
				'delivery_type'=>$delivery_option,
				'outlet_id'=>$outlet_option,
				'delivery_charge_id'=>$delivery_option,
				'delivery_charge' =>number_format($delivery_charge_amount,2),
				'address'=>$address,
				'remarks'=>$remarks,
				'payment_method'=>$payment_option,
				'order_status'=>$order_status_id,
				'payment_status'=>$payment_status,
				'payment_reference_no'=>$payment_referance_no,
				'total_order_amt'=>number_format($total_product_amount,2),
				'invoice_no'=>$invoice_no
			);		
			
			if($payment_status==2){
				$columns_value['total_paid_amount'] = number_format($total_paid_amount,2);
				$columns_value['payment_time'] = $c_date;
			}	
			
			if(isset($coupon_name) && $coupon_name != ""){
				$coupon = (explode(" >> ",$coupon_name));	
				$columns_value['cupon_id'] = $coupon[0];
				$columns_value['discount_amount'] = $discounted_amount;
			}
			
			//var_dump($columns_value);die;
			$return_master = $dbClass->insert("order_master", $columns_value); 
			
			if($return_master){
				foreach($product_id as $key=>$value){
					$columns_value = array(
						'order_id'=>$return_master,
						'product_id'=>$product_id[$key],
						'quantity'=>$quantity[$key],
						'size_rate_id'=>$size_rate_id[$key],
						'product_rate'=>$rate[$key]
					);				
					$return_details = $dbClass->insert("order_details", $columns_value);	
				}
			} 
			
			if($return_details){
				echo "1";
			}
			else{
				echo "0";
			}
		}
		else if(isset($order_id) && $order_id>0){
			//var_dump($_REQUEST);die;			
			$columns_value = array(
				'customer_id'=>$customer_id,
				'order_date'=>$order_date,
				'delivery_date'=>$delivery_date,
				'delivery_type'=>$delivery_option,
				'delivery_charge_id'=>$delivery_option,
				'delivery_charge' =>number_format($delivery_charge_amount,2),
				'address'=>$address,
				'remarks'=>$remarks, 
				'payment_status'=>$payment_status,
				'payment_reference_no'=>$payment_referance_no,
				'discount_amount'=>$coupon_amount,
				'total_order_amt'=>$total_product_amount,
				'total_paid_amount'=>$total_paid_amount,
				'payment_time'=>$c_date
			);	
			
			if(isset($outlet_option) && $outlet_option != 0){
				$columns_value['outlet_id'] = $outlet_option;
			}
			if(isset($payment_option) && $payment_option != 0){
				$columns_value['payment_method'] = $payment_option;
			}
			
			if(isset($coupon_name) && $coupon_name != ""){
				$coupon = (explode(" >> ",$coupon_name));
				if(isset($coupon_name)){
					$coupon = (explode(" >> ",$coupon_name));	
					$columns_value['cupon_id'] 		 = $coupon[0];
					$columns_value['discount_amount']= $discounted_amount;
				}				
			}
			//var_dump($columns_value);die;
			$condition_array = array(
				'order_id'=>$order_id
			);	
			
			$return_master = $dbClass->update("order_master", $columns_value,$condition_array); 
 
			if($return_master){
				$condition_array = array(
					'id'=>$order_id
				);
				$return_dlt = $dbClass->delete("order_details", $condition_array);				
				if($return_dlt){
					foreach($product_id as $key=>$value){
						$columns_value = array(
							'order_id'=>$order_id,
							'product_id'=>$product_id[$key],
							'quantity'=>$quantity[$key],
							'size_rate_id'=>$size_rate_id[$key],
							'product_rate'=>$rate[$key]
						);						
						$condition_array = array(
							'order_id'=>$order_id
						);						
						$return_details = $dbClass->insert("order_details", $columns_value);	
					}	
				}
			} 
			
			if($return_details) echo "2";
			else                echo "0";
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(74);
		$delete_permission          = $dbClass->getUserGroupPermission(75);
		$update_permission          = $dbClass->getUserGroupPermission(76);
		
		$category_grid_permission   = $dbClass->getUserGroupPermission(77);
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){	
			// for advance condition 
			$search_txt = "";	
			if($ad_product_id != '') 	 	$condition  .=" and product_id = $ad_product_id ";
			if($ad_order_date != '')  		$condition  .=" and date(order_date) ='$ad_order_date'";
			if($ad_delivery_date != '') 	$condition  .=" and date(delivery_date) = '$ad_delivery_date'";
			if($ad_is_payment != 0)  		$condition  .=" and payment_status = $ad_is_payment";
			if($ad_is_order != 0)  			$condition  .=" and order_status = $ad_is_order";
			//$condition .=	"where s.name LIKE '%$std_name%' AND sch.name LIKE '%$sch_name%' AND s.class LIKE '%$std_class%'  AND s.address LIKE '%$std_address%'  AND s.upazilla LIKE '%$std_upazilla%' AND s.zilla LIKE '%$std_zilla%'  AND s.division LIKE '%$std_division%'";							
		}
		// textfield search for grid
		/*else{
			$condition .=	" CONCAT(order_id, customer_name, p_name, product_rate) LIKE '%$search_txt%' ";			
		}*/
		
		$countsql = "SELECT count(order_id)
					FROM(
						SELECT m.order_id, m.customer_id, c.full_name as customer_name, m.invoice_no,
						d.product_id,d.product_rate, d.size_rate_id, m.order_date, m.delivery_date, 
						GROUP_CONCAT(p.name,' (',s.name,' - ',format(d.product_rate,2),')') p_name,
						m.delivery_type, m.outlet_id, CONCAT(m.outlet_id,' >> ',o.address) outlet_name, order_noticed,
						m.address, m.remarks, m.order_status, m.payment_status, m.payment_method, m.payment_reference_no
						FROM order_master m
						LEFT JOIN order_details d ON d.order_id = m.order_id
						LEFT JOIN customer_infos c ON c.customer_id = m.customer_id
						LEFT JOIN outlets o ON o.id = m.outlet_id
						LEFT JOIN product_rate r on r.id = d.size_rate_id
						LEFT JOIN products p ON p.product_id = d.product_id
						LEFT JOIN size s ON s.id = r.size_id
						WHERE d.status=1
						GROUP BY d.order_id
						ORDER BY m.order_id desc
					)A
					WHERE CONCAT(invoice_no, order_id, customer_name, p_name, product_rate) LIKE '%$search_txt%' $condition"; 
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;
		$data['entry_status'] = $entry_permission;	
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($category_grid_permission==1){
			$sql = 	"SELECT order_id, customer_id, customer_name, product_id, product_rate, size_rate_id, p_name, order_date,order_noticed,
					delivery_date, delivery_type, outlet_id, outlet_name, address, remarks, order_status, payment_status, delivery_charge,
					payment_method, payment_reference_no, invoice_no, payment_status_text, order_status_text, total_paid_amount,
					$update_permission as update_status, $delete_permission as delete_status
					FROM(
						SELECT m.order_id, m.customer_id, c.full_name as customer_name, m.delivery_type, m.outlet_id, 
						CONCAT(m.outlet_id,' >> ',o.address) outlet_name, m.address, m.remarks, m.order_status, order_noticed,
						m.payment_status, m.payment_method, m.payment_reference_no, m.invoice_no,
						d.product_id,d.product_rate, d.size_rate_id, m.total_paid_amount, m.delivery_charge,
						CASE m.payment_status WHEN 1 THEN 'Not Paid' WHEN 2 THEN 'Paid' END payment_status_text,
						CASE m.order_status WHEN 1 THEN 'Ordered' WHEN 2 THEN 'Ready' WHEN 3 THEN 'Picked' END order_status_text,
						GROUP_CONCAT(p.name,' (',s.name,' - ',format(d.product_rate,2),')' SEPARATOR ', ') p_name, m.order_date, m.delivery_date
						FROM order_master m
						LEFT JOIN order_details d ON d.order_id = m.order_id
						LEFT JOIN customer_infos c ON c.customer_id = m.customer_id
						LEFT JOIN outlets o ON o.id = m.outlet_id
						LEFT JOIN product_rate r on r.id = d.size_rate_id
						LEFT JOIN products p ON p.product_id = d.product_id
						LEFT JOIN size s ON s.id = r.size_id
						WHERE d.status=1
						GROUP BY d.order_id
						ORDER BY m.order_id desc

					)A
					WHERE CONCAT(invoice_no, order_id, customer_name, p_name, product_rate) LIKE '%$search_txt%' $condition
					ORDER BY order_id desc
					LIMIT $start, $end";
					//echo $sql;die;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);	
		}
	break;
	
	case "get_order_details":
		$update_permission = $dbClass->getUserGroupPermission(76);
		if($update_permission==1){
			$sql = "SELECT m.order_id, m.customer_id, 
					c.full_name customer_name, d.product_id, c.contact_no customer_contact_no, c.address customer_address, 
					GROUP_CONCAT(ca.name,' >> ',ca.id,'#',ca.id,'#',p.name,' (',ca.name,' )','#',p.product_id,'#',s.name,'#',d.size_rate_id,'#',d.product_rate,'#',d.quantity) order_info,
					m.order_date, m.delivery_date, m.delivery_type, m.discount_amount, m.total_paid_amount, m.delivery_charge,
					ifnull(m.outlet_id,0) outlet_id, o.address, m.address, m.delivery_charge_id, m.tax_amount,  ifnull(cu.cupon_no,'') cupon_no, ifnull(cu.amount,'') cu_amount, cu.c_type cu_type,  m.cupon_id,
					m.remarks, m.order_status, m.payment_status, m.payment_method as payment_method_id,  
					m.payment_reference_no, m.invoice_no, m.total_order_amt,
					case payment_status when payment_status=1 then 'Not Paid' else 'Paid' end paid_status, 
					case payment_method when payment_method=1 then 'bKash' when payment_method=2 then 'Rocket'  else 'Cash On Delivery'  end payment_method
					FROM order_master m
					LEFT JOIN order_details d ON d.order_id = m.order_id
					LEFT JOIN customer_infos c ON c.customer_id = m.customer_id
					LEFT JOIN outlets o ON o.id = m.outlet_id
					LEFT JOIN products p ON p.product_id = d.product_id
					LEFT JOIN product_rate r on r.id = d.size_rate_id
					LEFT JOIN size s ON s.id = r.size_id
					LEFT JOIN category ca ON ca.id = p.category_id
					LEFT JOIN cupons cu ON cu.cupon_no = m.cupon_id 
					WHERE d.status=1 and m.order_id= $order_id 
					GROUP BY d.order_id
					ORDER BY m.order_id ";
			//echo $sql;die;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($result as $row) {
				$data['records'][] = $row;
			}				
			echo json_encode($data);	
		}			
	break;

	
	case "set_order_notice_details":
		$prev_order_notice = $dbClass->getSingleRow("select order_noticed from order_master where order_id=$order_id");
		if($prev_order_notice['order_noticed'] == 1){
			$condition_array = array(
				'order_id'=>$order_id
			);				
			$columns_value = array(
				'order_noticed'=>2,
				'order_noticed_time'=>$c_date
			);			
			$return = $dbClass->update("order_master", $columns_value, $condition_array);
			echo $return;
		}			
			
	break;

	case "delete_order":		
		$delete_permission = $dbClass->getUserGroupPermission(75);
		if($delete_permission==1){
			$condition_array = array(
				'order_id'=>$order_id
			);				
			$columns_value = array(
				'status'=>2
			);		
			$return = $dbClass->update("order_details", $columns_value, $condition_array);
		}
		if($return) echo "1";
		else 		echo "0";
	break;
	
	case "view_outlets": 
		$data = array();
		$details = $dbClass->getResultList("SELECT c.id, c.address FROM outlets c ORDER BY c.id");
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "view_delivery_list": 
		$dept_details = $dbClass->getResultList("select id, type, format(rate,2) rate from delivery_charge where status=1");
		foreach ($dept_details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	
	case "customer_info":
		$sql_query = "SELECT c.customer_id, c.full_name
					FROM customer_infos c";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["customer_id"],'label' => $row["full_name"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Product Found !!!");
		}						
		echo json_encode($json);
	break;
	
	case "coupon_info":
		$sql_query = "SELECT id, c_type, amount, CONCAT(cupon_no,' >> ',t_amount) c_info FROM 
						(
							SELECT c.id, c.cupon_no, c.c_type, c.amount,
							CASE 
								WHEN c.c_type = 1 THEN c.amount 
								WHEN 2 THEN CONCAT(c.amount,' %') 
							END t_amount
							FROM cupons c WHERE c.`status`=1
						) A";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'type' => $row["c_type"],'label' => $row["c_info"],'rate' => $row["amount"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Coupon Found !!!");
		}						
		echo json_encode($json);
	break;
	
	case "product_info":
		$con = "WHERE CONCAT(name, code) LIKE '%$term%'";
		if(isset($category_id) && $category_id !=0){
			$con .= " AND  p.category_id = $category_id " ;
		}
		$sql_query = "SELECT p.product_id, p.name FROM products p $con ORDER BY p.product_id";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["product_id"],'label' => $row["name"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Product Found !!!");
		}						
		echo json_encode($json);
	break;
	
	case "ad_product_info":
		$sql_query = "SELECT p.product_id, p.name FROM products p WHERE CONCAT(name) LIKE '%$term%' ORDER BY p.product_id";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["product_id"],'label' => $row["name"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Product Found !!!");
		}						
		echo json_encode($json);
	break;	
	
	case "size_rate_info":
		//var_dump($_REQUEST);die;
		$sql_query = "SELECT r.id rate_id, r.size_id, r.discounted_rate, CONCAT(s.name,' >> ',r.discounted_rate) sizeInfo, r.discounted_rate 
					FROM product_rate r 
					LEFT JOIN size s on s.id=r.size_id
					WHERE r.product_id = $product_id ORDER BY r.id";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["rate_id"],'label' => $row["sizeInfo"],'rate' => $row["discounted_rate"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Product Found !!!");
		}						
		echo json_encode($json);
	break;	
	
	case "category_info":
		$sql_query = "SELECT id, CONCAT(head_name,' >> ',code) category_name 
					FROM (
						SELECT c.id, c.code, 
						CASE WHEN c.parent_id IS NULL THEN c.name WHEN c.parent_id IS NOT NULL THEN CONCAT(ec.name,' >> ',c.name) END head_name
						FROM category c
						LEFT JOIN category ec ON c.parent_id = ec.id
						WHERE CONCAT(c.name, c.code) LIKE '%$term%'
						ORDER BY c.id						
					) A";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["category_name"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Product Found !!!");
		}						
		echo json_encode($json);
	break;
	
	case "update_order_status":			
			$condition_array = array(
				'order_id'=>$order_id
			);				
			$columns_value = array(
				'order_status'=>$status_id
			);			
			$return = $dbClass->update("order_master", $columns_value, $condition_array);
			echo $return;	
	break;
}
?>