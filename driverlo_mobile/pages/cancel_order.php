<?php

$error_message = $success_message= "";
loader_file_put_content('includes/logs/post_data','cancel_order',$_REQUEST);
if(loader_post_isset('customer_token')){
	$userRow = array();
	$customer_token = loader_get_post_escape('customer_token');
	$brn_no = loader_get_post_escape('brn_no');
	if(("" == $customer_token)||("" == $brn_no)){
	     $error_message = MANDATORY_MISSING;
	}else{
		if(validate_customer_token($customer_token))
		{
			$query_update_cancel = "UPDATE tbl_booking_detail SET fld_is_cancelled = '1' WHERE fld_brn_no =  '".$brn_no."' ";
			loader_file_put_content('includes/logs/query_data','cancel_order',$query_update_cancel);
			if(loader_query($query_update_cancel)){
				$success_message = UPDATE_SUCCESS;
			}else{
				$error_message = SERVER_ERROR;
			}
		}else{
			$error_message = CUSTOMER_TOKEN_INVALID;
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
	loader_file_put_content('includes/logs/send_data','cancel_order',$send_data);
}
?>