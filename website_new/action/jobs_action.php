<?php
 $first_name=$last_name = $postal_address = $mobile_no = $email = $gender = $subject = $message = $name = $error_message = $success_message = "";

include_once('includes/php_mailer/class.phpmailer.php');

if(loader_post_isset('submit_resume_button')){
	$first_name = loader_get_post_escape('first_name');
	$last_name = loader_get_post_escape('last_name');
	$name = loader_ucwords($first_name)." ".loader_ucwords($last_name);
	$email = loader_get_post_escape('email');
	$mobile_no = loader_get_post_escape('mobile_no');
	$gender = loader_get_post_escape('gender');
	$postal_address = loader_get_post_escape('postal_address');
	$resume = $_FILES['resume'];
	if(("" == $first_name)||("" == $last_name)||("" == $email)||("" == $mobile_no)||("" == $postal_address)||("" == $gender)){
		$error_message = MANDATORY_MISSING;
	}else{
		$newfilename = round(microtime(true)).'_'.$first_name."_".$mobile_no."".$_FILES['resume']['name']  ;
		$db_path ="uploads/".$newfilename ;
		$listtype = array(
		'.doc'=>'application/msword',
		'.docx'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'.pdf'=>'application/pdf'); 
		if (is_uploaded_file($_FILES['resume']['tmp_name']))
		{
			if($key = array_search($_FILES['resume']['type'],$listtype))
			{
				if (move_uploaded_file($_FILES['resume']['tmp_name'],$db_path))
				{
                   $query = "insert into tbl_applicant_info (fld_name,fld_mobile_no,fld_email,fld_postal_address,fld_resume,fld_gender) values('".$name."','".$mobile_no."','".$email."','".$postal_address."','".$newfilename."','".$gender."')";

				   if(loader_query($query)){
					   
						$email = new PHPMailer();
						$email->From      = NOREPLY_EMAIL;
						$email->FromName  = $first_name;
						$email->Subject   = 'New Application';
						$email->Body      = 'New resume received';
						$email->AddAddress( COMPANY_EMAIL);
						$email->AddAttachment( $db_path , $_FILES['resume']['name'] );
						$email->Send();
					   	$success_message = RESUME_UPLOAD_SUCCESS;
						
				   }else{
				  		 $error_message = SERVER_ERROR;
				   }
				}else{
				   $error_message = FILE_UPLOAD_ERROR;
				}
			}
			else    
			{
				$error_message = INVALID_DOC_TYPE;
			}
     	}else{
		     $error_message = FILE_UPLOAD_ERROR;
		}
	}
}
if(loader_post_isset('register_driver_button')){
	$driver_mobile_no = loader_get_post_escape('driver_mobile_no');
	$session = loader_get_post_escape('session');
	if($session == loader_get_session('form_session'))
	{echo"<script>alert('something!!');</script>";
	if(("" == $driver_mobile_no)){
		$error_message = MANDATORY_MISSING;
	}else{
	   $query = "insert into tbl_new_driver (fld_mobile_no) values('".$driver_mobile_no."')";
	   if(loader_query($query)){
		   $recipient = COMPANY_EMAIL;
					$template_data_array = array("SUBJECT","NAME","MAIL","MESSAGE");
					$template_value_array = array('New Driver Registration',$name."".$driver_mobile_no,'N/A','Contact This Driver!');
					global $mailTemplate;
					$send = loader_send_mail($mailTemplate['contactus_content'],$template_data_array,$template_value_array,$recipient,$email,$mailTemplate['contactus_subject']);
                 $success_message = DRIVER_REGISTER_SUCCESS;
		 loader_set_session('form_session','processed');
	   }else{
		   $error_message = SERVER_ERROR;
	   }
	}
	}
}
?>