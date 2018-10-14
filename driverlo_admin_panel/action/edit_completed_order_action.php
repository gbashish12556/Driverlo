<?php
$brn_no = $pickup_point = $dropoff_point = $name = $mobile_no = $franchise_name = $driver_name = $location= $rating = $error_message = $success_message = $journey_time  = $total_duration =  $is_active = $id = $journey_type = $total_fare = $total_time =  $franchise_mobile_no =  $customer_rating = $driver_feedback ="";
//
if(loader_post_isset('journey_time')){

	$name =          loader_get_post_escape('name');
	$mobile_no =     loader_get_post_escape('mobile_no');
	$pickup_point =  loader_get_post_escape('pickup_point');
	$dropoff_point = loader_get_post_escape('dropoff_point');
	$journey_type =  loader_get_post_escape('journey_type');
	$journey_time =  loader_get_post_escape('journey_time');
	$total_time = loader_get_post_escape('total_time');
	$total_fare = loader_get_post_escape('total_fare');
	$driver_feedback = $row['driver_feedback'];
	$customer_rating = $row['customer_rating'];
	$mobile_no   = loader_get_post_escape('mobile_no');
	$franchise_mobile_no = loader_get_post_escape('franchise_mobile_no');
	$driver_name = loader_get_post_escape('driver_name');
	$brn_no = loader_get_post_escape('brn_no');
	$booking_datetime = loader_get_post_escape('booking_datetime');
	
	$id =        loader_get_post_escape('id');
	$session =   loader_get_post_escape('session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $mobile_no)||("" == $franchise_mobile_no)||("" == $id)||("" == $total_fare)||("" == $brn_no)){
			$error_message = MANDATORY_MISSING;
		}else{
			$query = "update tbl_booking_detail set fld_total_fare = '".$total_fare."', fld_total_time = '".$total_time."',
			          fld_journey_time = '".$journey_time."', fld_journey_type = '".$journey_type."', 
					  fld_driver_feedback = '".$driver_feedback."', fld_customer_rating = '".$customer_rating."', 
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
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select customer_name, mobile_no, pickup_point, dropoff_point,
		          journey_type,journey_time, total_time, total_fare, 
		          franchise_name, franchise_mobile_no, driver_name,booking_ai_id , brn_no, driver_feedback, customer_rating
				  from view_booking_detail where booking_ai_id = '".$id."' ";
		
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
			
				$row = loader_fetch_assoc($result);
				$name = $row['customer_name'];
				$mobile_no = $row['mobile_no'];
				$pickup_point = $row['pickup_point'];
				$dropoff_point = $row['dropoff_point'];
				
				$journey_type = $row['journey_type'];
				$journey_time = $row['journey_time'];
				$total_time = $row['total_time'];
				$total_fare = $row['total_fare'];
								$driver_feedback = $row['driver_feedback'];
				$customer_rating = $row['customer_rating'];

				$brn_no = $row['brn_no'];
				$franchise_name = $row['franchise_name'];
				$franchise_mobile_no = $row['franchise_mobile_no'];
				$driver_name = $row['driver_name'];
				$id = $row['booking_ai_id'];

			}else{
				$error_message = NO_MATCH_FOUND;
			}
		}else{
			$error_message = SERVER_ERROR.$query;
		}
	}
}
?>