<?php
$error_message = $success_message = "";
loader_file_put_content('includes/logs/post_data','city_available',$_REQUEST);
if(loader_post_isset('current_lat')&&loader_post_isset('current_lng')){
	$current_lat = loader_get_post_escape('current_lat');
	$current_lng = loader_get_post_escape('current_lng');
	if(("" == $current_lat)||("" == $current_lng)){
		 $error_message  = MANDATORY_MISSING;
	}else{
		$query1 ="SELECT DISTINCT city_id,
			( 3959 * acos(cos(radians('".$current_lat."')) * cos( radians(city_lat))
			* cos( radians(city_lng) - radians('".$current_lng."')) + sin(radians('".$current_lat."'))
			* sin( radians(city_lat)))) AS distance
			FROM view_city
			WHERE is_active = '1'
			HAVING distance < ".SERVICEA_AREA." 
			ORDER BY distance ASC LIMIT 0,1 ";
			loader_file_put_content('includes/logs/query_data','city_available',$query1);
			if($result = loader_query($query1)){
				if(loader_num_rows($result) > 0){
					$userRow["likes"] = array();
					$row = loader_fetch_assoc($result);
					$userRow["likes"][0]["city_id"] = $row["city_id"];
					$success_message = UPDATE_SUCCESS;
				}else{
					$error_message = NO_SERVICE_AREA;
				}
			}else{
				$error_message = SERVER_ERROR;
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
	loader_file_put_content('includes/logs/send_data','city_available',$send_data);
}

?>