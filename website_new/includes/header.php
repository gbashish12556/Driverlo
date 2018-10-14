<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/PostalAddress">
  <head>
  <title>Driver Lo | Hire professional Chauffeur</title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0;  user-scalable=0;" name="viewport">
    <!-- SEO -->
<meta name="description" content=" Driverlo is kolkata's Premier Chauffeur Service provider. With the intention of making the process of driving in Kolkata hassle free, completely, safe & reliable.">
<meta name="keywords" content="Driver Lo, Driver on rent , hire professional chauffer">
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<meta name="author" content="DriverLo">
<meta name="google-site-verification" content="e4ThV_fpr176RnEt9vaLzk-0dhTZQGAd5qRKpZP34BY" />
<link rel="shortcut icon" href="images/driverlo_dl_tab.png" />
<link rel="publisher" href="https://plus.google.com/108938980337820042436" />
<link rel="stylesheet" href="<?php loader_display(ROOT_PATH)?>css/bootstrap.min.css">
<link rel="stylesheet" href="<?php loader_display(ROOT_PATH)?>css/datetimepicker.min.css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link href="<?php loader_display(ROOT_PATH)?>css/style.css" media="all" rel="stylesheet" />
<script src="<?php loader_display(ROOT_PATH)?>js/jquery.min.js"></script>
<script src="<?php loader_display(ROOT_PATH)?>js/jquery-ui.min.js"></script>
<script src="<?php loader_display(ROOT_PATH)?>js/bootstrap.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&key=AIzaSyB16e-1Q6Ogfx3bEQ8AVY5R1NvMYNHkgok" type="text/javascript"></script>
<script type="text/javascript" async="async" defer="defer" data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=39180780"></script>
<script>
    //intialize place dropdown 1
	function initializ1() {
		var input = document.getElementById('pickup_point');
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();
		    document.getElementById('pickup_lat').value = place.geometry.location.lat();
            document.getElementById('pickup_lng').value = place.geometry.location.lng();
		});
	}
	google.maps.event.addDomListener(window, 'load', initializ1);
	jQuery(function(){
		jQuery('#booking_datetime').datetimepicker({
			format:'d/m/Y h:i a',
			minDate:'+1970/01/01',
			maxDate:'+1970/01/08',
			 allowTimes:[
				'01:00', '01:15', '01:30','01:45', 
				'02:00', '02:15', '02:30','02:45', 
				'03:00', '03:15', '03:30','03:45', 
				'04:00', '04:15', '04:30','04:45',  
				'05:00', '05:15', '05:30','05:45', 
				'06:00', '06:15', '06:30','06:45', 
				'07:00', '07:15', '07:30','07:45', 
				'08:00', '08:15', '08:30','08:45', 
				'09:00', '09:15', '09:30','09:45', 
				'10:00', '10:15', '10:30','10:45', 
				'11:00', '11:15', '11:30','11:45', 
				'12:00', '12:15', '12:30','12:45',  
				'13:00', '13:15', '13:30','13:45', 
				'14:00', '14:15', '14:30','14:45', 
				'15:00', '15:15', '15:30','15:45', 
				'16:00', '16:15', '16:30','16:45', 
				'17:00', '17:15', '17:30','17:45', 
				'18:00', '18:15', '18:30','18:45', 
				'19:00', '19:15', '19:30','19:45', 
				'20:00', '20:15', '20:30','20:45',  
				'21:00', '21:15', '21:30','21:45', 
				'22:00', '22:15', '22:30','22:45', 
				'23:00', '23:15', '23:30','23:45'
			 ],
			pick12HourFormat: false
		});
	});
	<?php if(!loader_session_isset('location_saved')){?>
	$(document).ready(function(){
	 		detect_location();
            function detect_location() {
                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(updateLocation);
			    }
			}
			function updateLocation(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
				//alert('lattitude'+latitude+'longitude'+longitude);
				$.ajax({
					type: "POST",
					url: "<?php loader_display(ROOT_PATH."detect_availibility")?>",
					data:'current_lat='+ latitude + '&current_lng='+ longitude,
					success: function(data){
						if(data.trim()){
							alert(data);
							<?php loader_set_session('location_saved','1')?>
						}
					}
				});
            }
	});
	<?php }?>
