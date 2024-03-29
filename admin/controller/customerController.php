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

		if(isset($customer_id) && $customer_id == ""){

			if(isset($_FILES['customer_image_upload']) && $_FILES['customer_image_upload']['name']!= ""){
				$desired_dir = "../images/customer";
				chmod( "../images/customer", 0777);
				$file_name = $_FILES['customer_image_upload']['name'];
				$file_size =$_FILES['customer_image_upload']['size'];
				$file_tmp =$_FILES['customer_image_upload']['tmp_name'];
				$file_type=$_FILES['customer_image_upload']['type'];	
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
					$photo  = "images/customer/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo  = "images/no_image.png";	
			}
			
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
			
			$columns_value = array(
				'full_name'=>$customer_name,
				'email'=>$email,
				'address'=>$address,
				'age'=>$age,
				'contact_no'=>$contact_no,
				'email'=>$email,
				'status'=>$is_active,
				'photo'=>$photo,
				'remarks'=>$remarks
			);	
			
			$return = $dbClass->insert("customer_infos", $columns_value);	
			if($return) echo "1";
			else 	echo "0";
		}
		else{

			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}	
					
			$columns_value = array(
				'full_name'=>$customer_name,
				'email'=>$email,
				'address'=>$address,
				'age'=>$age,
				'contact_no'=>$contact_no,
				'email'=>$email,
				'status'=>$is_active
			);
			
			if(isset($_POST['remarks']))
				$columns_value['remarks'] = $remarks;	
			
			if(isset($_FILES['customer_image_upload']) && $_FILES['customer_image_upload']['name']!= ""){
				$desired_dir = "../images/customer";
				chmod( "../images/customer", 0777);
				$file_name = $_FILES['customer_image_upload']['name'];
				$file_size =$_FILES['customer_image_upload']['size'];
				$file_tmp =$_FILES['customer_image_upload']['tmp_name'];
				$file_type=$_FILES['customer_image_upload']['type'];	
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
					$photo  = "images/customer/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}				
				$columns_value['photo'] = $photo;					
			}
			
			if($password != "" && $new_password != ""){
				$old_password =  $dbClass->getResultList("SELECT password FROM customer_infos WHERE customer_id=$customer_id");
				if(md5($password) == $old_password[0]){
					$columns_value['password'] = md5($new_password);
				}
				else{
					echo "3";die;
				}
			}

		//	var_dump($columns_value);
		//	die;
			$condition_array = array(
				'customer_id'=>$customer_id
			);	
			$return = $dbClass->update("customer_infos", $columns_value, $condition_array);
							
			if($return) echo "2";
			else 	echo "0";
		}
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(66);
		$delete_permission          = $dbClass->getUserGroupPermission(67);
		$update_permission          = $dbClass->getUserGroupPermission(68);
		
		$customer_grid_permission   = $dbClass->getUserGroupPermission(69);

		
		if($customer_active_status == '') $customer_active_status = 1;
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){		
			// for status condition 			
			if($customer_active_status != 2) $condition  .=" WHERE c.status = $customer_active_status ";	
		}
		// textfield search for grid
		else{
			$condition .=	" where c.status =1 and CONCAT(c.customer_id, c.full_name, c.contact_no) LIKE '%$search_txt%' ";			
		}
		$countsql = "SELECT count(c.customer_id)
					FROM customer_infos c
					$condition";
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($customer_grid_permission==1){
			$sql = "SELECT c.customer_id, c.full_name, c.age, c.contact_no, c.`status`, c.photo, c.email, c.address,
					(CASE c.`status` WHEN 1 THEN 'Active' WHEN  0 THEN 'Inactive' END) status_text, 
					$update_permission as update_status, $delete_permission as delete_status
					FROM customer_infos c
					$condition
					ORDER BY customer_id desc
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
	
	case "get_customer_details":
		$update_permission = $dbClass->getUserGroupPermission(68);
		if($update_permission==1){
			$customer_details = $dbClass->getResultList("SELECT c.customer_id, c.full_name, c.contact_no, c.age, c.address,
														c.`status`, c.photo, c.email, c.remarks,
														(CASE c.`status` WHEN 1 THEN 'Active' WHEN  0 THEN 'Inactive' END) status_text
														FROM customer_infos c
														WHERE c.status = 1 and c.customer_id='$customer_id'");
			//echo $customer_details; die;
			foreach ($customer_details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}
	break;
	
	case "delete_customer":
		$delete_permission = $dbClass->getUserGroupPermission(67);
		if($delete_permission==1){
			$condition_array = array(
				'customer_id'=>$customer_id
			);
			$columns_value = array(
				'status'=>0
			);
			$return = $dbClass->update("customer_infos", $columns_value, $condition_array);
		}
		if($return==1) echo "1";
		else 		   echo "0";
	break;
}
?>