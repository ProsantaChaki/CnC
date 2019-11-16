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
		if(isset($outlets_id) && $outlets_id == ""){
			
			if(isset($_FILES['outlets_image_upload']) && $_FILES['outlets_image_upload']['name']!= ""){
				$desired_dir = "../images/outlets";
				chmod( "../images/outlets", 0777);
				$file_name = $_FILES['outlets_image_upload']['name'];
				$file_size =$_FILES['outlets_image_upload']['size'];
				$file_tmp =$_FILES['outlets_image_upload']['tmp_name'];
				$file_type=$_FILES['outlets_image_upload']['type'];	
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
					$photo  = "images/outlets/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo  = "images/no_image.png";	
			}
			
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			
			$columns_value = array(
				'outlet_name'=>$outlet_name,
				'incharge_name'=>$incharge_name,
				'address'=>$address,
				'mobile'=>$mobile_no,
				'status'=>$is_active,
				'image'=>$photo,
				'latitude'=>$latitude,
				'longitud'=>$longitud
			);
			$return = $dbClass->insert("outlets", $columns_value);
			
			if($return) echo "1";
			else        echo "0";
		}
		else if(isset($outlets_id) && $outlets_id>0){
			if(isset($_FILES['outlets_image_upload']) && $_FILES['outlets_image_upload']['name']!= ""){
				$desired_dir = "../images/outlets";
				chmod( "../images/outlets", 0777);
				$file_name = $_FILES['outlets_image_upload']['name'];
				$file_size =$_FILES['outlets_image_upload']['size'];
				$file_tmp =$_FILES['outlets_image_upload']['tmp_name'];
				$file_type=$_FILES['outlets_image_upload']['type'];	
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
					$photo  = "images/outlets/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}				
			}
			else{
				$photo  = "";	
			}
			
			$prev_attachment = $dbClass->getSingleRow("select image from outlets where id=$outlets_id");
			
			if($photo != ""){	
				if($prev_attachment['image'] != "" && $prev_attachment['image'] != "images/no_image.png"){
					unlink("../".$prev_attachment['image']);
				}
				$columns_value = array(
					'image' => $photo
				);	 
				$condition_array = array(
					'id'=>$outlets_id
				);
				$return_photo = $dbClass->update("outlets",$columns_value, $condition_array);				
			}
			
			$is_active = 0;
			if(isset($_POST['is_active'])){
				$is_active = 1;
			}
			
			$columns_value = array(
				'outlet_name'=>$outlet_name,
				'incharge_name'=>$incharge_name,
				'address'=>$address,
				'mobile'=>$mobile_no,
				'status'=>$is_active,
				'latitude'=>$latitude,
				'longitud'=>$longitud
			);
			
			$condition_array = array(
				'id'=>$outlets_id
			);
			
			$return = $dbClass->update("outlets",$columns_value, $condition_array);
			if($return) echo "2";
			else        echo "0";			 
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(78);
		$delete_permission          = $dbClass->getUserGroupPermission(79);
		$update_permission          = $dbClass->getUserGroupPermission(80);
		
		$grid_permission  		    = $dbClass->getUserGroupPermission(81);
		
		$countsql = "SELECT count(id)
					from(
						select a.id, a.address, a.mobile, a.image, a.outlet_name, ifnull(a.incharge_name,'') incharge_name, a.latitude, a.longitud,
						a.`status`,case status when 0 then 'Inactive' when 1 then 'Active' end status_text
						from outlets a 
					)A
					WHERE CONCAT(id, address, mobile, status_text, outlet_name, incharge_name) LIKE '%$search_txt%'";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission;		
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($grid_permission==1){
			$sql = 	"SELECT id, address, mobile, status_text, image, outlet_name, incharge_name, latitude, longitud
					from(
						select a.id, a.address, a.mobile, a.image, a.outlet_name, ifnull(a.incharge_name,'') incharge_name, 
						ifnull(a.latitude,'') latitude, ifnull(a.longitud,'') longitud,
						a.`status`,case status when 0 then 'Inactive' when 1 then 'Active' end status_text
						from outlets a 
					)A
					WHERE CONCAT(id, address, mobile, status_text,outlet_name, incharge_name) LIKE '%$search_txt%'
					ORDER BY id desc LIMIT $start, $end";	
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
	
	case "get_outlets_details":
		$update_permission = $dbClass->getUserGroupPermission(80);
		if($update_permission==1){
			$sql = "select * from outlets where id=$outlets_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}			
	break;

}
?>