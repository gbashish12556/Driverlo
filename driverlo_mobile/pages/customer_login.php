<?php

$error_message = $success_message = "";
loader_file_put_content('includes/logs/post_data','login',$_REQUEST);
if(loader_post_isset('login_mobile_no')){
	$userRow = array();
    $login_mobile_no = loader_get_post_escape('login_mobile_no');
	$login_password = loader_get_post_escape('login_password');	
	if(("" == $login_mobile_no)||("" == $login_password)){
		 $error_message = MANDATORY_MISSING;
	}else{
		if(validate_phone_number($login_mobile_no))
		{
			if(IsMobileRegistered($login_mobile_no))
			{
				 $query = "SELECT mobile_no,name,user_token, referal_code FROM view_customer_info WHERE mobile_no = '".$login_mobile_no."' AND password = '".$login_password."'";	
				 loader_file_put_content('includes/logs/query_data','login',$query);
				 if($result = loader_query($query)){
					if(loader_num_rows($result)>0){
						$userRow['likes'] = array();
						$row = loader_fetch_assoc($result);
						$userRow['likes'][0]['mobile_no'] = $row['mobile_no']."";
						$userRow['likes'][0]['name'] = $row['name']."";
						$userRow['likes'][0]['customer_token'] = $row['user_token']."";
						$userRow['likes'][0]['referal_code'] = $row['referal_code']."";
						$success_message =  LOGIN_SUCCESS;
					 }else{
						 $error_message = PASSWORD_INCORRECT;
					}
				}else{
					 $error_message = SERVER_ERROR;
				}
			}else{
				$error_message = MOBILE_NOT_REGISTERED;
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