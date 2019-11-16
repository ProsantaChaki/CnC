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
		if(isset($master_id)  && $master_id == ""){
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../document/notice_attachment";
				chmod( "../document/notice_attachment", 0777);
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments .= "$file_name ,";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							if(rename($file_tmp,$new_dir))
								$attachments .=time()."$file_name ,";				
						}	
					}
					else {
						echo $img_error_ln;die;
					}					
				}
				$attachments  = rtrim($attachments,",");
			}
			$banner_img = "";
			if(isset($_FILES['attached_document']) && $_FILES['attached_document']['name']!= ""){
				$desired_dir = "../document/banner_attachment";
				chmod( "../document/banner_attachment", 0777);
				$file_name = $_FILES['attached_document']['name'];
				$file_size = $_FILES['attached_document']['size'];
				$file_tmp  = $_FILES['attached_document']['tmp_name'];
				$file_type = $_FILES['attached_document']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$banner_img .= "$file_name";
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir))
							$banner_img .=time()."$file_name";				
					}	
				}
				else {
					echo $img_error_ln;die;
				}					
			}
			if(trim($expire_date) == "") $expire_date="0000-00-00";				
			$columns_value = array(
				'title'=>$title,
				'details'=>$details,
				'attachment'=>$attachments,
				'banner_img'=>$banner_img,
				'expire_date'=>$expire_date,
				'posted_by'=>$loggedUser,
				'type'=>$notice_type
			);			
			$return = $dbClass->insert("web_notice", $columns_value);
			if($return) echo "1";
			else 		echo "0";
		}
		else if(isset($master_id) && $master_id>0){
			$attachments= "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$attachments = "";
				$desired_dir = "../document/notice_attachment";
				chmod( "../document/notice_attachment", 0777);
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
								$attachments .= "$file_name,";
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							if(rename($file_tmp,$new_dir))
								$attachments .=time()."$file_name ,";				
						}	
					}
					else {
						echo "img_error";die;
					}					
				}
				$attachments  = rtrim($attachments,",");
			}
			$banner_img = "";
			if(isset($_FILES['attached_document']) && $_FILES['attached_document']['name']!= ""){
				$prev_banner = $dbClass->getSingleRow("select banner_img from web_notice where id = $master_id");
				if($prev_banner != ""){
					unlink("../document/banner_attachment/".$prev_banner['banner_img']);
				}
				$desired_dir = "../document/banner_attachment";
				chmod( "../document/banner_attachment", 0777);
				$file_name = $_FILES['attached_document']['name'];
				$file_size = $_FILES['attached_document']['size'];
				$file_tmp  = $_FILES['attached_document']['tmp_name'];
				$file_type = $_FILES['attached_document']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$banner_img .= "$file_name";
					}	
				}
				else {
					echo $img_error_ln;die;
				}					
			}
			$prev_attachment = $dbClass->getSingleRow("select attachment from web_notice where id = $master_id");	
			if($prev_attachment['attachment'] != "")  $attachments = $attachments.",".$prev_attachment['attachment'];
			$attachments  = ltrim($attachments,",");
			$columns_value = array(
				'title'=>$title,
				'details'=>$details,
				'attachment'=>$attachments,
				'banner_img'=>$banner_img,
				'expire_date'=>$expire_date,
				'posted_by'=>$loggedUser,
				'type'=>$notice_type
			);			
			$condition_array = array(
				'id'=>$master_id
			);
			$return = $dbClass->update("web_notice",$columns_value, $condition_array);
			if($return) echo "2";
			else 		echo "0";		 		
		}
	break;

	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();		

		$countsql = "select count(id) from web_notice WHERE CONCAT(title,details) LIKE '%$search_txt%'";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		$sql = "SELECT id, title, details, banner_img, attachment, expire_date, banner_img,`type` type, post_date,
				case type when 1 then 'News' when 2 then 'Event' end notice_type, status as status_id,
				case status when 1 then 'Pending' when 2 then 'Approved' when 3 then 'Deleted' end notice_status
				from web_notice WHERE CONCAT(title,details) LIKE '%$search_txt%' order by id desc limit $start, $end";
		//echo $sql;die;
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);		 
	break; 
	
	case "get_notice_details":
		$notice_details = $dbClass->getResultList("select * from web_notice where id=$notice_id");
		foreach ($notice_details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);			
	break;

	case "delete_attached_file":	 
		$prev_attachment = $dbClass->getSingleRow("select attachment from web_notice where id=$master_id");	
		$prev_attachment_array = explode(",",$prev_attachment['attachment']);
		if(($key = array_search($file_name, $prev_attachment_array)) !== false) {
			unset($prev_attachment_array[$key]);
		}
	 	$attachment = implode(",",$prev_attachment_array);
	 	$columns_value = array(
			'attachment'=>$attachment
		);	 
		$condition_array = array(
			'id'=>$master_id
		);
		if($dbClass->update("web_notice",$columns_value, $condition_array)){
			unlink("../document/notice_attachment/".$file_name);
			echo 1;
		}
		else
			echo 0;			 
	break;
	
	case "delete_notice":
		$attachment = $dbClass->getSingleRow("select attachment from web_notice where id = $notice_id");	
		$attachment_array = explode(",",$attachment['attachment']);
		for($i=0;$i<count($attachment_array);$i++){
			unlink("../document/notice_attachment/".$attachment_array[$i]);
		} 
		$condition_array = array(
			'id'=>$notice_id
		);
		$return = $dbClass->delete("web_notice", $condition_array);

		if($return) echo "1";
		else 		echo "0";	
	
	break;
}
?>