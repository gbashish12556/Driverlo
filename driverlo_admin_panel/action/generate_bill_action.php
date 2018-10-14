<?php
$brn_no = $total_day = $session = $driver_name = $booked_driver_id = $name = $franchise_name = $mobile_no = $hour = $minute =  $pickup_point= $dropoff_point = $pickup_lat = $pickup_lng =  $journey_type = $vehicle_mode = $estimated_time = $vehicle_type = $booking_start_datetime =$booking_end_datetime = $hour = $minute = $user_token = $coupon_code = $franchise_mobile_no = $franchise_name =  $error_message = $success_message =  $is_active = $id = $customer_rating = $driver_feedback = "";
//
if(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select brn_no, customer_name, mobile_no, pickup_point, dropoff_point, journey_type, 
		          vehicle_mode, vehicle_type, estimated_time,  booking_datetime, driver_name ,franchise_name,franchise_mobile_no, is_active, booking_ai_id 
				  from view_booking_detail where booking_ai_id = '".$id."' ";
		
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$brn_no = $row['brn_no'];
				$name = $row['customer_name'];
				$mobile_no = $row['mobile_no'];
				$pickup_point = $row['pickup_point'];
				$dropoff_point = $row['dropoff_point'];
				$journey_type = $row['journey_type'];
				$vehicle_mode = $row['vehicle_mode'];
				$vehicle_type = $row['vehicle_type'];
				$estimated_time = $row['estimated_time'];
				$booking_datetime = $row['booking_datetime'];
				$driver_name = $row['driver_name'];
				$franchise_name = $row['franchise_name'];
				$franchise_mobile_no = $row['franchise_mobile_no'];
				$booking_datetime = date('d/m/Y h:i a', strtotime($booking_datetime));		
				$id = $row['booking_ai_id'];
				$is_active = $row['is_active'];
			}else{
				$error_message = NO_MATCH_FOUND;
			}
		}else{
			$error_message = SERVER_ERROR.$query;
		}
	}
}
?>