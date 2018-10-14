<?php
$error_message = $success_message = "";
loader_file_put_content('includes/logs/post_data','gen_registration_otp',$_REQUEST);
if(loader_post_isset('signup_mobile_no')){
	$signup_mobile_no = loader_get_post_escape('signup_mobile_no');
	$signup_email = loader_get_post_escape('signup_email');
	$OTP = loader_get_post_escape('OTP');
	if(("" == $signup_mobile_no)||("" == $OTP)||("" == $signup_email)){
		 $error_message = MANDATORY_MISSING;
	}else{
		if(loader_isValidEmail($signup_email)){
			if(!IsEmailExist($signup_email))
			{
				if(validate_phone_number($signup_mobile_no)){
					if(!IsMobileExist($signup_mobile_no))
					{
						if(validate_otp($OTP)){
							$otp_message ="Your DriverLo OTP is ".$OTP."";
							//loader_send_sms($otp_message,$signup_mobile_no,"gen_registration_otp");
							$success_message = OTP_SUCCESS;
						}else{
							$error_message = OTP_INVALID;
						}
					}else{
						$error_message = EXIST_MOBILE;
					}
				}else{
					$error_message = MOBILE_INVALID;
				}
			}else{
				$error_message = EXIST_EMAIL;
			}
		}else{
			$error_message = EMAIL_INVALID;
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