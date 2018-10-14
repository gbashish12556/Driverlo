<?php 
$mailTemplate = array();
$mailTemplate['contactus_subject'] = '%%SUBJECT%%';
$mailTemplate['contactus_content'] = '<span style="font-size:15px; font-weight:bold;">Message From:- %%NAME%%</span><br/>
									<span style="font-size:15px; font-weight:bold;">Mail From:- %%MAIL%%</span><br/> 
									<span style="font-size:15px; font-weight:bold;">Message:- %%MESSAGE%%</span><br/><br/>';
$mailTemplate['welcome_subject'] = '%%SUBJECT%%';
$mailTemplate['welcome_content'] = '<span style="font-size:15px; font-weight:bold;">Dear %%NAME%%,</span><br/><br/>
            Your account on Driver LO has been created successfully. You can now start using your account. %%MESSAGE%%<br/>';		

$mailTemplate['otp_subject'] = 'One Time Password';
$mailTemplate['otp_content'] = '<span style="font-size:15px; font-weight:bold;">Dear %%NAME%%</span><br/><br/>
            %%MESSAGE%%<br/>';
			
$mailTemplate['booking_subject'] = 'Driver Lo Receipt note';
$mailTemplate['booking_content'] = '<span style="font-size:15px; font-weight:bold;">Dear %%NAME%%</span><br/><br/>
%%MESSAGE%%<br/>';


?>