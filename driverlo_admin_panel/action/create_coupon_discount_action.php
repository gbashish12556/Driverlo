<?php
$coupon_code = $coupon_discount = $is_referal = $error_message = $success_message = "";
//
if(loader_post_isset('coupon_code'))
{
	$coupon_code = strtoupper(loader_get_post_escape('coupon_code'));
	$coupon_discount = loader_get_post_escape('coupon_discount');
	$is_referal= loader_get_post_escape('is_referal');
	$session = loader_get_post_escape('session');
	//echo 'session'.$session;
	//echo 'form_session'.loader_get_session('form_session');
	if($session == loader_get_session('form_session'))
	{
		if(("" == $coupon_code)||("" == $coupon_discount)||("" == $is_referal)){
			$error_message = MANDATORY_MISSING;
		}else{
			if(IsCouponExist($coupon_code)){
				$error_message = EXIST_COUPON;
			}else{
			   $query = "insert into tbl_coupon_discount (fld_coupon_code, fld_coupon_discount, fld_is_referal)
			             values('".$coupon_code."', '".$coupon_discount."', '".$is_referal."') " ;
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
				$error_message = SERVER_ERROR;
			   }
			}
		}
	}
}
?>