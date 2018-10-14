<?php

$name = $mobile_no = $pickup_point = $booking_datetime = $coupon_code =  $error_message = $success_messaqge = "";
$pickup_lat = 22.6;
$pickup_lng = 88.22;
if(loader_post_isset('pickup_point')){

	 $pickup_point = loader_get_post_escape('pickup_point');
	 $booking_datetime = loader_get_post_escape('booking_datetime');
	 $pickup_lat = loader_get_post_escape('pickup_lat');
	 $pickup_lng = loader_get_post_escape('pickup_lng');
}
if(loader_session_isset('mobile_no')&&loader_session_isset('name')){
		 $name = loader_get_session('name');
	 $mobile_no = loader_get_session('mobile_no');	
}
?>