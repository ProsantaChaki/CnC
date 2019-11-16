<?php 
session_start();
include '../dbConnect.php';	
include("../dbClass.php");

$dbClass = new dbClass;	
extract($_POST);


if($q=="login_customer"){
	$username	= htmlspecialchars($_POST['username'],ENT_QUOTES);
	$pass	  	 = $_POST['password'];
	$query="select customer_id, password, email from customer_infos WHERE (username='".$username."' or email='".$username."')  and status=1";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$data = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'][] = $row;
		}	
		//if username exists
		if($stmt -> rowCount()>0){
			//compare the password
			if($row['password'] == md5($pass)){				
				$_SESSION['customer_id']=$row['customer_id']; 
				$_SESSION['customer_email']=$row['email']; 
				echo 1;
			}
			else
				echo 2; 
		}
		else
			echo 3; //Invalid Login
}


if($q=="forget_password"){
	$username	 = htmlspecialchars($_POST['forget_email'],ENT_QUOTES);
	$query="select email, username, customer_id from customer_infos WHERE  email='".$forget_email."'  and status=1";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$data = array();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $row) {
			$data['records'] = $row;
		}	
		//if username exists
		if($stmt -> rowCount()>0){
			// mail a new password to customer_id
			$customer_email = $data['records']['email'];
			$username 		= $data['records']['username'];
			$customer_id 	= $data['records']['customer_id'];			
			$new_password 	= md5(rand()); 
			//$msg = "Dear $username,  Here is your new password to login into Cakencookie personal account";
			//$sent_status = mail($customer_email,"Reset Password -By Cakencookie",$msg);
			/*if($sent_status == 1){
				// update the customers password by the new password
				$update_pass_sql = "UPDATE customer_infos set password=:new_password where customer_id=:customer_id";
				$stmt = $conn->prepare($update_activity_login_sql);
				$stmt->bindParam(':new_password', $new_password);
				$stmt->bindParam(':customer_id', $customer_id);		
				$stmt->execute();
			}				
			*/
			echo 1;
			
			
		}
		else
			echo 2; //Invalid email address
}


if($q=="registration"){
	$username	 = htmlspecialchars($_POST['cust_username'],ENT_QUOTES);
	$email	 = htmlspecialchars($_POST['cust_email'],ENT_QUOTES);
	
	$check_username = $dbClass->getSingleRow("select username from customer_infos WHERE  username='".$username."'");
	if($check_username['username'] != "") { echo 2; die;} //username is found, same username cant be taken
	
	$check_email = $dbClass->getSingleRow("select email from customer_infos WHERE  email='".$email."'");
	if($check_email['email'] != "") { echo 3; die;} //email is found, same email cant be taken
	
	$columns_value = array(
		'full_name'=>$cust_name,
		'username'=>$cust_username,
		'email'=>$cust_email,
		'address'=>$cust_address,
		'contact_no'=>$cust_contact,
		'status'=>1,
		'password'=>md5($cust_password)
	);	
	//var_dump($columns_value);die;	
	$return = $dbClass->insert("customer_infos", $columns_value);	
	if($return) echo "1";
	else 	echo "0";	
}

if($q=="contact_us_mail"){
	$to 	 = $dbClass->getDescription(38);
	$from 	 = $email;
	$subject = "Contact us mail from $first_name. '$subject'";
	
	$headers = 'From: ' . $from . "\r\n" .
			'Reply-To: ' . $from . "\r\n" .
			'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();	
	$body 	 = $message; 
	if(mail($to, $subject, $body, $headers)) echo 1;
	else									 echo 2; 
}


if($q=="insert_custom_cake"){
	
	$cc_image = "";
	if(isset($_FILES['cc_image_upload']) && $_FILES['cc_image_upload']['name'] != ""){
		$desired_dir = "../../admin/images/custom";
		chmod( "../../admin/images/custom", 0777);				
		$file_name = $_FILES['cc_image_upload']['name'];
		$file_size =$_FILES['cc_image_upload']['size'];
		$file_tmp =$_FILES['cc_image_upload']['tmp_name'];
		$file_type=$_FILES['cc_image_upload']['type'];	
		if($file_size < 5297152 ){
			if(file_exists("$desired_dir/".$file_name)==false){
				if(move_uploaded_file($file_tmp,"$desired_dir/".$file_name))
					$cc_image = "$file_name";						
			}
			else{//rename the file if another one exist
				$new_dir="$desired_dir/".time().$file_name;
				if(rename($file_tmp,$new_dir))
					$cc_image =time()."$file_name";				
			}
			chmod( "../../admin/images/custom/".$cc_image, 0775);
			$cc_image  = "images/custom/".$cc_image;
		}
		else{
			echo "3";die;
		}
	}
	else{
		$cc_image = "images/no_image.png";
	}	

	$columns_value = array(
		'cc_cake_weight'=>$cc_cake_weight,
		'cc_cake_tyre'=>$cc_cake_tyre,
		'cc_delevery_date'=>$cc_delevery_date,
		'cc_details'=>$cc_details,
		'cc_name'=>$cc_name,
		'cc_email'=>$cc_email,
		'cc_image'=>$cc_image,
		'cc_mobile'=>$cc_mobile
	);	
	//var_dump($columns_value);die;
	
	$return = $dbClass->insert("custom_cake", $columns_value);	
	if($return) echo "1";
	else 	echo "0";
}
 //     cc_attached_file 

?>