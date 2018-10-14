<?php

$error_message = $success_message = "";
if(loader_post_isset('reset_mobile_no')){
	$userRow = array();
	loader_file_put_content('includes/logs/post_data','forgotpassword',$_REQUEST);
	$reset_mobile_no=loader_get_post_escape('reset_mobile_no');
	if("" == $reset_mobile_no){
		 $error_message = MANDATORY_MISSING;
	}else{
		if(validate_phone_number($reset_mobile_no))
		{
				$query="SELECT * FROM tbl_customer_info WHERE fld_mobile_no='".$reset_mobile_no."'";
				loader_file_put_content('includes/logs/query_data','forgotpassword',$query);
				if($result = loader_query($query))
				{
					if(loader_num_rows($result)>0)
					{
						$row = loader_fetch_assoc($result);
						$password = $row['fld_password'].""; 
						$send_paasword = "DriverLo login password for mobile no ".$reset_mobile_no." is ".$password;
						loader_send_sms($send_paasword,$reset_mobile_no,'reset_password');
						$error_message = PASSWORD_RESET_SUCCESS;
					}else{
							 $error_message = MOBILE_NOT_REGISTERED;
							}
				}else{
					$error_message =SERVER_ERROR;
				}
		}else{
			$error_message = MOBILE_INVALID;
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
	loader_file_put_content('includes/logs/send_data','login',$send_data);
}

?>