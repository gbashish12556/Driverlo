<?php
$coupon_code = $coupon_discount = $is_referal = $is_active = $error_message = $success_message = $id = "";
if(loader_post_isset('coupon_code'))
{
	$coupon_code = strtoupper(loader_get_post_escape('coupon_code'));
	$coupon_discount = loader_get_post_escape('coupon_discount');
	$is_referal= loader_get_post_escape('is_referal');
	$is_active =loader_get_post_escape('is_active');
	$id =loader_get_post_escape('id');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $coupon_code)||("" == $coupon_discount)||("" == $is_referal)||("" == $is_active)||("" == $id)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsCouponRepeat($coupon_code, $id)){
				$error_message = EXIST_COUPON;
			}else{
			   $query = "update tbl_coupon_discount set fld_coupon_code = '".$coupon_code."', fld_coupon_discount = '".$coupon_discount."', 
			             fld_is_referal = '".$is_referal."', fld_is_active = '".$is_active."'
						 where fld_coupon_id = '".$id."'" ;
			   if(loader_query($query)){
				 $success_message = IS_SUCCESS;
				 loader_set_session('form_session','processed');
				 				?>
						<script type="text/javascript">
						setTimeout(function () {
							 window.location='<?php loader_display(ROOT_PATH.'coupon_discount'); ?>';
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
		$query = "select coupon_code, coupon_discount, is_referal, is_active from view_coupon_discount where coupon_id = '".$id."' ";
		if($result = loader_query($query)){
			if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				$coupon_code = $row['coupon_code'];
				$coupon_discount = $row['coupon_discount'];
				$is_referal = $row['is_referal'];
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