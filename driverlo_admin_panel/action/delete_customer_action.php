<?php
$name = $mobile_no = $email= $password = $error_message = $success_message = $is_active = $id = "";
if(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select name,mobile_no, email, password, is_active from view_customer_info where customer_ai_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$name = $row['name'];
				$mobile_no = $row['mobile_no'];
				$email = $row['email'];
				$password = $row['password'];
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
			$query = "delete from tbl_customer_info where fld_customer_ai_id = '".$id."' ";
		   if(loader_query($query)){
			 $success_message = IS_SUCCESS;
			 loader_set_session('form_session','processed');
							?>
					<script type="text/javascript">
					setTimeout(function () {
						 window.location='<?php loader_display(ROOT_PATH.'customer'); ?>';
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