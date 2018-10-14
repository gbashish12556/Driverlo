<?php
$name = $mobile_no = $location= $rating = $error_message = $success_message = $is_active = $id = $rating =  "";
//
if(loader_post_isset('name')){

	$name = loader_get_post_escape('name');
	$mobile_no = loader_get_post_escape('mobile_no');
	$email= loader_get_post_escape('email');
	$password =loader_get_post_escape('password');
	$is_active =loader_get_post_escape('is_active');
	$id =loader_get_post_escape('id');
	$rating=loader_get_post_escape('rating');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $name)||("" == $email)||("" == $password)||("" == $id)||("" == $is_active)||("" == $rating)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsCustomerMobileRepeat($mobile_no, $id)){
				$error_message = MOBILE_EXIST;
			}else{
				if(IsCustomerEmailRepeat($email, $id)){
					$error_message = EMAIL_EXIST;
				}else{
				   $query = "update tbl_customer_info set fld_name = '".$name."', fld_mobile_no = '".$mobile_no."', 
							 fld_email = '".$email."', fld_password = '".$password."', fld_is_active = '".$is_active."', fld_rating = '".$rating."'
							 where fld_customer_ai_id = '".$id."'" ;
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
					$error_message = SERVER_ERROR.$query;
				   }
				}
			}
		}
	}
}elseif(loader_get_isset('id')){
	
	$id = loader_get_get('id');
	if("" == $id){
	  $error_message = MANDATORY_MISSING;
	}else{
		$query = "select name, mobile_no, email, password, is_active, rating from view_customer_info where customer_ai_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$name = $row['name'];
				$mobile_no = $row['mobile_no'];
				$email = $row['email'];
				$password = $row['password'];
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