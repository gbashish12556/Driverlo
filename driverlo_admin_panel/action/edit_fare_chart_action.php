<?php
$city_name= $city_lat= $city_lng = $base_fare = $fare = $outstation_base_fare = $outstation_fare = $night_charge = $return_charge = $is_active =  $error_message = $success_message = "";
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
	$id = loader_get_post_escape('id');
	$is_active = loader_get_post_escape('is_active');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $city_name)||("" == $city_lat)||("" == $city_lng)||("" == $base_fare)||("" == $fare)||("" == $outstation_base_fare)||("" == $outstation_fare)||("" == $night_charge)||("" == $return_charge)||("" == $is_active)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsCityRepeat($city_name, $id)){
				$error_message = EXIST_CITY;
			}else{
			   $query = "update tbl_fare_chart set fld_city_name = '".$city_name."', fld_city_lat = '".$city_lat."', 
			             fld_city_lng = '".$city_lng."', fld_base_fare = '".$base_fare."', fld_fare = '".$fare."'
						 , fld_base_fare = '".$base_fare."', fld_base_fare = '".$base_fare."', fld_base_fare = '".$base_fare."'
						 , fld_outstation_base_fare = '".$outstation_base_fare."', fld_outstation_fare = '".$outstation_fare."'
						 , fld_night_charge = '".$night_charge."', fld_return_charge = '".$return_charge."'
						 , fld_is_active = '".$is_active."'
						 where fld_city_id = '".$id."'" ;
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
				$error_message = SERVER_ERROR;
			   }
			}
		}
	}
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select city_name, city_lat, city_lng, base_fare, fare, outstation_base_fare, outstation_fare, night_charge, return_charge, is_active from view_fare_chart where city_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$city_name = $row['city_name'];
				$city_lat = $row['city_lat'];
				$city_lng = $row['city_lng'];
				$base_fare = $row['base_fare'];
				$fare = $row['fare'];
				$outstation_base_fare = $row['outstation_base_fare'];
				$outstation_fare = $row['outstation_fare'];
				$night_charge = $row['night_charge'];
				$return_charge = $row['return_charge'];
				$is_active = $row['is_active'];
			}else{
				$error_message = NO_MATCH_FOUND;
			}
		}else{
			$error_message = SERVER_ERROR;
		}
	}
}
?>