<?php
$error_message = $success_message= "";
loader_file_put_content('includes/logs/post_data','rate_driver',$_REQUEST);
if(loader_post_isset('brn_no')){
	$userRow = array();
	$brn_no = loader_get_post_escape('brn_no');
	//$name = loader_get_post_escape('name');
	//$mobile_no = loader_get_post_escape('mobile_no');
	$driver_rating = loader_get_post_escape('driver_rating');
	$customer_feedback = loader_get_post_escape('customer_feedback');
	if(("" == $brn_no)||("" == $driver_rating)||("" == $customer_feedback)){
	     $error_message = MANDATORY_MISSING;
	}else{
		$query = "UPDATE tbl_booking_detail SET fld_driver_rating = '".$driver_rating."', fld_customer_feedback = '".$customer_feedback."' WHERE fld_brn_no = '".$brn_no."' ";
		loader_file_put_content('includes/logs/query_data','rate_driver',$query);
		if(loader_query($query)){
			$success_message = UPDATE_SUCCESS;
		}else{
			$error_message = SERVER_ERROR;
		}
	}
	if($error_message == "")
	{
		$errFlag = "0";			// Success status
		$errMsg = $success_message;
	}
	else
	{
		$errFlag = "1";			// Failure status
		$errMsg = $error_message;
	}
		$userRow["errFlag"] = $errFlag."";
		$userRow["errMsg"] = $errMsg."";
	//$json = array("errFlag" => $errFlag, "errMsg" => $errMsg, "likes" => $noteRow);
	//header('Content-Type: application/json');
	$send_data = json_encode($userRow);
	loader_display($send_data);
	loader_file_put_content('includes/logs/send_data','rate_driver',$send_data);
}


?>