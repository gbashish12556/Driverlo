<?php
$franchise_id = $driver = $name = $mobile_no = $hour = $minute =  $pickup_point= $dropoff_point = $pickup_lat = $pickup_lng =  $journey_type = $vehicle_mode = $estimated_time = $vehicle_type = $booking_datetime = $hour = $minute = $user_token = $coupon_code = $error_message = $success_message =  "";
if(loader_post_isset('driver')){
	$driver = loader_get_post_escape('driver');
	$is_active =loader_get_post_escape('is_active');
	$id =loader_get_post_escape('id');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $driver)){
			$error_message = MANDATORY_MISSING;
		}else{
			   $query = "update tbl_booking_detail set fld_is_approved = '1', fld_booked_driver_id = '".$driver."'
						 where fld_booking_ai_id = '".$id."'" ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
								?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'running_order'); ?>';
							   }, 2000); //
						</script>
				 <?php 
			   }else{
				$error_message = SERVER_ERROR.$query;
			   }
		}
	}
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select customer_name, mobile_no, pickup_point, dropoff_point, journey_type, 
		          vehicle_mode, vehicle_type, estimated_time,  booking_datetime, is_active, booking_ai_id 
				  from view_booking_detail where booking_ai_id = '".$id."' ";
		
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$name = $row['customer_name'];
				$mobile_no = $row['mobile_no'];
				$pickup_point = $row['pickup_point'];
				$dropoff_point = $row['dropoff_point'];
				$journey_type = $row['journey_type'];
				$vehicle_mode = $row['vehicle_mode'];
				$vehicle_type = $row['vehicle_type'];
				$estimated_time = $row['estimated_time'];
				$booking_datetime = $row['booking_datetime'];
				$booking_datetime = date('d/m/Y h:i a', strtotime($booking_datetime));		
				$id = $row['booking_ai_id'];
			}else{
				$error_message = NO_MATCH_FOUND;
			}
		}else{
			$error_message = SERVER_ERROR;
		}
	}
}
?>