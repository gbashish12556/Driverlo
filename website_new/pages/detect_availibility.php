<?php
if(loader_post_isset('current_lat')&&loader_post_isset('current_lng')){
	$current_lat = loader_get_post_escape('current_lat');
	$current_lng = loader_get_post_escape('current_lng');
	if(("" == $current_lat)||("" == $current_lng)){
		 loader_display(MANDATORY_MISSING);
	}else{
		$query1 ="SELECT DISTINCT city_lat,
			( 3959 * acos(cos(radians('".$current_lat."')) * cos( radians(city_lat))
			* cos( radians(city_lng) - radians('".$current_lng."')) + sin(radians('".$current_lat."'))
			* sin( radians(city_lat)))) AS distance
			FROM view_fare_chart
			WHERE is_active = '1'
			HAVING distance < ".SERVICEA_AREA." ";
			if($result = loader_query($query1)){
				if(loader_num_rows($result)  == 0){
					loader_display(NO_SERVICE_AREA);
				}
			}else{
				loader_display(SERVER_ERROR);
			}
	}
}

?>