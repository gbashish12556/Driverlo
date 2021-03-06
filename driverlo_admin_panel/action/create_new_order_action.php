<?php
$name = $mobile_no = $hour = $minute =  $pickup_point= $dropoff_point = $pickup_lat = $pickup_lng =  $journey_type = $vehicle_mode = $estimated_time = $vehicle_type = $booking_datetime = $hour = $minute = $user_token = $coupon_code = $error_message = $success_message =  "";
if(loader_post_isset('pickup_point')){
	$name = loader_get_post_escape('name');
	$mobile_no = loader_get_post_escape('mobile_no');
	$pickup_point = loader_get_post_escape('pickup_point');
	$pickup_lat = loader_get_post_escape('pickup_lat');
	$pickup_lng = loader_get_post_escape('pickup_lng');
	$dropoff_point= loader_get_post_escape('dropoff_point');
	$journey_type =loader_get_post_escape('journey_type');
	$vehicle_mode= loader_get_post_escape('vehicle_mode');
	$vehicle_type =loader_get_post_escape('vehicle_type');
	$estimated_usage= loader_get_post_escape('estimated_usage');
	$booking_datetime =loader_get_post_escape('booking_datetime');
	$coupon_code = strtoupper(loader_get_post_escape('coupon_code'));
	$date = DateTime::createFromFormat('d/m/Y g:i a',$booking_datetime);
	$booking_datetime = $date->format('Y-m-d H:i:s');
	$hour = loader_get_post_escape('hour');
	$minute = loader_get_post_escape('minute');
	$estimated_time = $hour." Hour ".$minute." Minute";
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $mobile_no)||("" == $pickup_point)||("" == $pickup_lat)||("" == $pickup_lng)||("" == $dropoff_point)||("" == $journey_type)||("" == $vehicle_mode)||("" == $vehicle_type)||("" == $estimated_time)||("" == $booking_datetime)){
			$error_message = MANDATORY_MISSING;
		}else{
			$query_mobile = "select user_token from view_customer_info where mobile_no = '".$mobile_no."' ";
			if($result_mobile = loader_query($query_mobile)){
			   if(loader_num_rows($result_mobile) == 0){
				  $password = rand(100000,999999);
				  $query_new_user = "insert into tbl_customer_info (fld_name, fld_mobile_no,fld_password, fld_total_point) values('".$name."', '".$mobile_no."', '".$password."', '200')";
				  if(loader_query($query_new_user)){
						$last_inserted_id = loader_last_inserted();
						$user_token = loader_hash($last_inserted_id);
						$words = preg_split("/[\s,_-]+/", $name);
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
							$query3 = "UPDATE tbl_customer_info SET fld_user_token = '".$user_token."' , fld_referal_code = '".$referal_code."' WHERE fld_customer_ai_id = '".$last_inserted_id."' ";
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
			   else{
			   		$row = loader_fetch_assoc($result_mobile);
					$user_token = $row['user_token'];
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
					$query1 = "INSERT INTO tbl_booking_detail (fld_customer_token, fld_customer_name, fld_mobile_no, fld_pickup_point, fld_dropoff_point, fld_journey_type, fld_vehicle_mode, fld_vehicle_type, fld_estimated_time,  fld_booking_datetime, fld_coupon_code, fld_brn_no) VALUES('".$user_token."', '".$name."','".$mobile_no."','".$pickup_point."' ,'".$dropoff_point."' ,'".$journey_type."' ,'".$vehicle_mode."' ,'".$vehicle_type."' ,'".$estimated_time."'  ,'".$booking_datetime."','".$coupon_code."','".$bcn_no."')";
					if(loader_query($query1)){
						$success_message .= $message;
						$approval_status = "Approval Pending";
						$booking_datetime = date('d/m/Y g:i a', strtotime($booking_datetime));		
						$booking_confirm_message = 'Thank you for booking with us. Your booking receipt note is '.$bcn_no.'. We will get in touch with you with booking confirmation, shortly.';
						$new_booking_message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
						//loader_send_sms($booking_confirm_message, $mobile_no,'booking_status');
						//loader_send_sms($new_booking_message,ADMIN_PERSONAL_MOBILE,'booking_status');
						$subject = 'New booking - '.$bcn_no;
						$customer_name = $name;
						$message = 'New Booking - BRN:'.$bcn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
						$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
						$template_value_array = array($subject,COMPANY_NAME,NOREPLY_EMAIL,$message);
						global $mailTemplate;
						$send = loader_send_mail($mailTemplate['contactus_content'],$template_data_array,$template_value_array,COMPANY_EMAIL,NOREPLY_EMAIL,$mailTemplate['contactus_subject']);
						?>
							<script type="text/javascript">
							setTimeout(function () {
								 window.location='<?php loader_display(ROOT_PATH.'new_order'); ?>';
									}, 2000); //
							</script>
						<?php 
					}else{
						$error_message .= SERVER_ERROR;
					}
			}else{
				$error_message .= SERVER_ERROR;
			}

		}
	}
}
?>