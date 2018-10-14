<?php
$error_message = $success_message= "";
loader_file_put_content('includes/logs/post_data','confirm_booking',$_REQUEST);
if(loader_post_isset('pickup_point')){
	$userRow = array();
	$customer_token = loader_get_post_escape('customer_token');
	//$name = loader_get_post_escape('name');
	//$mobile_no = loader_get_post_escape('mobile_no');
	$pickup_point = loader_get_post_escape('pickup_point');
	$dropoff_point = loader_get_post_escape('dropoff_point');
	$booking_datetime = loader_get_post_escape('booking_datetime');
	$journey_type = loader_get_post_escape('journey_type');
	$vehicle_type = loader_get_post_escape('vehicle_type');
	$vehicle_mode = loader_get_post_escape('vehicle_mode');
	$estimated_fare = loader_get_post_escape('estimated_fare');
	$estimated_time = loader_get_post_escape('estimated_time');
	$coupon_code = loader_get_post_escape('coupon_code');
	if(("" == $customer_token)||("" == $pickup_point)||("" == $booking_datetime)||("" == $journey_type)||("" == $vehicle_type)||("" == $vehicle_mode)||("" == $estimated_fare)||("" == $estimated_time)){
	     $error_message = MANDATORY_MISSING;
	}else{
		if(is_numeric($estimated_fare)){
			if(validate_vehicle_mode($vehicle_mode))
			{
				if(validate_vehicle_type($vehicle_type))
				{
					if(validate_journey_type($journey_type))
					{
						if(validate_booking_datetime($booking_datetime))
						{
							if(validate_customer_token($customer_token))
							{
							    $row = get_customer_info($customer_token);
								$name = $row['name'];
								$mobile_no = $row['mobile_no'];
								$email = $row['email'];
								$name = $row['name'];
								if("" == $coupon_code){
									$coupon_code = "N.A.";
								}else if(IsCouponValid($coupon_code)){
									$success_message .= COUPON_VALID;
								}else{
									 $success_message .= COUPON_INVALID;
									 $coupon_code = "N.A.";
								}
								$brn_no = 'BRN'.time();
								$message = "Booked Successfully.Congratulations !! Booking receipt note for tracking is ".$brn_no."";
								$query1 = "INSERT INTO tbl_booking_detail(fld_customer_token, fld_customer_name, fld_mobile_no, fld_pickup_point, fld_dropoff_point,
										   fld_booking_datetime, fld_journey_type, fld_vehicle_type, fld_vehicle_mode, fld_estimated_fare, fld_estimated_time, fld_coupon_code, fld_brn_no)
										   VALUES('".$customer_token."','".$name."','".$mobile_no."','".$pickup_point."','".$dropoff_point."','".$booking_datetime."'
										   ,'".$journey_type."','".$vehicle_type."','".$vehicle_mode."','".$estimated_fare."','".$estimated_time."','".$coupon_code."','".$brn_no."')";
								loader_file_put_content('includes/logs/query_data','confirm_booking',$query1);
								if(loader_query($query1)){
									$userRow['likes'] = array();
									$userRow['likes'][0]['brn_no'] = $brn_no;
									$success_message .= $message;
									$approval_status = "Approval Pending";
									$booking_datetime = date('d/m/Y g:i a', strtotime($booking_datetime));		
									$booking_confirm_message = 'Thank you for booking with us. Your booking receipt note is '.$brn_no.'.We will get in touch with ur booking confirmation,shortly.';
									$new_booking_message = 'New Booking - BRN:'.$brn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
								    loader_send_sms($booking_confirm_message, $mobile_no,'booking_status');
									//loader_send_sms($new_booking_message,ADMIN_PERSONAL_MOBILE,'booking_status');
													//loader_send_sms($new_booking_message,ADMIN_PERSONAL_MOBILE,'booking_status');
									$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
									$template_value_array = array('Booking Received',$name,NOREPLY_EMAIL, $booking_confirm_message);
									global $mailTemplate;
									$send = loader_send_mail($mailTemplate['booking_content'],$template_data_array,$template_value_array,$email,NOREPLY_EMAIL,$mailTemplate['booking_subject']);
									$subject = 'New booking - '.$brn_no;
									$customer_name = $name;
									$message = 'New Booking - BRN:'.$brn_no.', Pickup Point: '.$pickup_point.', Mobile No: '.$mobile_no.', Customer Name: '.$name.', Booking Datetime: '.$booking_datetime;
									$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
									$template_value_array = array($subject,COMPANY_NAME,NOREPLY_EMAIL,$message);
									global $mailTemplate;
									$send =loader_send_mail($mailTemplate['contactus_content'],$template_data_array,$template_value_array,COMPANY_EMAIL,NOREPLY_EMAIL,$mailTemplate['contactus_subject']);
								}else{
									$error_message .= SERVER_ERROR;
								}
							}else{
								$error_message = CUSTOMER_TOKEN_INVALID;
							}
						}else{
							$error_message= DATETIME_INVALID;
						}
					}else{
						$error_message = INVALID_JOURNEY_TYPE;
					}
				}else{
					$error_message = INVALID_VEHICLE_TYPE;
				}
			}else{
				$error_message = INVALID_VEHICLE_MODE;
			}
		}else{
			$error_message = INVALID_FARE;
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
	loader_file_put_content('includes/logs/send_data','confirm_booking',$send_data);
}
?>