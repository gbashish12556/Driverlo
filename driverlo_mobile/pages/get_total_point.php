<?php
$error_message = $success_message = "";
loader_file_put_content('includes/logs/post_data','get_total_point',$_REQUEST);
if(loader_post_isset('customer_token')){
	$userRow = array();
    $customer_token = loader_get_post_escape('customer_token');
	if(("" == $customer_token)){
		 $error_message = MANDATORY_MISSING;
	}else{
		if(validate_customer_token($customer_token)){
			$query = "SELECT total_point FROM view_customer_info WHERE user_token = '".$customer_token."' ";
			if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$userRow['likes'] = array(); 
					$row = loader_fetch_assoc($result);
					$userRow['likes'][0]['total_point'] = $row ['total_point'];
					$success_message = UPDATE_SUCCESS;
				}
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
	loader_file_put_content('includes/logs/send_data','get_total_point',$send_data);
}


?>