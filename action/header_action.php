<?php
ini_set('allow_url_fopen', 'On');
if(loader_post_isset('login_button')){
    $login_mobile_no = loader_get_post_escape('login_mobile_no');
	$login_password = loader_get_post_escape('login_password');	
	$query = "SELECT mobile_no,name,email,user_token FROM view_customer_info WHERE mobile_no = '".$login_mobile_no."' AND password = '".$login_password."'";	
	if(("" == $login_mobile_no)||("" == $login_password)){
		 echo "<script>
				alert('".MANDATORY_MISSING.".login_mobile_no ".$login_mobile_no." login_password".$login_password."');
		 </script>";
	}else{
		if(validate_phone_number($login_mobile_no)){
			 if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$row = loader_fetch_assoc($result);
					loader_set_session('mobile_no',$row['mobile_no']);
					loader_set_session('name',$row['name']);
					loader_set_session('email',$row['email']);
					loader_set_session('user_token',$row['user_token']);
					echo "<script>
						alert('".LOGIN_SUCCESS."');
						window.location.assign('index.php');          
					</script>";
				 }else{
					 echo "<script>
							alert('".MOBILE_NOT_REGISTERED."');
						 </script>";
					}
			}else{
			 echo "<script>
					alert('".SERVER_ERROR."');
			 </script>";
			}
		}else{
			echo "<script>
						alert('".MOBILE_INVALID."');
				 </script>";
		}
	}
	
}else if(loader_post_isset('signup_button')){
	$signup_mobile_no = loader_get_post_escape('signup_mobile_no');
	$signup_password = loader_get_post_escape('signup_password');	
	$confirm_signup_password = loader_get_post_escape('confirm_signup_password');	
	$signup_email = loader_get_post_escape('signup_email');
	$signup_name = loader_get_post_escape('signup_name');
	if(("" == $signup_mobile_no)||("" == $signup_password)||("" == $signup_email)||("" == $signup_name)){
		 echo "<script>
					alert('".MANDATORY_MISSING."');
			   </script>";
	}else{
		if(validate_phone_number($signup_mobile_no))
		{
			if(loader_isValidEmail($signup_email)){
				if(!IsEmailExist($signup_email))
				{
					if(!IsMobileExist($signup_mobile_no)){
						if($signup_password == $confirm_signup_password){
							 loader_set_session('signup_mobile_no',$signup_mobile_no);
							 loader_set_session('signup_password',$signup_password);
							 loader_set_session('signup_email',$signup_email);
							 loader_set_session('signup_name',$signup_name);
							 loader_set_session('otp_session',rand(100000,999999));
							 $otp ="Your DriverLo OTP is ".loader_get_session('otp_session');
							 loader_send_sms($otp,$signup_mobile_no,"header");
							$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
							$template_value_array = array('OTP Received',$signup_name,NOREPLY_EMAIL, $otp);
							global $mailTemplate;
							//$send = loader_send_mail($mailTemplate['otp_content'],$template_data_array,$template_value_array,$signup_email,NOREPLY_EMAIL,$mailTemplate['otp_subject']);
							  echo '<script>
									   $(document).ready(function(){
		
											   $("#myModal").modal();
										   });
								   </script>';
					   }else{
						 $error_message = PASS_MISMATCH;
					   }
					}else{
						 echo "<script>
								alert('".EXIST_MOBILE."');
							  </script>";
					}
				}else{
					 echo "<script>
							alert('".EXIST_EMAIL."');
					 </script>";
				}
			}else{
				echo "<script>
							alert('".EMAIL_INVALID."');
					 </script>";
			}
		}else{
			echo "<script>
						alert('".MOBILE_INVALID."');
				 </script>";
		}
	}
}
if(loader_post_isset('register_otp')){
    $register_otp = loader_get_post_escape('register_otp');
    $otp_session = loader_get_session('otp_session');
	if($register_otp == $otp_session){
		$signup_mobile_no =  loader_get_session('signup_mobile_no');
		 $signup_password = loader_get_session('signup_password');
		 $signup_email = loader_get_session('signup_email');
		 $signup_name = loader_get_session('signup_name');
		$query = "INSERT INTO tbl_customer_info (fld_mobile_no, fld_email, fld_password,fld_name, fld_total_point) VALUES('".$signup_mobile_no."', '".$signup_email."','".$signup_password."','".$signup_name."', '200')";
		if(loader_query($query)){
			$last_inserted_id = loader_last_inserted();
			$user_token = loader_hash($last_inserted_id);
			$words = preg_split("/[\s,_-]+/", $signup_name);
			$referal_code = "";
			foreach ($words as $w){
				$referal_code .= $w[0];
			}
			$referal_code .= $last_inserted_id;
			$referal_code = strtoupper($referal_code);
			if(customer_isTokenExist($user_token))
			{
				$query3 = "DELETE FROM tbl_customer_info WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
				if(loader_query($query3))
				{
					$error_message = REGISTRATION_FAILED;
				}
				else
				{
					$error_message = SERVER_ERROR;
				}
			}
			else
			{
				$query3 = "UPDATE tbl_customer_info SET fld_user_token = '".$user_token."', fld_referal_code = '".$referal_code."' WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
				if(loader_query($query3))
				{
					loader_set_session('mobile_no',$signup_mobile_no);
					loader_set_session('name',$signup_name);
					loader_set_session('email',$signup_email);
					loader_set_session('user_token',$user_token);
					loader_set_session('signup_mobile_no',""); 
					loader_set_session('signup_password',"");
					loader_set_session('signup_email',"");
					loader_set_session('signup_name',"");
					loader_set_session('otp_session',"");
					$send_paasword = "DriverLo login password for mobile no ".$signup_mobile_no." is ".$signup_password;
					//loader_send_sms($send_paasword,$signup_mobile_no,'booking_status');
					$message = $send_paasword ;
					$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
					$template_value_array = array(REGISTER_SUCCESS,$signup_name,$signup_email,$message);
					global $mailTemplate;
					$send = loader_send_mail($mailTemplate['welcome_content'],$template_data_array,$template_value_array,$signup_email,COMPANY_EMAIL,$mailTemplate['welcome_subject']);
					 echo "<script>
								alert('".REGISTER_SUCCESS."');
						   </script>";
				}
				else
				{
					$error_message = SERVER_ERROR;
				}
			}
		}else{
			 echo "<script>
					alert('".SERVER_ERROR."');
			 </script>";
		}
	}else{
		 echo "<script>
				alert('".INCORRECT_OTP."');
			 </script>";
		echo '<script>
				   $(document).ready(function(){
					   $("#myModal").modal();
				   });
			   </script>';
	 
	}
}

if(loader_post_isset('reset_mobile_no')){
	$reset_mobile_no=loader_get_post_escape('reset_mobile_no');
	$query="SELECT * FROM tbl_customer_info WHERE fld_mobile_no='".$reset_mobile_no."'";
	if($result = loader_query($query))
	{
		if(loader_num_rows($result)>0)
		{
			$row = loader_fetch_assoc($result);
			$password = $row['fld_password'].""; 
			$send_paasword = "DriverLo login password for mobile no ".$reset_mobile_no." is ".$password;
			loader_send_sms($send_paasword,$reset_mobile_no,'reset_password');
			echo "<script>
					alert('".PASSWORD_RESET_SUCCESS."');
			 </script>";
		}else{
				 echo "<script>
						alert('".MOBILE_NOT_REGISTERED."');
					 </script>";
				}
	}else{
		 echo "<script>
				alert('".SERVER_ERROR."');
		 </script>";
	}
}
?>