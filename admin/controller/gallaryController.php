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
		//var_dump($_POST);die;
		if(isset($album_id)  && $album_id == ""){			
			$columns_value = array(
				'album_name'=>$album_name
			);			
			$return = $dbClass->insert("image_album", $columns_value);
			$last_album_id = $dbClass->getSingleRow("select id from image_album where album_name = '$album_name'");
			
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../document/gallary_attachment";
				$desired_dir_thumb = "../document/gallary_attachment/thumb";				
				chmod( "../document/gallary_attachment", 0775);
				chmod( "../document/gallary_attachment/thumb", 0775);
				
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							$dbClass->store_uploaded_image($file_tmp, 200, 200, $desired_dir_thumb, "$desired_dir/thumb/".$file_name);
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments = "$file_name";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							$dbClass->store_uploaded_image($file_tmp, 200, 200, $desired_dir_thumb, "$desired_dir/thumb/".time().$file_name);
							if(rename($file_tmp,$new_dir))
								$attachments =time()."$file_name";				
						}
						chmod( "../document/gallary_attachment/".$attachments, 0775);
						$columns_value = array(
							'title'=>$title,
							'album_id'=>$last_album_id['id'],
							'attachment'=>$attachments
						);			
						$return_details = $dbClass->insert("gallary_images",$columns_value);		
					}
					else{
						echo $img_error_ln;die;
					}					
				}
			}	
			else{
				$columns_value = array(
					'title'=>$title,
					'album_id'=>$last_album_id['id']
				);			
				$return_details = $dbClass->insert("gallary_images",$columns_value);
			}
			if($return_details) echo "1";
			else 				echo "0";
		}
		else if(isset($album_id) && $album_id>0){
			//var_dump($_REQUEST);die;
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../document/gallary_attachment";
				$desired_dir_thumb = "../document/gallary_attachment/thumb";				
				chmod( "../document/gallary_attachment", 0775);
				chmod( "../document/gallary_attachment/thumb", 0775);
				
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							$dbClass->store_uploaded_image($file_tmp, 200, 200, $desired_dir_thumb, "$desired_dir/thumb/".$file_name);
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments = "$file_name";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							$dbClass->store_uploaded_image($file_tmp, 200, 200, $desired_dir_thumb, "$desired_dir/thumb/".time().$file_name);
							if(rename($file_tmp,$new_dir))
								$attachments = time()."$file_name";				
						}
						chmod("../document/gallary_attachment/".$attachments, 0775);
						$columns_value = array(
							'title'=>$title,
							'album_id'=>$album_id,
							'attachment'=>$attachments
						);			
						$return_details = $dbClass->insert("gallary_images",$columns_value);		
						if($return_details) echo "2";
					}
					else{
						echo $img_error_ln;die;
					}					
				}
			}	
			else 				echo "1";		 		
		}
	break;
	
	case "album_name":
		$sql_query = "SELECT id,album_name FROM image_album WHERE album_name LIKE '%" . $term . "%' ORDER BY album_name";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();			
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["album_name"]);
			}
		} else {
			$json[] = array('id' => '0','label' => 'No Name Found');
		}			
		echo json_encode($json);			
	break;
	
	case "get_album_details":
		$data = array();
		$album_details = $dbClass->getResultList("select alb.id album_id, alb.album_name, img.title
												from image_album alb
												left join gallary_images img on alb.id = img.album_id
												where alb.id = '$master_id' group by alb.id");
		foreach ($album_details as $row){
			$data['records'][] = $row;
		}		
		$attachment_details = $dbClass->getResultList("select img.id img_id, img.attachment  
													from image_album mas 
													join gallary_images img on img.album_id = mas.id 
													where mas.id = '$master_id'");
		foreach ($attachment_details as $row){
			$data['attachment'][] = $row;
		}				
		echo json_encode($data);
		
	break;
	
	case "delete_attached_file":	 
		$attachment_name = $dbClass->getSingleRow("select attachment from gallary_images where id = $img_id");	
		$condition_array = array(
			'id'=>$img_id
		);
		if($dbClass->delete("gallary_images", $condition_array)){
			chmod( "../document/gallary_attachment/".$attachment_name['attachment'], 0775);
			chmod( "../document/gallary_attachment/thumb/".$attachment_name['attachment'], 0775);
			unlink("../document/gallary_attachment/".$attachment_name['attachment']);
			unlink("../document/gallary_attachment/thumb/".$attachment_name['attachment']);
			echo 1;
		}
		else
			echo 0;			 
	break;
	
}
?>