<?php
$id = $city_name= $city_lat= $city_lng = $base_fare = $fare = $outstation_base_fare = $outstation_fare = $night_charge = $return_charge = $is_active =  $error_message = $success_message = "";

if(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select city_name, base_fare, fare, outstation_base_fare, outstation_fare, night_charge, return_charge, is_active from view_fare_chart where city_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$city_name = $row['city_name'];
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
}elseif(loader_post_isset('id')){
	$id = loader_get_post_escape('id');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if("" == $id){
		  $error_message = MANDATORY_MISSING;
		}else{
			$query = "delete from tbl_fare_chart where fld_city_id = '".$id."' ";
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
?>