<?php
 $name = $email = $error_message = $success_message = "";
if(loader_post_isset('update_profile_button')&&loader_session_isset('mobile_no')){
	$user_token = loader_get_session('user_token');
	$name = loader_get_post_escape('name');
	$email = loader_get_post_escape('email');
	if(("" == $name)||("" == $email)){
       $error_message = SERVER_ERROR;	
	}else{
		if(loader_isValidEmail($email))
		{
			if(!isRepeatEmail($user_token,$email)){
				$query = "update tbl_customer_info set fld_name= '".$name."',fld_email= '".$email."' where fld_user_token = '".$user_token."' ";
				if(loader_query($query)){
					$success_message = UPDATE_SUCCESS;
				}else{
					$error_message = SERVER_ERROR;
				}
			}else{
				$error_message = EMAIL_EXIST;
			}
		}else{
			$error_message = EMAIL_INVALID;
		}
	}
}
else if(loader_session_isset('mobile_no')){
	$mobile_no = loader_get_session('mobile_no');
	$query = "select name,email from view_customer_info where mobile_no = '".$mobile_no."'";
	if($result = loader_query($query)){
		$row = loader_fetch_assoc($result);
		$name = $row['name'];
		$email = $row['email'];
	}else{
		$error_message = SERVER_ERROR;
	}
}


?>