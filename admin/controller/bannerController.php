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
	
		if(isset($bannerImg_id) && $bannerImg_id == ""){			
			if(isset($_FILES['bannerImg_image_upload']) && $_FILES['bannerImg_image_upload']['name']!= ""){
				$desired_dir = "../images/banner";
				$desired_dir_thumb = "../images/banner/thumb";
				chmod( "../images/banner", 0777);
				chmod( "../images/product/thumb", 0777);
				
				$file_name = $_FILES['bannerImg_image_upload']['name'];
				$file_size =$_FILES['bannerImg_image_upload']['size'];
				$file_tmp =$_FILES['bannerImg_image_upload']['tmp_name'];
				$file_type=$_FILES['bannerImg_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						$dbClass->store_uploaded_image($file_tmp, 200, 150, $desired_dir_thumb, "$desired_dir/thumb/".$file_name);
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name)){
							$photo = "$file_name";
						}
						else	
						{echo "Not uploaded because of error #".$_FILES["bannerImg_image_upload"]["error"]; die;}
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						$dbClass->store_uploaded_image($file_tmp, 200, 150, $desired_dir_thumb, "$desired_dir/thumb/".time().$file_name);
						if(rename($file_tmp,$new_dir)){
							$photo =time()."$file_name";
						}							
					}
					$photo  = "/images/banner/".$photo;
				}
				else{
					echo $img_error_ln;die;
				}			
			}
			else{
				$photo  = "";	
			}
			$columns_value = array(
				'title'=>$title,
				'text'=>$text,
				'photo'=>$photo
			);	
			
			$return = $dbClass->insert("banner_image", $columns_value);
			
			if($return) echo "1";
			else 	echo "0";
		}
		else{		
			if(isset($_FILES['bannerImg_image_upload']) && $_FILES['bannerImg_image_upload']['name']!= ""){
				$desired_dir = "../images/banner";
				$desired_dir_thumb = "../images/banner/thumb";
				chmod( "../images/banner", 0777);
				chmod( "../images/product/thumb", 0777);

				$file_name = $_FILES['bannerImg_image_upload']['name'];
				$file_size =$_FILES['bannerImg_image_upload']['size'];
				$file_tmp =$_FILES['bannerImg_image_upload']['tmp_name'];
				$file_type=$_FILES['bannerImg_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						store_uploaded_image($file_tmp, 200, 150, $desired_dir_thumb, "$desired_dir/thumb/".$file_name);
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name)){
							$photo = "$file_name";							
						}
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						store_uploaded_image($file_tmp, 200, 150, $desired_dir_thumb, "$desired_dir/thumb/".time().$file_name);
						if(rename($file_tmp,$new_dir)){
							$photo =time()."$file_name";							
						}							
					}
					$photo  = "/images/banner/".$photo;
				}
				else {
					echo $img_error_ln;die;
				}
				$columns_value = array(
					'text'=>$text,
					'title'=>$title,
					'photo'=>$photo
				);					
			}
			else{
				$columns_value = array(
					'text'=>$text,
					'title'=>$title,
				);	
			}
			$condition_array = array(
				'id'=>$bannerImg_id
			);	
			$return = $dbClass->update("banner_image", $columns_value, $condition_array);
		
			if($return) echo "2";
			else 	echo "0";
		}
	break;

	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		$employee_grid_permission   = $dbClass->getUserGroupPermission(15);
		$entry_permission   	   	= $dbClass->getUserGroupPermission(10);
			
		$countsql = "SELECT count(id) FROM banner_image";
		
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$data['entry_status'] = $entry_permission; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		
		if($employee_grid_permission==1 || $permission_grid_permission==1){
			$sql = "SELECT id, title, text, photo,	
					$employee_grid_permission as permission_status, $entry_permission as update_status,	
					$entry_permission as delete_status 
					FROM banner_image order by id desc limit $start, $end";	
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
	
	case "get_bannerImg_details":
		$update_permission = $dbClass->getUserGroupPermission(10);
		if($update_permission==1){
			$details = $dbClass->getResultList("SELECT id, title, text, photo	
												from banner_image
												where id='$bannerImg_id'");
			foreach ($details as $row){
				$data['records'][] = $row;
			}			
			echo json_encode($data);
		}
	break;
	

	case "delete_bannerImg":	 
		$attachment_name = $dbClass->getSingleRow("select photo from banner_image where id = $bannerImg_id");	
		$condition_array = array(
			'id'=>$bannerImg_id
		);
		if($dbClass->delete("banner_image", $condition_array)){
			unlink("../images/banner/".$attachment_name['attachment']);
			unlink("../images/banner/thumb".$attachment_name['attachment']);
			echo 1;
		}
		else
			echo 0;			 
	break;	
}

?>