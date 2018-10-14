<?php
$mobile_no = $name = $email = $error_message = $success_message = "";
if(loader_session_isset('mobile_no')){
	$mobile_no = loader_get_session('mobile_no');
	$query = "select name,mobile_no,email from view_customer_info where mobile_no = '".$mobile_no."'";
	if($result = loader_query($query)){
		$row = loader_fetch_assoc($result);
		$name = $row['name'];
		$email = $row['email'];
	}else{
		$error_message = SERVER_ERROR;
	}
}
?>