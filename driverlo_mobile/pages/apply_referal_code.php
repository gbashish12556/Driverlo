<?php
$error_message = $success_message= "";
loader_file_put_content('includes/logs/post_data','apply_referal_code',$_REQUEST);
if(loader_post_isset('customer_token')){
	$userRow = array();
	$customer_token = loader_get_post_escape('customer_token');
	$referal_code = loader_get_post_escape('referal_code');
	if(("" == $customer_token)||("" == $referal_code)){
	     $error_message = MANDATORY_MISSING;
	}else{
		if(IsReferalValid($referal_code,$customer_token)){
			$query1 = "select total_point from view_customer_info where user_token = '".$customer_token."'";
			loader_file_put_content('includes/logs/query_data','apply_referal_code',$query1);
			if($result1 = loader_query($query1))
			{
				if(loader_num_rows($result1)>0){
					$row1 = loader_fetch_assoc($result1);
					$total_point = $row1['total_point'];
					$query2 = "select coupon_discount from view_coupon_discount where coupon_code = '".$referal_code."' and is_referal = '1' ";
					 loader_file_put_content('includes/logs/query_data','apply_referal_code',$query2);
					if($result2 = loader_query($query2)){
					   if(loader_num_rows($result2)>0){
						   $row2 = loader_fetch_assoc($result2);
						   $total_point  = $total_point + $row2['coupon_discount'];
						   loader_commit_off();
						   $query3  = "update tbl_customer_info set fld_total_point = '".$total_point."' where fld_user_token ='".$customer_token."' ";
					       $query4 = "insert into tbl_referal_code_log (fld_customer_token, fld_coupon_code) VALUES('".$customer_token."', '".$referal_code."')" ;
						   loader_file_put_content('includes/logs/query_data','apply_referal_code',$query3);
						   loader_file_put_content('includes/logs/query_data','apply_referal_code',$query4);
						   $result3 = loader_query($query3);
						   $result4 = loader_query($query4);
						   if($result3&&$result4){
						   		loader_commit();
								$success_message .= COUPON_VALID;
						   }else{
						   		loader_rollback();
								$error_message .= SERVER_ERROR;
						   }
						   loader_commit_on();
					   }else{
							 $error_message .= COUPON_INVALID;
					   }
					}else{
						$error_message .= SERVER_ERROR;
					}
				}else{
					$error_message = CUSTOMER_TOKEN_INVALID;
				}
			}else{
				$error_message = SERVER_ERROR;;
			}
		}else{
			 $error_message .= COUPON_INVALID;
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
	loader_file_put_content('includes/logs/send_data','apply_referal_code',$send_data);
}

?>