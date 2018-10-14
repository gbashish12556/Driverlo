<?php
$referal_code = $name = $email = $mobile_no= $password = $error_message = $success_message = $rating = "";
if(loader_post_isset('name')){
	$name = $signup_name = loader_get_post_escape('name');
	$email = $signup_email = loader_get_post_escape('email');
	$mobile_no = $signup_mobile_no= loader_get_post_escape('mobile_no');
	$password = $signup_password =loader_get_post_escape('password');
	$referal_code =loader_get_post_escape('referal_code');
	$rating =loader_get_post_escape('rating');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $signup_mobile_no)||("" == $signup_password)||("" == $signup_email)||("" == $signup_name)||("" == $rating)){
			 $error_message .= MANDATORY_MISSING;
		}else{
			if(loader_isValidEmail($signup_email)){
				if(validate_phone_number($signup_mobile_no)){
						if(!IsCustomerEmailExist($signup_email))
						{
							if(!IsCustomerMobileExist($signup_mobile_no)){
								$customer_point = 200;
								if("" != $referal_code){
									$query_referral = "SELECT total_point FROM view_customer_info WHERE referal_code = '".$referal_code."' ";
									loader_file_put_content(LOG_PATH.'query_data','register',$query_referral);
									if($result_referral = loader_query($query_referral)){
										if(loader_num_rows($result_referral)>0){
											$row = loader_fetch_assoc($result_referral);
											$total_referral_point = $row['total_point']+100;
										}else{
											$error_message .= REFERRAL_MOBILE_NOT_EXIST;
										}
									}
								}						
								if("" == $error_message)
								{
									$query = "INSERT INTO tbl_customer_info (fld_mobile_no, fld_email, fld_password,fld_name, fld_total_point, fld_rating) VALUES('".$signup_mobile_no."', '".$signup_email."','".$signup_password."','".$signup_name."', '".$customer_point."', '".$rating."')";
								//	loader_file_put_content(LOG_PATH.'query_data','register',$query);
									if(loader_query($query)){
										$last_inserted_id = loader_last_inserted();
										$user_token = loader_hash($last_inserted_id);
										$words = preg_split("/[\s,_-]+/", $signup_name);
										$signup_referal_code = "";
										foreach ($words as $w){
											$signup_referal_code .= $w[0];
										}
										$signup_referal_code .= $last_inserted_id;
										$signup_referal_code = strtoupper($signup_referal_code);
										//loader_file_put_content(LOG_PATH.'query_data','get_customer_info',$query);
										if(($customer_point == 200)&&("" != $referal_code))
										{
											$update_referral_query = "UPDATE tbl_customer_info SET fld_total_point = '".$total_referral_point."' WHERE fld_referal_code = '".$referal_code."' ";
											loader_query($update_referral_query);
										}
										if(customer_isTokenExist($user_token))
										{
											$query3 = "DELETE FROM tbl_customer_info WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
											if(loader_query($query3))
											{
												loader_file_put_content(LOG_PATH.'extra_data','collided_and_removed','Customer id:'.$last_inserted_id.' Token:'.$user_token."\r\n");
												$error_message .= REGISTRATION_FAILED;
											}
											else
											{
												loader_file_put_content(LOG_PATH.'extra_data','collided_not_removed','Customer id:'.$last_inserted_id.' Token:'.$user_token."\r\n");
												$error_message .= SERVER_ERROR;
											}
										}
										else
										{
											$query3 = "UPDATE tbl_customer_info SET fld_user_token = '".$user_token."', fld_referal_code = '".$signup_referal_code."' WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
											//loader_file_put_content(LOG_PATH.'query_data','get_customer_info',$query3);
											if(loader_query($query3))
											{
												$send_paasword = "DriverLo login password for mobile no ".$signup_mobile_no." is ".$signup_password." ";
												//loader_send_sms($send_paasword,$signup_mobile_no,'booking_status');
												$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
												$template_value_array = array(REGISTER_SUCCESS,$signup_name,$signup_email,$send_paasword);
												global $mailTemplate;
												$send = loader_send_mail($mailTemplate['welcome_content'],$template_data_array,$template_value_array,$signup_email,COMPANY_EMAIL,$mailTemplate['welcome_subject']);
												?>
													<script type="text/javascript">
													setTimeout(function () {
														 window.location='<?php loader_display(ROOT_PATH.'customer'); ?>';
														   }, 2000); //
													</script>
												 <?php 
												$success_message = REGISTER_SUCCESS;
											}
											else
											{
												$error_message .= SERVER_ERROR;
											}
										}
									}else{
										 $error_message .= SERVER_ERROR;
									}
								}
							}else{
								$error_message .= EXIST_MOBILE;
							}
						}else{
							$error_message .= EXIST_EMAIL;
						}
				}else{
					$error_message .= MOBILE_INVALID;
				}
			}else{
				$error_message .= EMAIL_INVALID;
			}
		}
	}
}
?>