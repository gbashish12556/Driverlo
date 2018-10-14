<?php
$pickup_point = $dropoff_point = $license_no = $franchise_id= $rating = $error_message = $success_message = $is_active = $id = "";
//
if(loader_post_isset('name')){

	$name = loader_get_post_escape('name');
	$license_no = loader_get_post_escape('license_no');
	$franchise_id= loader_get_post_escape('franchise_id');
	$rating =loader_get_post_escape('rating');
	$is_active =loader_get_post_escape('is_active');
	$id =loader_get_post_escape('id');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $license_no)||("" == $franchise_id)||("" == $rating)||("" == $id)||("" == $is_active)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsDriverLicenseRepeat($license_no, $id)){
				$error_message = EXIST_LICENSE;
			}else{
			   $query = "update tbl_driver_info set fld_name = '".$name."', fld_license_no = '".$license_no."', 
			             fld_franchise_id = '".$franchise_id."', fld_rating = '".$rating."', fld_is_active = '".$is_active."'
						 where fld_driver_ai_id = '".$id."'" ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
				 				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'driver'); ?>';
							   }, 2000); //
						</script>
				 <?php 
			   }else{
				$error_message = SERVER_ERROR.$query;
			   }
			}
		}
	}
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select name,license_no, franchise_id, rating, is_active from view_driver_info where driver_ai_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$name = $row['name'];
				$license_no = $row['license_no'];
				$franchise_id = $row['franchise_id'];
				$rating = $row['rating'];
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