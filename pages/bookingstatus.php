<?php include(ACTION_PATH.'bookingstatus_action.php')?>
<section class="margin-bottom-10">
    <div class="col-sm-12">
      <div>
                      <?php
                      if(isset($success_message) && $success_message !="")
                       {
                       ?>
                       <div class="alert alert-success">
                                    <button data-dismiss="alert" class="close" type="button">close</button>
                                    <?php loader_display($success_message); ?>
                                </div>
                     <?php  } ?>
      </div>
      <div>
                     <?php
                    if(isset($error_message) &&  $error_message != "")
                    {
                    ?>
                    <div class="alert alert-danger">
                                                 <button data-dismiss="alert" class="close" type="button">close</button>
                                                 <?php loader_display($error_message); ?>
                                         </div>
                  <?php  } ?>
      </div>
  </div>
</section>
<?php if(0 == $otp_status){?>
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Booking Status</h1>
        </div>
      </div>
     </div>
</section>
<section class="section">
    <div class="container">
      <div class="row body_white_round">
         <div class="form-group">
            <div class="col-sm-6">
              <h3>Mobile No: <?php loader_display($mobile_no)?></h3>
              <h3>Name: <?php loader_display($name)?></h3>
              <h3>BRN No: <?php loader_display($bcn_no)?></h3>
              <h3>Pickup Point: <?php loader_display($pickup_point)?></h3>
            </div>
             <div class="col-sm-6">
                <h3>Booking Datetime: <?php loader_display($booking_datetime)?></h3>
                <h3>Coupong Code: <?php loader_display($coupon_code)?></h3>
                <h3>Booking Status: <?php loader_display($approval_status)?></h3>
             </div>
         </div>
       </div>
     </div>
</section>
<?php } else if(1 == $otp_status){?>
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">OTP Verification</h1>
        </div>
      </div>
     </div>
</section>
<section class="section section-tiny">
    <div class="container">
      <div class="row body_white_round">
			 <h1 class="main_heading super  text-center">Please confirm OTP sent to your entered mobile no</h1>
       </div>
     </div>
</section>
<?php }?>