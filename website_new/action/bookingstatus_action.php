<?php

 $error_message = $success_message = ""; 
 $mobile_no = $name = $bcn_no = $pickup_point = $booking_datetime = $coupon_code = $approval_status = "N.A.";
 $otp_status = 0;
if(loader_post_isset('pickup_point')){
	$name = loader_get_post_escape('name');
	$mobile_no = loader_get_post_escape('mobile_no');
	$pickup_point = loader_get_post_escape('pickup_point');
	$booking_datetime = loader_get_post_escape('booking_datetime');
	$coupon_code = loader_get_post_escape('coupon_code');
	if(("" == $name)||("" == $mobile_no)||("" == $pickup_point)||("" == $booking_datetime)){
	     $error_message = MANDATORY_MISSING;
	}else{
		$date = DateTime::createFromFormat('d/m/Y g:i a',$booking_datetime);
		$booking_datetime = $date->format('Y-m-d H:i:s');
		if(!loader_session_isset('mobile_no')){
			 loader_set_session('confirm_booking_name',$name);
			 loader_set_session('confirm_booking_mobile_no',$mobile_no);
			 loader_set_session('confirm_booking_pickup_point',$pickup_point);
			 loader_set_session('confirm_booking_booking_datetime',$booking_datetime);
			 loader_set_session('confirm_booking_coupon_code',$coupon_code);
			 loader_set_session('confirm_booking_otp_session',rand(100000,999999));
			 $otp ="Your DriverLo OTP is ".loader_get_session('confirm_booking_otp_session');
			 loader_send_sms($otp,$mobile_no,"header");
			  $otp_status = 1; 
			 echo '<script>
				   $(document).ready(function(){
						   $("#ConfirmBookingModal").modal();
					   });
			   </script>';
		}else{
			if("" == $coupon_code){
				$coupon_code = "N.A.";
			}else if(IsCouponValid($coupon_code)){
				$success_message .= COUPON_VALID;
			}else{
				 $success_message .= COUPON_INVALID;
				 $coupon_code = "N.A.";
			}
			$bcn_no = 'BRN'.time();
			$message = "Booked Successfully.Congratulations !! Booking receipt note for tracking is ".$bcn_no."";
			$query1 = "INSERT INTO tbl_booking_detail (fld_customer_name,fld_mobile_no,fld_pickup_point,fld_booking_datetime,fld_coupon_code,fld_bcn_no) VALUES('".$name."','".$mobile_no."','".$pickup_point."','".$booking_datetime."','".$coupon_code."','".$bcn_no."')";
			if(loader_query($query1)){
				$success_message .= $message;
				$approval_status = "Approval Pending";
				$booking_datetime = date('d/m/Y g:i a', strtotime($booking_datetime));		
				$booking_confirm_message = 'Thank you for booking with us. Your booking receipt note is '.$bcn_no.'.We will get in touch with ur booking confirmation,shortly.';
				$new_booking_message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
				loader_send_sms($booking_confirm_message, $mobile_no,'booking_status');
				//loader_send_sms($new_booking_message,ADMIN_PERSONAL_MOBILE,'booking_status');
				$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
				$template_value_array = array('Booking Received',$name,NOREPLY_EMAIL, $booking_confirm_message);
				global $mailTemplate;
				$send = loader_send_mail($mailTemplate['booking_content'],$template_data_array,$template_value_array,loader_get_session('email'),NOREPLY_EMAIL,$mailTemplate['booking_subject']);
				$subject = 'New booking - '.$bcn_no;
				$customer_name = $name;
				$message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
				$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
				$template_value_array = array($subject,COMPANY_NAME,NOREPLY_EMAIL,$message);
				global $mailTemplate;
				$send = loader_send_mail($mailTemplate['contactus_content'],$template_data_array,$template_value_array,COMPANY_EMAIL,NOREPLY_EMAIL,$mailTemplate['contactus_subject']);
			}else{
				$error_message .= SERVER_ERROR;
			}
		}
	}
}else if(loader_post_isset('confirm_booking_otp')){
		$confirm_booking_otp_session = loader_get_session('confirm_booking_otp_session');
		$posted_otp = loader_get_post_escape('confirm_booking_otp');
	if($posted_otp  == $confirm_booking_otp_session)
	{		
			$name =  loader_get_session('confirm_booking_name');
			$mobile_no = loader_get_session('confirm_booking_mobile_no');
			$pickup_point = loader_get_session('confirm_booking_pickup_point');
			$booking_datetime = loader_get_session('confirm_booking_booking_datetime');
			$coupon_code = loader_get_session('confirm_booking_coupon_code');
			$query_mobile = "select mobile_no from view_customer_info where mobile_no = '".$mobile_no."' ";
			if($result_mobile = loader_query($query_mobile)){
			   if(loader_num_rows($result_mobile) == 0){
				  $password = rand(100000,999999);
				  $query_new_user = "insert into tbl_customer_info (fld_name, fld_mobile_no,fld_password) values('".$name."', '".$mobile_no."', '".$password."')";
				  if(loader_query($query_new_user)){
					  
					    if(customer_isTokenExist($user_token))
						{
							$query3 = "DELETE FROM tbl_customer_info WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
							if(loader_query($query3))
							{
								loader_file_put_content('includes/logs/extra_data','collided_and_removed','Customer id:'.$last_inserted_id.' Token:'.$user_token."\r\n");
								$error_message = REGISTRATION_FAILED;
							}
							else
							{
								loader_file_put_content('includes/logs/extra_data','collided_not_removed','Customer id:'.$last_inserted_id.' Token:'.$user_token."\r\n");
								$error_message = SERVER_ERROR;
							}
						}
						else
						{
							$query3 = "UPDATE tbl_customer_info SET fld_user_token = '".$user_token."' WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
							loader_file_put_content('query_data','get_customer_info',$query3);
							if(loader_query($query3))
							{
								$send_paasword = "DriverLo login password for mobile no ".$mobile_no." is ".$password;
								loader_send_sms($send_paasword,$mobile_no,'booking_status');
							}
							else
							{
								$error_message = SERVER_ERROR;
							}
						}
				   }else{
						$error_message .= SERVER_ERROR;
				   }
				}
			}else{
				$error_message .= SERVER_ERROR;
			}
			if(($error_message == "")){
					if("" == $coupon_code){
						$coupon_code = "N.A.";
					}else if(IsCouponValid($coupon_code)){
						$success_message .= COUPON_VALID;
					}else{
						 $success_message .= COUPON_INVALID;
						 $coupon_code = "N.A.";
					}
					$bcn_no = 'BRN'.time();
					$message = "Booked Successfully.Congratulations !! Booking receipt note for tracking is ".$bcn_no."";
					$query1 = "INSERT INTO tbl_booking_detail (fld_customer_name,fld_mobile_no,fld_pickup_point,fld_booking_datetime,fld_coupon_code,fld_bcn_no) VALUES('".$name."','".$mobile_no."','".$pickup_point."','".$booking_datetime."','".$coupon_code."','".$bcn_no."')";
					if(loader_query($query1)){
						$success_message .= $message;
						$approval_status = "Approval Pending";
						$booking_datetime = date('d/m/Y g:i a', strtotime($booking_datetime));		
						$booking_confirm_message = 'Thank you for booking with us. Your booking receipt note is '.$bcn_no.'. We will get in touch with you with booking confirmation, shortly.';
						$new_booking_message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
						loader_send_sms($booking_confirm_message, $mobile_no,'booking_status');
						//loader_send_sms($new_booking_message,ADMIN_PERSONAL_MOBILE,'booking_status');
						$subject = 'New booking - '.$bcn_no;
						$customer_name = $name;
						$message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
						$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
						$template_value_array = array($subject,COMPANY_NAME,NOREPLY_EMAIL,$message);
						global $mailTemplate;
						$send = loader_send_mail($mailTemplate['contactus_content'],$template_data_array,$template_value_array,COMPANY_EMAIL,NOREPLY_EMAIL,$mailTemplate['contactus_subject']);
						loader_set_session('confirm_booking_name',"");
						loader_set_session('confirm_booking_mobile_no',"");
						loader_set_session('confirm_booking_pickup_point',"");
						loader_set_session('confirm_booking_booking_datetime',"");
						loader_set_session('confirm_booking_coupon_code',"");
						loader_set_session('confirm_booking_otp_session',"");
					}else{
						$error_message .= SERVER_ERROR;
					}
			}else{
				$error_message .= SERVER_ERROR;
			}
  }else{
		 echo "<script>
				alert('".INCORRECT_OTP."');
			 </script>";
	}
}
else if(loader_session_isset('mobile_no')){
	$mobile_no = loader_get_session('mobile_no');
	$name = loader_get_session('name');
  	  $query = "select customer_name, mobile_no,bcn_no, pickup_point, booking_datetime, coupon_code, is_approved from view_booking_detail where mobile_no = '".$mobile_no."' order by created_on desc LIMIT 1";
	if($result = loader_query($query)){
		if(loader_num_rows($result)>0){
			$row = loader_fetch_assoc($result);
			$name = $row['customer_name'];
			$pickup_point = $row['pickup_point'];
			$bcn_no = $row['bcn_no'];
			$booking_datetime = date('d/m/Y g:i a', strtotime($row['booking_datetime']));
			$coupon_code =  $row['coupon_code'];
			if($row['is_approved'] == '1'){
			   $approval_status = "Approved";
			}else{
				$approval_status = "Approval Pending";
			}
		}else{
			$bcn_no = "N.A.";
			$pickup_point = "N.A.";
			$booking_datetime = "N.A.";
			$coupon_code = "N.A.";
			$approval_status = "N.A.";
		}
	}else{
	   $error_message = SERVER_ERROR;
	}
}
?>