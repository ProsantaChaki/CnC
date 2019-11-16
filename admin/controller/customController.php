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
	
	case "insert_or_update":	

		if(isset($custom_id) && $custom_id != ""){
					
			$columns_value = array(
				'cc_name'=>$custom_name,
				'cc_cake_weight'=>$cake_weight,
				'cc_cake_tyre'=>$cake_tyre,
				'cc_email'=>$email,
				'cc_delevery_date'=>$delivery_date,
				'cc_details'=>$details,
				'cc_mobile'=>$contact_no,
				'cc_email'=>$email,
				'varified_by'=>$loggedUser,
				'status'=>3
			);
			
			if(isset($_POST['remarks']))
				$columns_value['remarks'] = $remarks;	
			
			if(isset($_FILES['custom_image_upload']) && $_FILES['custom_image_upload']['name']!= ""){
				$desired_dir = "../images/custom";
				chmod( "../images/custom", 0777);
				$file_name = $_FILES['custom_image_upload']['name'];
				$file_size =$_FILES['custom_image_upload']['size'];
				$file_tmp =$_FILES['custom_image_upload']['tmp_name'];
				$file_type=$_FILES['custom_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$photo = "$file_name";
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir))
							$photo =time()."$file_name";				
					}
					$photo  = "images/custom/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}				
				$columns_value['photo'] = $photo;					
			}
			
			$condition_array = array(
				'id'=>$custom_id
			);	
			$return = $dbClass->update("custom_cake", $columns_value, $condition_array);
							
			if($return) echo "2";
			else 		echo "0";
		}
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$delete_permission          = $dbClass->getUserGroupPermission(90);
		$update_permission          = $dbClass->getUserGroupPermission(89);
		
		$grid_permission   			= $dbClass->getUserGroupPermission(88);

		
		$condition =	" where active = 1 AND CONCAT(c.id, c.cc_name, c.cc_mobile) LIKE '%$search_txt%' ";
		
		$countsql = "SELECT count(c.id)
					FROM custom_cake c
					$condition";
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['update_status'] = $update_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($grid_permission==1){
			$sql = "SELECT c.id, c.cc_cake_weight, c.cc_cake_tyre, c.cc_delevery_date, 
					c.cc_details, c.cc_name, c.cc_email,c.cc_mobile, c.cc_image, c.`status`,
					CASE c.`status` WHEN 1 THEN 'NOT SEEN' WHEN 2 THEN 'SEEN' WHEN 3 THEN 'Verified' END as status_text,
					$update_permission as update_status, $delete_permission as delete_status
					FROM custom_cake c
					$condition
					ORDER BY id desc
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
	
	case "get_custom_details":
		$update_permission = $dbClass->getUserGroupPermission(89);
		if($update_permission==1){
			$custom_details = $dbClass->getResultList("SELECT c.id, c.cc_cake_weight, c.cc_cake_tyre, c.cc_delevery_date, 
														c.cc_details, c.cc_name, c.cc_email,c.cc_mobile, c.cc_image, c.`status`,
														CASE c.`status` WHEN 1 THEN 'NOT SEEN' WHEN 2 THEN 'SEEN' WHEN 3 THEN 'Verified' END as status_text
														FROM custom_cake c
														WHERE c.id='$custom_id'");
			//echo $customer_details; die;
			foreach ($custom_details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}
	break;
	
	case "set_order_notice_details":
		$prev_order_notice = $dbClass->getSingleRow("select status from custom_cake where id=$custom_id");
		if($prev_order_notice['status'] == 1){
			$condition_array = array(
				'id'=>$custom_id
			);				
			$columns_value = array(
				'status'=>2
			);			
			$return = $dbClass->update("custom_cake", $columns_value, $condition_array);
			echo $return;
		}			
			
	break;
	
	case "delete_custom":
		$delete_permission = $dbClass->getUserGroupPermission(90);
		if($delete_permission==1){
			$condition_array = array(
				'id'=>$custom_id
			);
			$columns_value = array(
				'active'=>0
			);
			$return = $dbClass->update("custom_cake", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break; 
}
?>