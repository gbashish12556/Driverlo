<?php
$brn_no = $pickup_point = $dropoff_point = $name = $mobile_no = $franchise_name = $driver_name = $location= $rating = $error_message = $success_message = $journey_time  = $total_duration =  $is_active = $id = $journey_type = $total_fare = $total_time =  $franchise_mobile_no = $customer_rating = $driver_feedback = "";
//
if(loader_post_isset('total_fare')){
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	$mobile_no   = loader_get_post_escape('mobile_no');
	$franchise_mobile_no = loader_get_post_escape('franchise_mobile_no');
	$driver_name = loader_get_post_escape('driver_name');
	$brn_no = loader_get_post_escape('brn_no');
	$journey_time = loader_get_post_escape('journey_time');
	$journey_type = loader_get_post_escape('journey_type');
	$total_time = loader_get_post_escape('total_time');
	$total_fare = loader_get_post_escape('total_fare');
		$customer_rating = loader_get_post_escape('customer_rating');
	$driver_feedback = loader_get_post_escape('driver_feedback');
	$id   = loader_get_post_escape('id');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $mobile_no)||("" == $franchise_mobile_no)||("" == $id)||("" == $total_fare)||("" == $brn_no)){
			$error_message = MANDATORY_MISSING;
		}else{
			$query = "update tbl_booking_detail set fld_total_fare = '".$total_fare."', fld_total_time = '".$total_time."',
			          fld_journey_time = '".$journey_time."', fld_journey_type = '".$journey_type."',
					  fld_customer_rating = '".$customer_rating."', fld_driver_feedback = '".$driver_feedback."',
					   fld_is_completed = '1' where fld_booking_ai_id = '".$id."' ";
			if(loader_query($query)){
				$success_message = IS_SUCCESS;
				loader_set_session('form_session','processed');
				$franchise_message = "Bill Generated for ".$brn_no." total bill paid to the driver ".$driver_name." Rs.".$total_fare." ";
				$customer_message = "Thank you for chosing us.Your bill amount ".$total_fare;
				//loader_send_sms($franchise_message, $franchise_mobile_no, "confirm_bill");
				//loader_send_sms($customer_message, $mobile_no, "confirm_bill");
				
				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'completed_order'); ?>';
							    }, 2000); //
						</script>
				 <?php 
			}else{
				$error_message = SERVER_ERROR;
			}
		
		}
	}
}elseif(loader_post_isset('franchise_name')){

	$pickup_point = loader_get_post_escape('pickup_point');
	$dropoff_point   = loader_get_post_escape('dropoff_point');
	$name = loader_get_post_escape('name');
	$mobile_no   = loader_get_post_escape('mobile_no');
	$franchise_name = loader_get_post_escape('franchise_name');
	$franchise_mobile_no = loader_get_post_escape('franchise_mobile_no');
	$driver_name   = loader_get_post_escape('driver_name');
	$journey_type   = loader_get_post_escape('journey_type');
	$customer_rating = loader_get_post_escape('customer_rating');
	$driver_feedback = loader_get_post_escape('driver_feedback');
	$city   = loader_get_post_escape('city');
	$brn_no   = loader_get_post_escape('brn_no');
	$id   = loader_get_post_escape('id');
	//echo 'session'.$session;
	if(("" == $mobile_no)||("" == $franchise_mobile_no)||("" == $id)||("" == $journey_type)||("" == $city)||("" == $customer_rating)||("" == $driver_feedback)){
		$error_message = MANDATORY_MISSING;
	}else{
					
		if("outstation" == $journey_type){
			$total_day = loader_get_post_escape('total_day');
			$total_hour = loader_get_post_escape('total_hour');
			$journey_time = "Day Time";
			$total_time = $total_day." Day ".$total_hour." Hour ";
			$query = "select outstation_base_fare, outstation_fare from view_fare_chart where city_id = '".$city."' " ;
			if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$row = loader_fetch_assoc($result);
					$outstation_base_fare = $row['outstation_base_fare'];
					$outstation_fare = $row['outstation_fare'];
					if($total_day>0)
					{
						if(("" != $total_hour)){
							$total_fare = $outstation_base_fare + ($total_day-1)*2*$outstation_fare + $outstation_fare;
						}else{
							$total_fare = $outstation_base_fare + ($total_day-1)*2*$outstation_fare;
						}
					}else{
						$total_fare = $outstation_base_fare ;
					}
				}
			}else{
				$error_message = SERVER_ERROR;
			}
		}else{
			
			$booking_start_datetime = loader_get_post_escape('booking_start_datetime');
			$date = DateTime::createFromFormat('d/m/Y h:i a',$booking_start_datetime);
			$booking_start_datetime = $date->format('Y-m-d H:i:s');
			
			$booking_end_datetime   = loader_get_post_escape('booking_end_datetime');
			$date = DateTime::createFromFormat('d/m/Y h:i a',$booking_end_datetime);
			$booking_end_datetime = $date->format('Y-m-d H:i:s');
						
			$datetime1 = strtotime($booking_start_datetime);
			$datetime2 = strtotime($booking_end_datetime);
			//$total_duration  = $datetime1.'//'.$datetime2;
			$interval  = abs($datetime2 - $datetime1);
			//$total_duration  = $interval;
			$minutes   = round($interval / 60);
			$hour = (int)($minutes/60);
			$minutes   = ($minutes%60);
			$total_time = $hour." Hour ".$minutes." Minute ";
			
			$booking_start_time = date("h:i a",$datetime1);
			$booking_end_time = date("h:i a",$datetime2);
		
			$late_night = "11:00 pm";
			$early_morning = "07:00 am";
			
			$booking_start_time = DateTime::createFromFormat('h:i a', $booking_start_time);
			$booking_end_time = DateTime::createFromFormat('h:i a', $booking_end_time);
			
			$late_night = DateTime::createFromFormat('h:i a', $late_night);
			$early_morning = DateTime::createFromFormat('h:i a', $early_morning);

			$query = "select base_fare,fare, return_charge, night_charge from view_fare_chart where city_id = '".$city."'" ;
			if($result = loader_query($query)){
				if(loader_num_rows($result)>0){
					$row = loader_fetch_assoc($result);
					$base_fare = $row['base_fare'];
					$fare = $row['fare'];
					$return_charge = $row['return_charge'];
					$night_charge = $row['night_charge'];
				
					if("roundtrip" == $journey_type){
						if($hour>0){
							$total_fare = $base_fare+($hour-1)*60*$fare+$minutes*$fare;
						}else{
							$total_fare = $minutes*$fare;
						}
					}else{
						if($hour>0){
							$total_fare = $base_fare+($hour-1)*60*$fare+$minutes*$fare+$return_charge ;
						}else{
							$total_fare =  $base_fare+$return_charge ;
						}
					}
					if (($booking_start_time >= $late_night)||($booking_start_time <= $early_morning)||($booking_end_time >= $late_night)||($booking_end_time <= $early_morning))
					{
					   $journey_time = "Night Time";
					   $total_fare = $total_fare + $night_charge;
					}else{
					   $journey_time = "Day Time";
					}	
				}

			}else{
				$error_message = SERVER_ERROR;
			}

		}
	}
}
?>