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
		if(isset($product_id) && $product_id == ""){
			//var_dump($_REQUEST);die;
			$feature_image = "";
			if(isset($_FILES['feature_image_upload']) && $_FILES['feature_image_upload']['name'] != ""){
				$desired_dir = "../images/product";
				chmod( "../images/product", 0777);				
				$file_name = $_FILES['feature_image_upload']['name'];
				$file_size =$_FILES['feature_image_upload']['size'];
				$file_tmp =$_FILES['feature_image_upload']['tmp_name'];
				$file_type=$_FILES['feature_image_upload']['type'];	

				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$feature_image = "$file_name";						
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir))
							$feature_image =time()."$file_name";				
					}
					chmod( "../images/product/".$feature_image, 0775);	
				}
				else{
					echo $img_error_ln;die;
				}
			}
			else{
				$feature_image = "";
			}
			
			$columns_value = array(
				'name'=>$product_name,
				'code'=>$product_code,
				'details'=>$details,
				'category_id'=>$category_option,
				'tags'=>$tag,
				'feature_image'=>$feature_image
			);				
			$return_product = $dbClass->insert("products", $columns_value); 
			
			if(isset($ingredient)){
				foreach($ingredient as $row){
					$columns_value = array(
						'product_id'=>$return_product,
						'ingredient_id'=>$row
					);				
					$return_ingredient = $dbClass->insert("product_ingredient", $columns_value);
				}		
			}
			
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../images/product";
				$desired_dir_thumb = "../images/product/thumb";
				
				chmod( "../images/product", 0777);
				chmod( "../images/product/thumb", 0777);
				
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							$dbClass->store_uploaded_image($file_tmp, 300, 300, $desired_dir_thumb, "$desired_dir/thumb/".$file_name);							
							$dbClass->store_uploaded_image($file_tmp, 555, 555, $desired_dir_thumb, "$desired_dir/".$file_name);
							$attachments = "$file_name";	
							/*if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name)){															
							}*/
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							$dbClass->store_uploaded_image($file_tmp, 300, 300, $desired_dir_thumb, "$desired_dir/thumb/".time().$file_name);
							if(rename($file_tmp,$new_dir)){
								$attachments =time()."$file_name";
							}								
						}
						chmod( "../images/product/".$attachments, 0775);	
						$columns_value = array(
							'product_id'=>$return_product,
							'product_image'=>$attachments
						);			
						$return_details = $dbClass->insert("product_image",$columns_value);		
					}
					else{
						echo $img_error_ln;die;
					}					
				}
			}			
			if($return_product){
				foreach($size_id as $key=>$row){
					$columns_value = array(
						'product_id'=>$return_product,
						'size_id'=>$size_id[$key],
						'rate'=>$rate[$key],
						'discounted_rate'=>$rate[$key],
					);				
					$return_rate = $dbClass->insert("product_rate", $columns_value);
				}		
			} 
			
			if($return_rate){
				echo "1";
			}
			else{
				echo "0";
			}
			
		}
		else if(isset($product_id) && $product_id>0){
			//var_dump($_REQUEST);die;
			
			$is_order_result = $dbClass->getSingleRow("select distinct(d.order_id) order_id, p.category_id 
													FROM products p
													LEFT JOIN order_details d on d.product_id = p.product_id  	
													WHERE p.product_id = $product_id");	
			
			if($is_order_result['category_id'] != $category_option){
				if($is_order_result['order_id'] != "" || $is_order_result['order_id'] != NULL) { echo 3; die;}
			} 
			
			if(isset($_FILES['feature_image_upload']) && $_FILES['feature_image_upload']['name'] != ""){
				
				$prev_feature_attachment = $dbClass->getSingleRow("select feature_image from products where product_id = $product_id");	
				if($prev_feature_attachment['feature_image'] != "" || $prev_feature_attachment['feature_image'] != NULL){
					unlink("../images/product/".$prev_feature_attachment['feature_image']);				
				}
				
				$desired_dir = "../images/product";				
				chmod( "../images/product", 0777);				
				
				$file_name = $_FILES['feature_image_upload']['name'];
				$file_size =$_FILES['feature_image_upload']['size'];
				$file_tmp =$_FILES['feature_image_upload']['tmp_name'];
				$file_type=$_FILES['feature_image_upload']['type'];	
				if($file_size < $file_max_length){
					if(file_exists("$desired_dir/".$file_name)==false){
						if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
							$feature_image = "$file_name";							
					}
					else{//rename the file if another one exist
						$new_dir="$desired_dir/".time().$file_name;
						if(rename($file_tmp,$new_dir)){
							$feature_image =time()."$file_name";
						}							
					}
					chmod( "../images/product/".$feature_image, 0775);
				}
				else{
					echo $img_error_ln;die;
				}
				$columns_value = array(
					'feature_image'=>$feature_image
				);				
				$condition_array = array(
					'product_id'=>$product_id
				);
				$return_image = $dbClass->update("products", $columns_value,$condition_array); 
			}
			else{				
				if(!isset($_POST['is_feature'])){
					$prev_feature_attachment = $dbClass->getSingleRow("select feature_image from products where product_id = $product_id");	
					//var_dump($prev_feature_attachment);die;
					if($prev_feature_attachment['feature_image'] != "" || $prev_feature_attachment['feature_image'] != NULL){					
						// not working properly 
						$columns_value = array(
							'feature_image'=>""
						);				
						$condition_array = array(
							'product_id'=>$product_id
						);
						$return_image = $dbClass->update("products", $columns_value,$condition_array);
						//echo "hei---".$return_image;die;						
						if($return_image){
							unlink("../images/product/".$prev_feature_attachment['feature_image']);	
						}
						//-----------------------
					}
				}
			}			
			
			$is_active=0;
			if(isset($_POST['is_active'])){
				$is_active=1;
			}
				
			$columns_value = array(
				'name'=>$product_name,
				'code'=>$product_code,
				'details'=>$details,
				'category_id'=>$category_option,
				'availability'=>$is_active,
				'tags'=>$tag
			);				
			$condition_array = array(
				'product_id'=>$product_id
			);	
			$return_product = $dbClass->update("products", $columns_value,$condition_array); 

			if(isset($ingredient)){
				$condition_array = array(
					'product_id'=>$product_id
				);
				$return = $dbClass->delete("product_ingredient", $condition_array);
				
				foreach($ingredient as $row){
					$columns_value = array(
						'product_id'=>$product_id,
						'ingredient_id'=>$row
					);				
					$return_ingredient = $dbClass->insert("product_ingredient", $columns_value);
				}		
			}	
			
			if(isset($size_id)){
				$condition_array = array(
					'product_id'=>$product_id
				);
				$return = $dbClass->delete("product_rate", $condition_array);
				
				foreach($size_id as $key=>$row){
					$columns_value = array(
						'product_id'=>$product_id,
						'size_id'=>$size_id[$key],
						'discounted_rate'=>$rate[$key],
						'rate'=>$rate[$key]
					);				
					$return_rate = $dbClass->insert("product_rate", $columns_value);
				}		
			} 
			
			$attachments = "";
			if(isset($_FILES['attached_file']) && $_FILES['attached_file']['name'][0] != ""){
				$desired_dir = "../images/product";
				$desired_dir_thumb = "../images/product/thumb";
				chmod( "../images/product", 0775);
				chmod( "../images/product/thumb", 0777);
				
				foreach($_FILES['attached_file']['tmp_name'] as $key => $tmp_name ){
					$file_name = $_FILES['attached_file']['name'][$key];
					$file_size =$_FILES['attached_file']['size'][$key];
					$file_tmp =$_FILES['attached_file']['tmp_name'][$key];
					$file_type=$_FILES['attached_file']['type'][$key];	
					if($file_size < $file_max_length){
						if(file_exists("$desired_dir/".$file_name)==false){
							$dbClass->store_uploaded_image($file_tmp, 300, 300, $desired_dir_thumb, "$desired_dir/thumb/".$file_name) ;
							$dbClass->store_uploaded_image($file_tmp, 550, 550, $desired_dir_thumb, "$desired_dir/".$file_name) ;
							$attachments = "$file_name";	
							/*if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name)){
							}*/
						}
						else{//rename the file if another one exist
							$new_dir="$desired_dir/".time().$file_name;
							$dbClass->store_uploaded_image($file_tmp, 300, 300, $desired_dir_thumb, "$desired_dir/thumb/".$file_name) ;
							if(rename($file_tmp,$new_dir)){
								$attachments =time()."$file_name";
							}
						}
						chmod( "../images/product/".$attachments, 0775);
						$columns_value = array(
							'product_id'=>$product_id,
							'product_image'=>$attachments
						);			
						$return_details = $dbClass->insert("product_image",$columns_value);		
					}
					else{
						echo $img_error_ln;die;
					}					
				}
			}			
			if($return_product) echo "2";
			else echo "0";
		}
	break;
	
	case "grid_data":
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();
		
		$entry_permission   	    = $dbClass->getUserGroupPermission(62);
		$delete_permission          = $dbClass->getUserGroupPermission(63);
		$update_permission          = $dbClass->getUserGroupPermission(64);
		
		$category_grid_permission   = $dbClass->getUserGroupPermission(65);
		
		$condition = "";
		//# advance search for grid		
		if($search_txt == "Print" || $search_txt == "Advance_search"){	
			// for advance condition 				
			if($is_active_status !=2) $condition  .=" WHERE availability = $is_active_status ";
			if($ad_category_id != '') $condition  .=" and category_id = $ad_category_id ";	
			if($ad_product_id != '')  $condition  .=" and product_id = $ad_product_id ";		
		}
		// textfield search for grid
		else{
			$condition .=	" WHERE CONCAT(product_id, name, code, category_head_name) LIKE '%$search_txt%' ";			
		}
		
		$countsql = "SELECT count(product_id)
					FROM(
						SELECT p.category_id, p.product_id, p.name, p.code, p.details, GROUP_CONCAT(s.name,' >> ',r.discounted_rate) p_rate, tags,p.availability,
						CASE WHEN c.parent_id IS NULL THEN c.name WHEN c.parent_id IS NOT NULL THEN CONCAT(ec.name,' >> ',c.name) END category_head_name,
						(CASE p.availability WHEN 1 THEN 'Available' WHEN 0 THEN 'Not-Available' END) active_status	
						FROM products p 
						LEFT JOIN product_rate r on r.product_id = p.product_id
						LEFT JOIN category c on c.id = p.category_id
						LEFT JOIN category ec ON c.parent_id = ec.id
						LEFT JOIN size s on s.id = r.size_id
						group by p.product_id
						ORDER BY p.product_id DESC 
					)A
					$condition";
		//echo $countsql;die;
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records;
		$data['entry_status'] = $entry_permission;	
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages); 
		if($category_grid_permission==1){
			$sql = 	"SELECT category_id, product_id, name, code, category_head_name, p_rate, details,tags,active_status,availability,
					$update_permission as update_status, $delete_permission as delete_status
					FROM(
						SELECT p.category_id, p.product_id, p.name, p.code, p.details, GROUP_CONCAT(s.name,' >> ',r.discounted_rate) p_rate, tags,p.availability,
						CASE WHEN c.parent_id IS NULL THEN c.name WHEN c.parent_id IS NOT NULL THEN CONCAT(ec.name,' >> ',c.name) END category_head_name,
						(CASE p.availability WHEN 1 THEN 'Available' WHEN 0 THEN 'Not-Available' END) active_status	
						FROM products p 
						LEFT JOIN product_rate r on r.product_id = p.product_id
						LEFT JOIN category c on c.id = p.category_id
						LEFT JOIN category ec ON c.parent_id = ec.id
						LEFT JOIN size s on s.id = r.size_id
						group by p.product_id
						ORDER BY p.product_id desc
					)A
					$condition
					ORDER BY product_id ASC
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
	
	case "get_product_details":
		$update_permission = $dbClass->getUserGroupPermission(64);
		if($update_permission==1){
			$sql = "SELECT p.product_id, p.name, p.code, p.details, c.id category_id, p.availability,feature_image, 
					GROUP_CONCAT(r.size_id,'*',s.name,'*',r.discounted_rate) p_rate, tags 
					FROM products p 
					LEFT JOIN product_rate r on r.product_id = p.product_id
					LEFT JOIN category c on c.id = p.category_id
					LEFT JOIN size s on s.id = r.size_id
					WHERE p.product_id = $product_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
			foreach ($result as $row) {
				$data['records'][] = $row;
			}	
			
			$attachment_details = $dbClass->getResultList("select id img_id, product_image from product_image where product_id = '$product_id'");
			//echo "select id img_id, product_image from product_image where product_id = '$product_id'";die;
			foreach ($attachment_details as $row) {
				$data['attachment'][] = $row;
			}
			
			$ingredient_details = $dbClass->getResultList("SELECT GROUP_CONCAT(id,'*',name,'*',check_status) details
														FROM (
															SELECT id, name, check_status 
															FROM (
																SELECT p.ingredient_id id, i.name, 1 check_status 
																FROM product_ingredient p
																LEFT JOIN ingredient i on i.id = p.ingredient_id 
																WHERE product_id = '$product_id'	
																UNION
																SELECT id, name, 0 check_status
																FROM ingredient 
															)	A
															GROUP BY id
														) B
														");
			foreach ($ingredient_details as $row) {
				$detail_arr = explode(',',$row['details']);
				$arr['detail']=$detail_arr;			
				$data['ingredient'][] = $arr;
			}
			
			echo json_encode($data);	
		}			
	break;
		
	case "category_wise_product_code":	
		$category_id 	= $_POST['category_id'];
		$category_code  = $_POST['category_code'];
		
		$last_product_code = $dbClass->getSingleRow("SELECT MAX(SUBSTR(p.code,LENGTH(c.code)+1)) product_code	
													FROM products p 
													LEFT JOIN category c on c.id = p.category_id
													WHERE c.id = '$category_id' AND LEFT(p.code,LENGTH(c.code)) = c.code");		
		
		if($last_product_code['product_code'] == 'NULL' || $last_product_code['product_code'] == ''){
			$new_product_code = $category_code.'0001'; 
		}
		else{
			$new_product_code = $category_code.$last_product_code['product_code']+1; 
		}  
		echo $new_product_code;  
	break;
	
	case "delete_attached_file":	
		$attachment_name = $dbClass->getSingleRow("select product_image from product_image where id = $img_id");	
		$condition_array = array(
			'id'=>$img_id
		);

		if($dbClass->delete("product_image", $condition_array)){
			unlink("../images/product/".$attachment_name['product_image']);
			unlink("../images/product/thumb/".$attachment_name['product_image']);
			echo 1;
		}
		else
			echo 0;			 
	break;
	
	case "delete_product":		
		$delete_permission = $dbClass->getUserGroupPermission(63);
		if($delete_permission==1){
			$condition_array = array(
				'product_id'=>$product_id
			);
			$columns_value = array(
				'availability'=>0
			);
			$return = $dbClass->update("products", $columns_value, $condition_array);
			/* $prev_attachment = $dbClass->getResultList("select product_image from product_image where product_id=$product_id");
			foreach($prev_attachment as $row){
				unlink("../images/product/".$row['product_image']);
				unlink("../images/product/thumb/".$attachment_name['product_image']);
			}
			$condition_array = array(
				'product_id'=>$product_id
			);
			
			$return = $dbClass->delete("product_ingredient", $condition_array);
			$return = $dbClass->delete("product_rate", $condition_array);
			$return = $dbClass->delete("product_image", $condition_array);
			$return = $dbClass->delete("products", $condition_array); */
		}
		if($return) echo "1";
		else 		echo "0";
	break;
	
	case "view_category": 
		$data = array();
		$details = $dbClass->getResultList("SELECT id, CONCAT(code,' >> ',head_name)category_name 
											FROM (
												SELECT c.id, c.code, 
												CASE WHEN c.parent_id IS NULL THEN c.name WHEN c.parent_id IS NOT NULL THEN CONCAT(ec.name,' >> ',c.name) END head_name
												FROM category c
												LEFT JOIN category ec ON c.parent_id = ec.id
												ORDER BY c.id
											) A");
		foreach ($details as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "get_ingredient":
		$all_ingredient = $dbClass->getResultList("select group_concat(id,'*',name) module_group_ids
												from ingredient");
		foreach ($all_ingredient as $row) {
			$module_group_ids_arr = explode(',',$row['module_group_ids']);
			$arr['module_group']=$module_group_ids_arr;			
			$data['records'][] = $arr;
		}			
		echo json_encode($data);
	break;
	
	case "size_info":
		$sql_query = "SELECT id, name, code, CONCAT_WS(' >> ',code,name) sizeDetails
					FROM size WHERE CONCAT(name, code) LIKE '%$term%'
					ORDER BY name";
		$stmt = $conn->prepare($sql_query);
		$stmt->execute();
		$json = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		$count = $stmt->rowCount();
		if($count>0){
			foreach ($result as $row) {
				$json[] = array('id' => $row["id"],'label' => $row["sizeDetails"]);
			}
		} else {
			$json[] = array('id' => "0",'label' => "No Size Name Found !!!");
		}						
		echo json_encode($json);
	break;
}

function resizeImage($filename, $newwidth, $newheight){
    list($width, $height) = getimagesize($filename);
    if($width > $height && $newheight < $height){
        $newheight = $height / ($width / $newwidth);
    } else if ($width < $height && $newwidth < $width) {
        $newwidth = $width / ($height / $newheight);   
    } else {
        $newwidth = $width;
        $newheight = $height;
    }
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    $source = imagecreatefromjpeg($filename);
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    return imagejpeg($thumb);
}


?>