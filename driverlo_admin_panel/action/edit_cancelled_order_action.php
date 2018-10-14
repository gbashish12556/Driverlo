<?php
$is_cancelled =  $is_active = $id = "";
//
if(loader_post_isset('is_cancelled')){

	$is_cancelled =  loader_get_post_escape('is_cancelled');
	$id =            loader_get_post_escape('id');
	$session =       loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $is_cancelled)||("" == $id)){
			$error_message = MANDATORY_MISSING;
		}else{
			
			   $query = "update tbl_booking_detail set fld_is_cancelled = '".$is_cancelled."'
						 where fld_booking_ai_id = '".$id."'" ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
				 				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'cancelled_order'); ?>';
							   }, 2000); //
						</script>
				 <?php 
			   }else{
				$error_message = SERVER_ERROR;
			   }
			
		}
	}
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select is_cancelled, booking_ai_id 
				  from view_booking_detail where booking_ai_id = '".$id."' ";
		
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$is_cancelled = $row['is_cancelled'];
				$id = $row['booking_ai_id'];
			}else{
				$error_message = NO_MATCH_FOUND;
			}
		}else{
			$error_message = SERVER_ERROR.$query;
		}
	}
}
?>