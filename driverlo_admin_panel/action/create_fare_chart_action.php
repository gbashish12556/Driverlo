<?php
$city_name= $city_lat= $city_lng = $base_fare = $fare = $outstation_base_fare = $outstation_fare = $night_charge = $return_charge = $error_message = $success_message = "";
//
if(loader_post_isset('city_name')){

	$city_name = loader_get_post_escape('city_name');
	$arr = explode(",", $city_name, 2);
	$city_name = $arr[0];
	$city_lat = loader_get_post_escape('city_lat');
	$city_lng = loader_get_post_escape('city_lng');
	$base_fare= loader_get_post_escape('base_fare');
	$fare =loader_get_post_escape('fare');
	$outstation_base_fare= loader_get_post_escape('outstation_base_fare');
	$outstation_fare =loader_get_post_escape('outstation_fare');
	$night_charge= loader_get_post_escape('night_charge');
	$return_charge =loader_get_post_escape('return_charge');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $city_name)||("" == $city_lat)||("" == $city_lng)||("" == $base_fare)||("" == $fare)||("" == $outstation_base_fare)||("" == $outstation_fare)||("" == $night_charge)||("" == $return_charge)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsCityExist($city_name)){
				$error_message = EXIST_CITY;
			}else{
			   $query = "insert into tbl_fare_chart (fld_city_name, fld_city_lat, fld_city_lng, fld_base_fare,
			             fld_fare, fld_outstation_base_fare, fld_outstation_fare, fld_night_charge, fld_return_charge) 
						 values('".$city_name."', '".$city_lat."', '".$city_lng."', '".$base_fare."',
						      '".$fare."', '".$outstation_base_fare."', '".$outstation_fare."', '".$night_charge."', '".$return_charge."') " ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'fare_chart'); ?>';
							    }, 2000); //
						</script>
				 <?php 
			   }else{
				$error_message = SERVER_ERROR.$query;
			   }
			}
		}
	}
}
?>