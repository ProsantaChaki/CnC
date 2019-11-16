<?php 
session_start();
include '../includes/static_text.php';
include("../dbConnect.php");
include("../dbClass.php");

$dbClass = new dbClass;
$conn       = $dbClass->getDbConn();
$loggedUser = $dbClass->getUserId();	

extract($_REQUEST);
switch($q){
	case "insert_or_update":
		if(isset($master_id) && $master_id == ""){
			if(isset($parent_menu_select) && $parent_menu_select != ""){
				$columns_value = array(
					'menu'=>$menu,
					'title'=>$title,
					'description'=>$details,
					'parent_menu_id'=>$parent_menu_select
				);	
			}else{
				$columns_value = array(
					'menu'=>$menu,
					'title'=>$title,
					'description'=>$details
				);	
			}
			$return_menu = $dbClass->insert("web_menu", $columns_value);
			if($return_menu) echo "1";
			else			 echo "0";	
		}
		else if(isset($master_id) && $master_id>0){
			if(isset($parent_menu_select) && $parent_menu_select != ""){
				$columns_value = array(
					'menu'=>$menu,
					'title'=>$title,
					'description'=>$details,
					'parent_menu_id'=>$parent_menu_select
				);				
			}else{
				$columns_value = array(
					'menu'=>$menu,
					'title'=>$title,
					'description'=>$details
				);	
			}
			$condition_array = array(
				'id'=>$master_id
			);
			$return_menu = $dbClass->update("web_menu", $columns_value, $condition_array);
			if($return_menu) echo "1";
			else			 echo "0";			
		}	
	break;
	
	case "get_menus":
		$users = $dbClass->getResultList("select CONCAT(m.id,'*', m.menu) module_menu_ids from web_menu m");
		foreach ($users as $row) {
			$module_menu_ids_arr = explode(',',$row['module_menu_ids']);
			$arr['module_menu']=$module_menu_ids_arr;			
			$data['records'][] = $arr;
		}			
		echo json_encode($data);
	break;
	
	case "grid_data":	
		$start = ($page_no*$limit)-$limit;
		$end   = $limit;
		$data = array();

		$countsql = "select count(m.id) from web_menu m WHERE CONCAT(title,menu) LIKE '%$search_txt%'";
		$stmt = $conn->prepare($countsql);
		$stmt->execute();
		$total_records = $stmt->fetchColumn();
		$data['total_records'] = $total_records; 
		$total_pages = $total_records/$limit;		
		$data['total_pages'] = ceil($total_pages);
		
		$sql = "SELECT m.id, m.parent_menu_id, m.title, m.menu, m.description, ifnull(wm.menu,'') parent_menu
				FROM web_menu m
				LEFT JOIN web_menu wm ON wm.id = m.parent_menu_id WHERE CONCAT(m.title, m.menu) LIKE '%$search_txt%'
				ORDER BY m.id desc limit $start, $end";
		//echo $sql;		
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);	 
	break;
	
	case "get_page_details":
		$sql = "select m.id, m.parent_menu_id, m.title, m.menu, 
				m.description, ifnull(web.menu,'') parent_menu 
				from web_menu m 
				left join web_menu web on web.id = m.parent_menu_id
				where m.id = '$menu_id'";
		//echo $sql;die;
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
		foreach ($result as $row) {
			$data['records'][] = $row;
		}			
		echo json_encode($data);
	break;
	
	case "delete_menu":
		$condition_array = array(
			'id'=>$menu_id
		);
		$return = $dbClass->delete("web_menu", $condition_array);
		if($return) echo "1";
		else 		echo "0";
	break;
}

?>