<?php
ini_set("allow_url_fopen","On");
function loader_include($file_name){	return include_once($file_name);}
function error_handling($msg = ''){	if($msg == "") 	echo "Connection problem , Please try again";	else 	echo $msg;	}
# Database query
function loader_escape($string){loader_debug(__LINE__,__FILE__,__FUNCTION__);global $con;return mysqli_real_escape_string($con,$string);}
function loader_trim($value){loader_debug(__LINE__,__FILE__,__FUNCTION__);return trim($value);}
function loader_fetch_array($value){loader_debug(__LINE__,__FILE__,__FUNCTION__);return mysqli_fetch_array($value);}
function loader_fetch_assoc($result){loader_debug(__LINE__,__FILE__,__FUNCTION__);global $con;return mysqli_fetch_assoc($result);}
function loader_query($query){loader_debug(__LINE__,__FILE__,__FUNCTION__);loader_print_query(__LINE__,__FILE__,$query);global $con;return mysqli_query($con,$query);}
function loader_num_rows($result){$rows = mysqli_num_rows($result);loader_debug(__LINE__,__FILE__,__FUNCTION__); return $rows;}
function loader_last_inserted(){loader_debug(__LINE__,__FILE__,__FUNCTION__);global $con;return mysqli_insert_id($con);}
function find_position($string, $findme){loader_debug(__LINE__,__FILE__,__FUNCTION__);return strpos($string, $findme);}
function loader_is_numeric($value){loader_debug(__LINE__,__FILE__,__FUNCTION__);return is_numeric($value);}
function loader_commit_off(){global $con;mysqli_query($con,"SET AUTOCOMMIT=0"); }
function loader_commit_on(){global $con;mysqli_query($con,"SET AUTOCOMMIT=1"); }
function loader_commit(){global $con;mysqli_query($con,"COMMIT"); }
function loader_rollback(){global $con;mysqli_query($con,"ROLLBACK");}
function loader_upper($value){loader_debug(__LINE__,__FILE__,__FUNCTION__);return strtoupper($value);}
function loader_date_function($date){loader_debug(__LINE__,__FILE__,__FUNCTION__);return $date;}
function loader_email_function($email){loader_debug(__LINE__,__FILE__,__FUNCTION__);return $email;}
function loader_phone_function($phone){loader_debug(__LINE__,__FILE__,__FUNCTION__);return $phone;}
function loader_count($value){loader_debug(__LINE__,__FILE__,__FUNCTION__);return count($value);}
#file put contents......
function loader_file_put_content($folder, $content)
{
	file_put_contents($folder."/".date('d-m-Y',time())."testFile.txt",date('d-m-Y H:i:s a',time())." ".print_r($content,true)."<br/>",FILE_APPEND);
}
 #date time addittion Function....
function loader_sum_the_time($time1, $time2) {
  $times = array($time1, $time2);
  $seconds = 0;
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  // return "{$hours}:{$minutes}:{$seconds}";
  return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
} 
#null function....
function loader_isnull($value){return is_null($value); }
#enum function
function loader_isenum($value){ return preg_match('/^[0-1]/',$value);}
#round function....
function loader_round($value){return round($value, 2); }
#isset function...
function loader_isset($variable){loader_debug(__LINE__,__FILE__,__FUNCTION__); return isset($variable);}
#validate date format......
function loader_validateDate($date, $format)
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}	

# Initialize session data
function loader_start_session() {session_start();}
function loader_destroy_session() {session_destroy();}
function loader_set_session( $session_name,$session_value ){	$_SESSION[$session_name] = $session_value;}
function loader_get_session($session_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_SESSION[$session_name];}
function loader_session_isset($session_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return isset($_SESSION[$session_name]);}
function loader_unset_session($session_name){unset($_SESSION[$session_name]);}
function loader_all_session_unset(){loader_debug(__LINE__,__FILE__,__FUNCTION__);session_unset();}
function loader_close_session(){	session_close();}		  
#session function end
function loader_today_date(){loader_debug(__LINE__,__FILE__,__FUNCTION__);return date('Y-m-d H:i:s');}
function loader_display($content){ echo $content;}
function loader_html_display($content){ echo $content;}
function loader_strip($str){loader_debug(__LINE__,__FILE__,__FUNCTION__);return stripslashes($str);}
function loader_hash($content)	{$output = md5($content.sha1($content));	if(!$output) {loader_display("error in hashing md5 input "."\r\n"); } else { loader_debug(__LINE__,__FILE__,__FUNCTION__);return $output;}}