</script>
<?php include(ACTION_PATH.'header_action.php')?>
</head>
<body>
<!--fixed navigation bar wtih dropdown menu-->
<!---->
 <div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
       </button>
        <a href="http://www.driverlo.in" rel="Publisher"><img alt="DriverLo Logo" src="images/driverlo_smal_logo.png"/></a>
       <a href="#" rel="Publisher"><img id="googleplay" alt="DriverLo Googleplay" src="images/app_coming.png"></a>
    </div>
    <div class="navbar-collapse collapse main-nav">
      <ul class="nav navbar-nav navbar-right ">
          <li <?php if("home" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH) ?>" >HOME</a></li>
          <li<?php if("aboutus" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH.'aboutus') ?>">ABOUT US</a></li>
          <li <?php if("pricing" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH.'pricing') ?>" >PRICING</a></li>
         <li <?php if("jobs" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH.'jobs') ?>" >JOBS</a></li>
         <li <?php if("faq" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH.'faq') ?>" >FAQ</a></li>
         <li <?php if("contact" == $page){?> class="active"<?php }?> ><a href="<?php loader_display(ROOT_PATH.'contact') ?>" >CONTACT</a></li>
         <li class="dropdown <?php if("register" == $page){?> active<?php }?>">
             <a <?php if(!loader_session_isset('mobile_no')){?> class="cd-signin"<?php }?> href="<?php if(loader_session_isset('mobile_no')){ loader_display(ROOT_PATH.'customerprofile');} else{loader_display('#0'); }?>"><?php if(loader_session_isset('mobile_no')){ loader_display(loader_get_session('mobile_no')); }else {loader_display("SIGNIN/SIGNUP"); }?>
             </a>
         </li>
      </ul>
    </div>
  </div>
</div>
 <!--Start Carousel-->
 <section class="section sub_header">
     <div class="container">
          <div class="row">
          <form id="get_quote_form" action="<?php loader_display(ROOT_PATH."confirmbooking")?>" method="POST">
             <div class="form-group" >
                 <div class="col-sm-2" ></div>
                <div class="col-sm-2 margin-bottom-10 no-padding">
                  <?php get_citylist();?>
                </div>
                <div class="col-sm-3 margin-bottom-10 no-padding">
                   <input class="large-form-control required"  type="text" size="50" name="pickup_point" id="pickup_point" placeholder="Enter Pickup Point" autocomplete="on" runat="server"/>
                </div>
                 <div class="col-sm-2 margin-bottom-10 no-padding">
                   <input class="large-form-control required datetime"  type="text" name="booking_datetime" id="booking_datetime" placeholder="Booking Datetime" />
                </div>
                <input type="text" class="required" name="pickup_lat" id="pickup_lat" hidden/>
                <input type="text" class="required" name="pickup_lng" id="pickup_lng" hidden/>
                 <div class="col-sm-1 margin-bottom-10 no-padding">
                   <input type="submit" class="btn btn-large" id="get_quote_form_button" name="get_quote_form_button" value="Get Quote" />
                </div>
                 <div class="col-sm-2"></div>
             </div>
           </form>
          </div>
     </div>
 </section>
 <!--End Carousel-->
	<div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Sign In</a></li>
				<li><a href="#0">Sign Up</a></li>
			</ul>
			<div id="cd-login"> <!-- log in form -->
				<form id="login_form" class="cd-form" method="post" action="<?php loader_display(ROOT_PATH.$page)?>" role="form" >
					<p class="fieldset">
						<label class="image-replace cd-mobile" for="login_mobile_no">Mobile</label>
						<input class="full-width has-padding has-border mobile_no required numeric"  name="login_mobile_no" id="login_mobile_no"   placeholder="Mobile No" required>
					</p>
					<p class="fieldset">
						<label class="image-replace cd-password" for="login_password">Password</label>
						<input class="full-width has-padding has-border required" name="login_password" id="login_password"  type="password"  placeholder="Password" required>
						<a href="#0" class="hide-password">Show</a>
					</p>
					<p class="fieldset">
						<input type="checkbox" id="remember-me" checked>
						<label for="remember-me">Remember me</label>
					</p>
					<p class="fieldset">
						<input class="full-width" type="submit" name="login_button" id="login_button" value="Login">
					</p>
				</form>
				<p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
                <p class="change_password"><a href="<?php loader_display(ROOT_PATH.'changepassword')?>">Change Password</a></p>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->
			<div id="cd-signup"> <!-- sign up form -->
				<form id="signup_form" class="cd-form" method="post" action="<?php loader_display(ROOT_PATH.$page)?>" role="form">
                	<p class="fieldset">
						<label class="image-replace cd-username" for="signup_name">Full Name*</label>
						<input class="full-width has-padding has-border required customvalidation" name="signup_name" id="signup_name"  type="text" placeholder="Full Name" required>
					</p>
					<p class="fieldset">
						<label class="image-replace cd-email" for="signup_email">Email Id*</label>
						<input class="full-width has-padding has-border required email" name="signup_email" id="signup_email"  type="email" placeholder="Email Id" required>
					</p>
					<p class="fieldset">
						<label class="image-replace cd-mobile" for="signup_mobile_no">Mobile No*</label>
						<input class="full-width has-padding has-border required mobile_no numeric" name="signup_mobile_no" id="signup_mobile_no" type="text" placeholder="Mobile No" required>
					</p>
					<p class="fieldset">
						<label class="image-replace cd-password" for="signup_password">Password*</label>
						<input class="full-width has-padding has-border required" name="signup_password" id="signup_password" type="password"  placeholder="Password" required>
						<a href="#0" class="hide-password">Show</a>
					</p>
                    <p class="fieldset">
						<label class="image-replace cd-password" for="confirm_signup_password">Confirm Password*</label>
						<input class="full-width has-padding has-border required" name="confirm_signup_password" id="confirm_signup_password" type="password"  placeholder="Confirm Password" required>
						<a href="#0" class="hide-password">Show</a>
					</p>
					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
					</p>
					<p class="fieldset">
						<input class="full-width has-padding" type="submit" name="signup_button" id="signup_button" value="Create account">
					</p>
				</form>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->
			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your 10 digit Mobile No. You will receive your password on your mobile.</p>
				<form id="forget_password_form" class="cd-form" method="post" action="<?php loader_display(ROOT_PATH.$page)?>" role="form" >
					<p class="fieldset">
						<label class="image-replace cd-mobile" for="reset_mobile_no">Mobile No</label>
						<input name="reset_mobile_no" class="full-width has-padding has-border required mobile_no numeric" id="reset_mobile_no" type="text" placeholder="Mobile No" required>
					</p>
					<p class="fieldset">
						<input class="full-width has-padding" type="submit" name="reset_password_button" id="reset_password_button"  value="Reset password">
					</p>
				</form>
				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> <!-- cd-user-modal -->
    
 <!-- modal for otp confirmation -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header" id="register_modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-lock"></span>Confirm OTP</h4>
      </div>
        <div class="modal-body" id="register_modal">
          <form action="<?php loader_display(ROOT_PATH.$page); ?>" method="post" role="form">
            <div class="form-group">
              <label for="otp">OTP</label>
              <input type="text" class="form-control" name="register_otp" id="register_otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>SUBMIT</button>
          </form>
        </div>
      </div>
    </div>
  </div>   
   <!-- modal for otp confirmation -->
