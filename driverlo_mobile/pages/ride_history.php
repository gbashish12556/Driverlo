<?php
$error_message = $success_message= "";
loader_file_put_content('includes/logs/post_data','ride_history',$_REQUEST);
if(loader_post_isset('customer_token')){
	$userRow = array();
	$customer_token = loader_get_post_escape('customer_token');
	$page_no = loader_get_post_escape('page_no');
	if(("" == $page_no)||("" == $customer_token)){
	     $error_message = MANDATORY_MISSING;
	}else{
		if(validate_customer_token($customer_token))
		{
			$offset  = ($page_no*5);
			$query = "SELECT brn_no, pickup_point,dropoff_point,booking_datetime, journey_type, vehicle_type, vehicle_mode, 
			          is_approved, is_cancelled, is_completed FROM view_booking_detail WHERE customer_token = '".$customer_token."' LIMIT ".$offset.", 5 ";
			loader_file_put_content('includes/logs/query_data','ride_history',$query);		  
			if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$userRow['likes'] =array();
					$i = 0;
					while($row = loader_fetch_assoc($result)){
						$userRow['likes'][$i]['brn_no'] = $row ['brn_no']."";
						$userRow['likes'][$i]['pickup_point'] = $row ['pickup_point']."";
						$userRow['likes'][$i]['booking_datetime'] = $row ['booking_datetime']."";
						$userRow['likes'][$i]['journey_type'] = $row ['journey_type']."";
						$userRow['likes'][$i]['vehicle_type'] = $row ['vehicle_type']."";
						$userRow['likes'][$i]['vehicle_mode'] = $row ['vehicle_mode']."";
						$userRow['likes'][$i]['is_approved'] = $row ['is_approved']."";
						$userRow['likes'][$i]['is_cancelled'] = $row ['is_cancelled']."";
						$userRow['likes'][$i]['is_completed'] = $row ['is_completed']."";
						$i++;
					}
				}else{
					$error_message = NO_BOOKING;
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
	loader_file_put_content('includes/logs/send_data','ride_history',$send_data);
}
?>