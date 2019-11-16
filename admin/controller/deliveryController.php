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
		if(isset($delivery_id) && $delivery_id == ""){
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			$columns_value = array(
				'type'=>$delivery_type ,
				'rate'=>$rate,
				'status'=>$is_active
			);
			$return = $dbClass->insert("delivery_charge", $columns_value);
			
			if($return){
				echo "1";
			}
			else "0";
		}
		else if(isset($delivery_id) && $delivery_id>0){
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			$columns_value = array(
				'type'=>$delivery_type ,
				'rate'=>$rate,
				'status'=>$is_active
			);
			$condition_array = array(
				'id'=>$delivery_id
			);
			$return = $dbClass->update("delivery_charge",$columns_value, $condition_array);
			if($return) echo "2";
			else        echo "0";			 
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(94);
		$delete_permission          = $dbClass->getUserGroupPermission(95);
		$update_permission          = $dbClass->getUserGroupPermission(96);
		
		$grid_permission   			= $dbClass->getUserGroupPermission(97);
		
		$countsql = "SELECT count(id)
					from(
						select a.id, a.type, a.rate,
						a.`status`,case status when 1 then 'Active' when 0 then 'Inactive' end status_text
						from delivery_charge a 
					)A
					WHERE a.status = 1 AND CONCAT(id, type, rate, status_text) LIKE '%$search_txt%'";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;  
		$data['entry_status'] = $entry_permission;
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		if($grid_permission==1){		
			$sql = 	"SELECT id, type, rate, status_text, $update_permission as update_status, $delete_permission as delete_status
					from(
						select a.id, a.type, a.rate,
						a.`status`, case status when 1 then 'Active' when 0 then 'Inactive' end status_text
						from delivery_charge a 
					)A
					WHERE a.status = 1 AND CONCAT(id, type, rate, status_text) LIKE '%$search_txt%'
					ORDER BY id ASC LIMIT $start, $end";	
			//echo $sql; die;		
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}	
	break;
	
	case "get_delivery_details":
		$update_permission = $dbClass->getUserGroupPermission(96);
		if($update_permission==1){
			$sql = "select * from delivery_charge where id=$delivery_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}		
	break;
	
	case "delete_delivery":		
		$delete_permission = $dbClass->getUserGroupPermission(95);
		if($delete_permission==1){
			$columns_value = array(
				'status'=>0
			);
			$condition_array = array(
				'id'=>$delivery_id
			);
			$return = $dbClass->update("delivery_charge",$columns_value, $condition_array);
		}
		if($return) echo "1";
		else 		echo "0";
	break;

}
?>