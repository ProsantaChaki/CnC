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
		if(isset($category_id) && $category_id == ""){
			
			$check_category_code_availability = $dbClass->getSingleRow("SELECT count(code) no_of_code FROM category where code='$category_code'");
			if($check_category_code_availability['no_of_code']!=0) { echo 5; die;}
			
			if(isset($_FILES['category_image_upload']) && $_FILES['category_image_upload']['name']!= ""){
				$desired_dir = "../images/category";
				chmod( "../images/category", 0777);
				$file_name = $_FILES['category_image_upload']['name'];
				$file_size =$_FILES['category_image_upload']['size'];
				$file_tmp =$_FILES['category_image_upload']['tmp_name'];
				$file_type=$_FILES['category_image_upload']['type'];	
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
					$photo  = "images/category/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo  = "images/no_image.png";	
			}
			
			$columns_value = array(
				'name'=>$category_name,
				'code'=>$category_code,
				'photo'=>$photo
			);
			
			$return = $dbClass->insert("category", $columns_value);
			
			if($return){ 
				echo "1";
			}else "0";
		}
		else if(isset($category_id) && $category_id>0){
			
			$check_category_code_availability = $dbClass->getSingleRow("SELECT count(code) no_of_code FROM category where code='$category_code' and id !='$category_id'");
			if($check_category_code_availability['no_of_code']!=0) { echo 5; die;}
			
			if(isset($_FILES['category_image_upload']) && $_FILES['category_image_upload']['name']!= ""){
				$desired_dir = "../images/category";
				chmod( "../images/category", 0777);
				$file_name = $_FILES['category_image_upload']['name'];
				$file_size =$_FILES['category_image_upload']['size'];
				$file_tmp =$_FILES['category_image_upload']['tmp_name'];
				$file_type=$_FILES['category_image_upload']['type'];	
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
					$photo  = "images/category/".$photo;					
				}
				else {
					echo $img_error_ln;die;
				}				
			}
			else{
				$photo  = "";	
			}
			
			$prev_attachment = $dbClass->getSingleRow("select photo from category where id = $category_id");
			
			if($photo != ""){	
				if($prev_attachment['photo'] != "" && $prev_attachment['photo'] != "images/no_image.png"){
					unlink("../".$prev_attachment['photo']);
				}
				$columns_value = array(
					'photo' => $photo
				);	 
				$condition_array = array(
					'id'=>$category_id
				);
				$return_photo = $dbClass->update("category",$columns_value, $condition_array);				
			}
			
			$columns_value = array(
				'name'=>$category_name,
				'code'=>$category_code
			);
			
			$condition_array = array(
				'id'=>$category_id
			);	
			
			$return = $dbClass->update("category", $columns_value, $condition_array);
							
			if($return) echo "2";
			else 	    echo "0";		 
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(50);
		$delete_permission          = $dbClass->getUserGroupPermission(51);
		$update_permission          = $dbClass->getUserGroupPermission(52);
		
		$category_grid_permission   = $dbClass->getUserGroupPermission(53);
		
		$countsql = "SELECT count(id)
					FROM(
						SELECT c.id, c.code, c.name, ifnull(c.photo,'') photo
						FROM category c
					)A
					WHERE CONCAT(id, code, name) LIKE '%$search_txt%'";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;
		$data['entry_status'] = $entry_permission;	
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($category_grid_permission==1){
			$sql = 	"SELECT id, name, code, photo, 
					$update_permission as update_status, $delete_permission as delete_status
					FROM(
						SELECT c.id, c.code, c.name, ifnull(c.photo,'') photo
						FROM category c
					)A
					WHERE CONCAT(id, name, code) LIKE '%$search_txt%'
					ORDER BY id desc
					LIMIT $start, $end";
				//	echo $sql;die;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);	
		}
	break;
	
	case "get_category_details":
		$update_permission = $dbClass->getUserGroupPermission(52);
		if($update_permission==1){
			$sql = "SELECT c.id, c.code, c.name, ifnull(c.photo,'') photo, ec.id parent_id, ifnull(ec.name,'') parent_name
					FROM category c
					LEFT JOIN category ec on c.parent_id = ec.id
					WHERE c.id=$category_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($result as $row) {
				$data['records'][] = $row;
			}			
			echo json_encode($data);	
		}			
	break;
	
	case "delete_category":		
		$delete_permission = $dbClass->getUserGroupPermission(51);
		if($delete_permission==1){
			$prev_attachment = $dbClass->getSingleRow("select photo from category where id=$category_id");
			if($prev_attachment['photo'] != "" || $prev_attachment['photo'] != "no_image.png"){
				unlink("../".$prev_attachment['photo']);
			}
			$condition_array = array(
				'id'=>$category_id
			);
			$return = $dbClass->delete("category", $condition_array);
		}
		if($return) echo "1";
		else 		echo "0";
	break;
	
	case "parent_head_info":
		$sql_query = "SELECT id, CONCAT_WS(' >> ',name,code) parentName
					FROM category
					WHERE CONCAT_WS('-> ',code,name) LIKE '%" . $term . "%' AND parent_id is NULL 
					ORDER BY name";
		//echo $sql_query;die;
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["parentName"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Parent Found !!!");
		}						
		echo json_encode($json);
	break;
	
}
?>