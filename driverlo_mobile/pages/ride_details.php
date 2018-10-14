<?php
$error_message = $success_message = "";
loader_file_put_content('includes/logs/post_data','ride_details',$_REQUEST);
if(loader_post_isset('brn_no')){
	$brn_no = loader_get_post_escape('brn_no');
	$customer_token = loader_get_post_escape('customer_token');
	$userRow = array();
	if(("" == $brn_no)||("" == $customer_token)){
	     $error_message = MANDATORY_MISSING;
	}else{
		if(validate_customer_token($customer_token)){
			$query = "SELECT brn_no, pickup_point,dropoff_point, booking_datetime, driver_rating, estimated_time,vehicle_type, 
			          vehicle_mode,driver_name, driver_license_no, coupon_code,  is_cancelled, is_approved, is_completed 
					  FROM view_booking_detail WHERE brn_no ='".$brn_no."' ";
			loader_file_put_content('includes/logs/query_data','ride_details',$query);
			if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$userRow['likes'] = array();
					$row = loader_fetch_assoc($result);
					$userRow['likes'][0]['brn_no'] = $row['brn_no']."";
					$userRow['likes'][0]['pickup_point'] = $row['pickup_point']."";
					$userRow['likes'][0]['dropoff_point'] = $row['dropoff_point']."";
					$userRow['likes'][0]['booking_datetime'] = $row['booking_datetime']."";
					$userRow['likes'][0]['estimated_time'] = $row['estimated_time']."";
					$userRow['likes'][0]['vehicle_type'] = $row['vehicle_type']."";
					$userRow['likes'][0]['vehicle_mode'] = $row['vehicle_mode']."";
					$userRow['likes'][0]['coupon_code'] = $row['coupon_code']."";
					$userRow['likes'][0]['driver_rating'] = $row['driver_rating']."";
					
					$userRow['likes'][0]['driver_name'] = $row['driver_name']."";
					$userRow['likes'][0]['driver_license_no'] = $row['driver_license_no']."";
					
					$userRow['likes'][0]['is_cancelled'] = $row['is_cancelled']."";
					$userRow['likes'][0]['is_approved'] = $row['is_approved']."";
					$userRow['likes'][0]['is_completed'] = $row['is_completed']."";
				}
			}else{
				$error_message = SERVER_ERROR;
			}
		}else{
			$error_message = CUSTOMER_TOKEN_INVALID;
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
	loader_file_put_content('includes/logs/send_data','ride_details',$send_data);
}
?>