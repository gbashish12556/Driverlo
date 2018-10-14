<?php
$name = $license_no = $franchise_id= $rating = $error_message = $success_message = "";
//
if(loader_post_isset('name')){

	$name = loader_get_post_escape('name');
	$license_no = loader_get_post_escape('license_no');
	$franchise_id= loader_get_post_escape('franchise_id');
	$rating =loader_get_post_escape('rating');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $license_no)||("" == $franchise_id)||("" == $rating)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsDriverLicenseExist($license_no)){
				$error_message = EXIST_LICENSE;
			}else{
			   $query = "insert into tbl_driver_info (fld_name, fld_license_no, fld_franchise_id, fld_rating) values('".$name."', '".$license_no."', '".$franchise_id."', '".$rating."') " ;
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
				$error_message = SERVER_ERROR;
			   }
			}
		}
	}
}
?>