<?php
$name = $mobile_no = $location= $rating = $error_message = $success_message = $is_active = $id = "";
//
if(loader_post_isset('name')){

	$name = loader_get_post_escape('name');
	$mobile_no = loader_get_post_escape('mobile_no');
	$location= loader_get_post_escape('location');
	$rating =loader_get_post_escape('rating');
	$is_active =loader_get_post_escape('is_active');
	$id =loader_get_post_escape('id');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $mobile_no)||("" == $location)||("" == $rating)||("" == $id)||("" == $is_active)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsFranchiseMobileRepeat($mobile_no, $id)){
				$error_message = MOBILE_EXIST;
			}else{
			   $query = "update tbl_franchise_info set fld_name = '".$name."', fld_mobile_no = '".$mobile_no."', 
			             fld_location = '".$location."', fld_rating = '".$rating."', fld_is_active = '".$is_active."'
						 where fld_franchise_ai_id = '".$id."'" ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
				 				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'franchise'); ?>';
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
		$query = "select name,mobile_no, location, rating, is_active from view_franchise_info where franchise_ai_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$name = $row['name'];
				$mobile_no = $row['mobile_no'];
				$location = $row['location'];
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