# Post function
function loader_get_post_escape($post_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);global $con;return mysqli_real_escape_string($con,trim($_POST[$post_name]));	}
function loader_get_post($post_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_POST[$post_name];	}
function loader_get_files($post_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_FILES[$post_name];	}
function loader_post_isset($post_name){loader_debug(__LINE__,__FILE__,__FUNCTION__); return isset($_POST[$post_name]);}
function loader_all_post(){loader_debug(__LINE__,__FILE__,__FUNCTION__); return $_POST;}
#2D post function.....
function loader_get_2Dpost($first,$second){loader_debug(__LINE__,__FILE__,__FUNCTION__); return ($_POST[$first][$second]);}
function loader_2Dpost_isset($first,$second){loader_debug(__LINE__,__FILE__,__FUNCTION__); return isset($_POST[$first][$second]);} 
#function for uc words.........
function loader_ucwords($string){loader_debug(__LINE__,__FILE__,__FUNCTION__);return ucwords(strtolower($string));}
#function for lc words.........
function loader_uppercase($string){loader_debug(__LINE__,__FILE__,__FUNCTION__);return strtoupper($string);}
#End post function
function loader_debug($line_number,$file_name,$function,$var = NULL)
{
	/*if($var)
		$var = implode(",", $var);
	$somecontent = "[".date('Y-m-d H:i:s')."]  \t ".$file_name."\t".$function."\t Line_number:".$line_number."\t".$var."\r\n";
	$filename = dirname(__FILE__) . '/debug_log.txt';
	if (!$handle = fopen($filename, 'a')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }*/
}
function loader_url_log()
{
	/*	$somecontent = "[".date('Y-m-d H:i:s')."]  \t ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n";
		$filename = dirname(__FILE__) . '/url_log/'.date('Y-m-d').'.txt';
		if (!$handle = fopen($filename, 'a')) {
			 echo "Cannot open file ($filename)";
			 exit;
		}
	
		if (fwrite($handle, $somecontent) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}*/
	
}
function loader_print_query($line_number,$file_name,$query)
{
	/*	$somecontent = "[".date('Y-m-d H:i:s')."]  \t ".$file_name."\t Line_number:".$line_number."\t".$query."\r\n";
		$filename = dirname(__FILE__) . '/query_log/'.date('Y-m-d').'.txt';
		if (!$handle = fopen($filename, 'a')) {
			 echo "Cannot open file ($filename)";
			 exit;
		}
	
		if (fwrite($handle, $somecontent) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}*/
	
}

function loader_debug_print($var, $print_stack = 0, $exit_here = 0)
{
	
	/*if(1 == $print_stack) 
	{
		var_dump(debug_backtrace());
	}
	if(1 == $exit_here)
	{
		exit();
	}*/
}
function loader64_encode($string){ loader_debug(__LINE__,__FILE__,__FUNCTION__);return base64_encode($string);}
function loader64_decode($string){ loader_debug(__LINE__,__FILE__,__FUNCTION__);return base64_decode($string);}
#Cookie handler functions
function loader_cookie_isset($cookie_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);return isset($_COOKIE[$cookie_name]);}
function loader_get_cookie($cookie_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_COOKIE[$cookie_name];}
#End cookie handler functions

# Get function
function loader_get_get($get_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return trim($_GET[$get_name]);	}
function loader_get_isset($get_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return isset($_GET[$get_name]);}
#End get function

# Request function
function loader_get_request($request_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_REQUEST[$request_name];	}
function loader_request_isset($request_name){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return isset($_REQUEST[$request_name]);}
#End request function

#Get the ip address of the visitor's machine
function loader_get_ip(){ loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_SERVER["REMOTE_ADDR"]; }
#End
#Get the browser address of the visitor's machine
function loader_get_user_browser(){ loader_debug(__LINE__,__FILE__,__FUNCTION__);	return $_SERVER['HTTP_USER_AGENT'];}

#Page redirect
function loader_redirect($url){loader_debug(__LINE__,__FILE__,__FUNCTION__); return (header('Location: '.$url));	}

#Return number of element in the array
function loader_array_count($ar_data){loader_debug(__LINE__,__FILE__,__FUNCTION__);	 return count($ar_data);}
#End

function genRandomString()
{
	$length=6;
	if($length>0) 
	{ 
		$rand_id="";
	   	for($i=1; $i<=$length; $i++)
	   	{
	   		mt_srand((double)microtime() * 1000000);
	   		$num = mt_rand(1,36);
	   		$rand_id .= assign_rand_value($num);
	   	}
	}
	return $rand_id;
}

