<?php
$name = $mobile_no = $location= $rating = $error_message = $success_message = "";
//
if(loader_post_isset('name')){

	$name = loader_get_post_escape('name');
	$mobile_no = loader_get_post_escape('mobile_no');
	$location= loader_get_post_escape('location');
	$rating =loader_get_post_escape('rating');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $mobile_no)||("" == $location)||("" == $rating)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsFranchiseMobileExist($mobile_no)){
				$error_message = MOBILE_EXIST;
			}else{
			   $query = "insert into tbl_franchise_info (fld_name, fld_mobile_no, fld_location, fld_rating) values('".$name."', '".$mobile_no."', '".$location."', '".$rating."') " ;
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
				$error_message = SERVER_ERROR;
			   }
			}
		}
	}
}
?>