<div class="modal fade" id="ConfirmBookingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header" id="register_modal">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-lock"></span>Confirm OTP</h4>
      </div>
        <div class="modal-body" id="register_modal">
          <form action="<?php loader_display(ROOT_PATH.'bookingstatus'); ?>" method="post" role="form">
            <div class="form-group">
              <label for="otp">OTP</label>
              <input type="text" class="form-control" name="confirm_booking_otp" id="confirm_booking_otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>SUBMIT</button>
          </form>
        </div>
      </div>
    </div>
  </div>   
<script type="text/javascript">
 $('#get_quote_form_button').click(function(e){
      	    e.preventDefault();
			var pickup_lat = $('#pickup_lat').val();
			var pickup_lng = $('#pickup_lng').val();
			var booking_datetime = $('#booking_datetime').val();
			var BookingDatetime =  getDateTime(booking_datetime);
			  if(("" != pickup_lat)&&("" != pickup_lng)){
				$.ajax({
					type: "POST",
					url: "<?php loader_display(ROOT_PATH."detect_availibility")?>",
					data:'current_lat='+ pickup_lat + '&current_lng='+ pickup_lng,
					success: function(data){
						if(data.trim()){
							alert(data);
						}else{
							var nowDate= new Date();
							//alert('BookingDatetime'+BookingDatetime+'nowDate'+nowDate);
							LastThirtyMin= new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), nowDate.getHours(), nowDate.getMinutes() + 30,nowDate.getSeconds());
							//alert('BookingDatetime'+BookingDatetime+'LastThirtyMin'+LastThirtyMin);
							if(BookingDatetime<LastThirtyMin){
								alert('Minimum Date&Time half an hour from now');
							}else{
								$('#get_quote_form').submit();
							}
						}
					}
				});
			  }
    });
$(function () {  
 var PickupPoint = $("#pickup_point").autocomplete({ 
      change: function() {
		  	  var pickup_lat = $('#pickup_lat').val();
			  var pickup_lng = $('#pickup_lng').val();
			  if(("" !== pickup_lat)&&("" !== pickup_lng)){
				$.ajax({
					type: "POST",
					url: "<?php loader_display(ROOT_PATH."detect_availibility")?>",
					data:'current_lat='+ pickup_lat + '&current_lng='+ pickup_lng,
					success: function(data){
						if(data.trim()){
							alert(data);
						}
					}
				});
			  }
	  }
   });
   PickupPoint.autocomplete('option','change').call(PickupPoint);
});
function getDateTime(DateString){
	var reggie = /^([0][1-9]|[12][0-9]|3[0-1])\/([0][1-9]|1[0-2])\/(\d{4}) (0[0-9]|1[0-2])\:([0-5][0-9]) (am|pm)$/;
	var dateArray = reggie.exec(DateString); 
	//alert(dateArray[4]+dateArray[6])
	if((dateArray[6] === 'pm')){
		 var hours = (+dateArray[4])+12;
	}else if((dateArray[6] === 'am')){
		var hours = (+dateArray[4]);
	}
	var dateObject = new Date(
		(+dateArray[3]),
		(+dateArray[2])-1, // Careful, month starts at 0!
		(+dateArray[1]),
		(hours),
		(+dateArray[5]),
		0
	);
	return dateObject;
}
</script>