function loader_in_array($value, $arr){return in_array($value, $arr);}
function loader_key_exists($value, $arr){return array_key_exists($value, $arr);}

#vaidate time
function loader_isValidTime($time){
	$regexp = "/(1[012]|[1-9]):[0-5][0-9](?i)(am|pm)/";
	loader_debug(__LINE__,__FILE__,__FUNCTION__);
	return preg_match($regexp, trim($time));}
#validate date
function loader_isValidDateTime($date){
	//echo $date;
	//$reg = "/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/";
	$regexp = "/^([0][1-9]|[12][0-9]|3[0-1])\/([0][1-9]|1[0-2])\/(\d{4}) (0[0-9]|1[0-2]):([0-5][0-9]) (am|pm|AM|PM)$/";
	loader_debug(__LINE__,__FILE__,__FUNCTION__);
	return preg_match($regexp, trim($date));}
function loader_isValidEmail($Email){
	$regexp='/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
	loader_debug(__LINE__,__FILE__,__FUNCTION__);
	return preg_match($regexp, trim($Email));}
# Implode Function
function loader_implode($format,$val){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return implode($format,$val);}
#End
function validate_alphanumeric_underscore($str){
    if(preg_match('/^[a-zA-Z0-9_]+$/',$str) && substr($str, 0, 1)!="_"){loader_debug(__LINE__,__FILE__,__FUNCTION__);	return true;}
	else{loader_debug(__LINE__,__FILE__,__FUNCTION__);return false;}}
function validate_phone_number($phone){
	//echo $phone;
	if(!preg_match("/^[0-9]{10}$/i",$phone))
	{
		loader_debug(__LINE__,__FILE__,__FUNCTION__);
		return false;
	}
	else
	{
		loader_debug(__LINE__,__FILE__,__FUNCTION__);
	 	return true;
	}}
function loader_send_mail($template,$template_data_array,$template_value_array,$receiver,$sender,$subject)
{
	$template_data_array = array_map("add_email_template_code", $template_data_array);
	$email_data = str_replace($template_data_array, $template_value_array, $template);
	$subject = str_replace($template_data_array, $template_value_array, $subject);
	$email_id = "";
	$from = 'noreply@driverlo.in';
	if("" == LOCAL)
	{
		$email_id =	$receiver;
	   file_put_contents("includes/logs/extra_data/".date('d-m-Y',time())."testFile.txt",date('d-m-Y H:i:s a',time())." ".print_r("Main".$email_id.LOCAL,true)."<br>",FILE_APPEND);
	}
	else
	{
		$email_id =	$receiver;
       file_put_contents("includes/logs/extra_data/".date('d-m-Y',time())."testFile.txt",date('d-m-Y H:i:s a',time())." ".print_r("Local".$email_id.LOCAL,true)."<br>",FILE_APPEND);
	}
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Driver LO</title>
</head>
<body>
    <div style="width:650px; margin-left:auto; margin-right:auto; height:auto; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#777; border:1px solid #ecebeb; overflow:hidden;">
    	<div style="width:100%; float:left; border-bottom:1px solid #ecebeb; height:auto; padding:10px;">
        	<img src="'.WEBSITE_ROOT_PATH.'images/driverlo_smal_logo.png" border="0" alt="loader" width="128" height="64"/>
        </div>
        <div style="width:100%; float:left; height:auto; padding:20px;">
   '.$email_data.'
     <br/><br/>
            If you have any questions please read the <a href="'.WEBSITE_ROOT_PATH.'faq" style="color:#ff1bff; font-weight:bold;">FAQ</a> section or <a href="'.WEBSITE_ROOT_PATH.'"contact" style=" font-weight:bold;color:#ff1bff">email us</a>.<br/><br/>
            Please do not reply to this mail!<br/>
            <strong>Driver LO Team</strong>
        </div>
        <div style="padding:5px 20px; background:#004586; color:#fff; width:100%; height:auto; float:left;">
        	If you didnt sign up for Driver Lo and have received this email in error, please <a href="'.WEBSITE_ROOT_PATH.'contact" style="color:#8dc63f; font-weight:bold;">Contact Us</a>.
        </div>
    </div>
</body>
</html>';

    $headers = "Reply-To: ".$sender."\r\n";
    $headers .= "Return-Path: ".$sender."\r\n";
    $headers .= "From: ".$from."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\nX-Priority: 3\r\nX-Mailer: PHP". phpversion() ."\r\n";
	       file_put_contents("includes/logs/extra_data/".date('d-m-Y',time())."testFile.txt",date('d-m-Y H:i:s a',time())." ".print_r("Local".$message.LOCAL,true)."<br>",FILE_APPEND);
	if(mail($email_id,$subject,$message,$headers,'O DeliveryMode=b'))
	{
		loader_debug(__LINE__,__FILE__,__FUNCTION__);
		return "SUCCESS";
	}
	else
	{
		loader_debug(__LINE__,__FILE__,__FUNCTION__);
	    return "FAIL";

	}
}
function add_email_template_code($n)
{
	loader_debug(__LINE__,__FILE__,__FUNCTION__);
    return("%%".$n."%%");
}
function loader_send_sms($sms_data,$receiver, $page){

    $sms_message = urlencode($sms_data).'%0A'.urlencode('Driverlo.in').''.urlencode('03326655544');
	//$url =  'http://sms.salert.co.in/new/api/api_http.php?';
    //$data = 'username=driverlo&password=pawan@082&senderid=DRIVLO&to='.$receiver.'&text='.urlencode($sms_data).'&route=Transaction&type=text';
	$url =  'http://www.sambsms.com/app/smsapi/index.php?';
	$data = 'key=35801FE867A38F&campaign=0&routeid=26&type=text&contacts='.$receiver.'&senderid=DRIVLO&msg='.$sms_message.'';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);
}
function loader_send_promotional_sms($sms_data,$receiver, $page){

	$url =  'http://sms.salert.co.in/new/api/api_http.php?';
    $data = 'username=ashishgupta&password=ashish123&senderid=SHIPPR&to='.$receiver.'&text='.urlencode($sms_data).'&route=Enterprise&type=text';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);
}
 #get city function for get country from db............  
