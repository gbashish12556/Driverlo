<?php
 $mobile_no = $old_password = $confirm_new_password = $new_password =$error_message = $success_message = "";
if(loader_post_isset('change_password_button')){
	$mobile_no = loader_get_post_escape('mobile_no');
	$old_password = loader_get_post_escape('old_password');
	$new_password = loader_get_post_escape('new_password');
	$confirm_new_password = loader_get_post_escape('confirm_new_password');
	if(("" == $mobile_no)||("" == $old_password)||("" == $new_password)||("" == $confirm_new_password)){
       $error_message = SERVER_ERROR;	
	}else{
		if(validate_phone_number($mobile_no))
		{
			$query1 = "select password from view_customer_info where mobile_no = '".$mobile_no."' ";
			//echo $query1;
			if($result1 = loader_query($query1)){
				if(loader_num_rows($result1)>0){
					$row1 = loader_fetch_assoc($result1);
					$fetched_old_password = $row1['password'];
					if($old_password == $fetched_old_password){
						if($new_password == $confirm_new_password){
							$query2 = "update tbl_customer_info set fld_password = '".$new_password."' where fld_mobile_no = '".$mobile_no."'";
							//echo $query2;
							if(loader_query($query2)){
								$success_message = UPDATE_SUCCESS;
							}else{
								$error_message = SERVER_ERROR;
							}
						}else{
						   $error_message = PASS_MISMATCH;
						}
					}
					else{
						$error_message = OLD_PASS_INCORRECT;
					}
				}else{
					$error_message = NO_MATCH_FOUND;
				}
			}else{
				$error_message = SERVER_ERROR;
			}
		}else{
			$error_message = MOBILE_INVALID;
		}
	}
}else if(loader_session_isset('mobile_no')){
	$mobile_no = loader_get_session('mobile_no');
	$query = "select password from view_customer_info where mobile_no = '".$mobile_no."'";
	if($result = loader_query($query)){
	   if(loader_num_rows($result)>0){
		 $row = loader_fetch_assoc($result);
		 $old_password = $row['password'];
	   }
	}else{
	     $error_message = SERVER_ERROR;
	}
}
?>