function get_citylist($select_vehicle = "")
{
	$option = "<option value=''>Select City</option>";
    $query = "SELECT city_name, city_id FROM view_city WHERE is_active = '1' ";
	//echo $query;
	if($result = loader_query($query))
	{
		while($row = loader_fetch_assoc($result))
		{
				$selected = "";
				if($row['city_id'] == $select_vehicle)
				{
					$selected = "selected='selected'";
				}
				$option .= "<option value='".$row['city_id']."' ".$selected .">".$row['city_name']."</option>";
		}  
		loader_display("<select name='city' id='city' class='large-form-control required' >".$option."</select>");
	}
	else
	{
		$error_message = SERVER_ERROR;
	}
}
#check if customer token already exist
function customer_isTokenExist($token)
{
	$queryres = loader_query("SELECT customer_ai_id FROM view_customer_info WHERE user_token = '".$token."'");
	if(loader_num_rows($queryres)>0)
	{
			loader_debug(__LINE__,__FILE__,__FUNCTION__);
	        return true;
	}
	else
	{
			loader_debug(__LINE__,__FILE__,__FUNCTION__);
	        return false;
	}
}
function IsEmailExist($email)
{
	$query_function = "select email from view_customer_info where email='".$email."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
			}
		}else{
			return false;
			}
}
function IsMobileExist($mobile_no)
{
	$query_function = "select mobile_no from view_customer_info where mobile_no='".$mobile_no."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsMobileRepeat($mobile_no, $customer_id)
{
	$query_function = "select mobile_no from view_customer_info where mobile_no='".$mobile_no."' and customer_ai_id != '".$customer_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCouponValid($coupon_code){
	$query_function = "select coupon_code from view_coupon_discount where coupon_code='".$coupon_code."' and is_validated = '0' ";
	if($result_function = loader_query($query_function)){
	     if(loader_num_rows($result_function)>0){
			 //$query_function1 = "update tbl_coupon_discount set fld_is_validated = '1' where fld_coupon_code='".$coupon_code."'";
			 //if(loader_query($query_function1)){
		        return true;
			  //}else{
			  	//return false;
			  //}
		 }else{
		     return false;
		 }
	}else{
	     return false;
	}
}
#reapeat email check for edit profile
function isRepeatEmail($user_token,$email){
	$query_function = "select email from view_customer_info where email='".$email."' and user_token != '".$user_token."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
 #get city function for get country from db............  
function get_franchiselist($selected_franchise = "")
{
	$option = "<option value=''>Select Franchise</option>";
    $query = "SELECT name, franchise_ai_id FROM view_franchise_info WHERE is_active = '1' ORDER BY name ASC";
	//echo $query;
	if($result = loader_query($query))
	{
		while($row = loader_fetch_assoc($result))
		{
				$selected = "";
				if($row['franchise_ai_id'] == $selected_franchise)
				{
					$selected = "selected='selected'";
				}
				$option .= "<option value='".$row['franchise_ai_id']."' ".$selected .">".$row['name']."</option>";
		}  
		loader_display("<select name='franchise_id' id='franchise_id' class='required' >".$option."</select>");
	}
	else
	{
		  $error_message = SERVER_ERROR;
	}
}
function get_franchise($selected_franchise = "")
{
	$option = "<option value=''>Select Franchise</option>";
    $query = "SELECT name, franchise_ai_id FROM view_franchise_info WHERE is_active = '1' ORDER BY name ASC";
	//echo $query;
	if($result = loader_query($query))
	{
		while($row = loader_fetch_assoc($result))
		{
				$selected = "";
				if($row['franchise_ai_id'] == $selected_franchise)
				{
					$selected = "selected='selected'";
				}
				$option .= "<option value='".$row['franchise_ai_id']."' ".$selected .">".$row['name']."</option>";
		}  
		loader_display($option);
	}
	else
	{
		 $error_message = SERVER_ERROR;
	}
}
function get_selected_driver($selected_driver)
{
	$option = "<option value='' >Select Driver</option>";
    $query = "SELECT name, driver_ai_id FROM view_driver_info WHERE driver_ai_id ='".$selected_driver."' AND is_active = '1'";
	echo $query;
	if($result = loader_query($query))
	{
		while($row = loader_fetch_assoc($result))
		{
				$selected = "";
				if($row['driver_ai_id'] == $selected_driver)
				{
					$selected = "selected='selected'";
				}
				$option .= "<option value='".$row['driver_ai_id']."' ".$selected .">".$row['name']."</option>";
		}  
		loader_display($option);
	}
	else
	{
		 $error_message = SERVER_ERROR;
	}
}
function IsFranchiseMobileExist($mobile_no)
{
	$query_function = "select mobile_no from view_franchise_info where mobile_no='".$mobile_no."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsFranchiseMobileRepeat($mobile_no, $franchise_id)
{
	$query_function = "select mobile_no from view_franchise_info where mobile_no='".$mobile_no."' and franchise_ai_id != '".$franchise_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsDriverLicenseExist($license_no)
{
	$query_function = "select license_no from view_driver_info where license_no='".$license_no."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsDriverLicenseRepeat($license_no, $driver_id)
{
	$query_function = "select license_no from view_driver_info where license_no='".$license_no."' and driver_ai_id != '".$driver_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCustomerEmailExist($email)
{
	$query_function = "select email from view_customer_info where email='".$email."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
			}
		}else{
			return false;
			}
}
function IsCustomerEmailRepeat($email, $customer_id)
{
	$query_function = "select email from view_customer_info where email='".$email."' and customer_ai_id != '".$customer_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
			}
		}else{
			return false;
			}
}
function IsCustomerMobileExist($mobile_no)
{
	$query_function = "select mobile_no from view_customer_info where mobile_no='".$mobile_no."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCustomerMobileRepeat($mobile_no, $customer_id)
{
	$query_function = "select mobile_no from view_customer_info where mobile_no='".$mobile_no."' and customer_ai_id != '".$customer_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCityExist($city)
{
	$query_function = "select city_name from view_fare_chart where city_name ='".$city."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCityRepeat($city, $id)
{
	$query_function = "select city_name from view_fare_chart where city_name ='".$city."' and city_id != '".$id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCouponExist($coupon_code)
{
	$query_function = "select coupon_code from view_coupon_discount where coupon_code ='".$coupon_code."'";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function IsCouponRepeat($coupon_code, $coupon_id)
{
	$query_function = "select coupon_code from view_coupon_discount where coupon_code ='".$coupon_code."' and coupon_id != '".$coupon_id."' ";
	if($result_function= loader_query($query_function)){
		if(loader_num_rows($result_function)>0){
			return true;
		}else{
			return false;
		}
	}else{
	 	return false;
	}
}
function getNormalDatetime($datetime)
{
	$date = DateTime::createFromFormat('d/m/Y g:i a',$datetime);
	$NormalDatetime = $date->format('Y-m-d H:i:s');
	return $NormalDatetime;
}
function getConvertedDatetime($datetime)
{
	$ConvertedDatetime = date('d/m/Y g:i a', strtotime($datetime));
	return $ConvertedDatetime;

}
?>
   
