<?php include(ACTION_PATH.'confirmbooking_action.php'); ?>
<script>
var myCenter=new google.maps.LatLng(<?php  loader_display($pickup_lat)  ?>,<?php  loader_display($pickup_lng)  ?>);
function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:14,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<section class="section margin-bottom-10">
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
<section class="section">
    <div class="container">
      <div class="row body_blue_round">
        <div class="col-sm-12">
          <h1 class="main_heading super  text-center">Confirm Booking</h1>
        </div>
      </div>
     </div>
</section>
<section class="section section-short ">
    <div class="container">
     <div class="row">
       <div class="form-group">
         <div class="col-sm-6 body_white_round">
               <form class="form" action="<?php loader_display(ROOT_PATH."bookingstatus")?>" method="post" >
                 <div class="form-group row">
                    <label for="name" class="col-sm-2 control-label">Name*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control required"  type="text" size="50" name="name" id="name" value="<?php loader_display($name)?>" placeholder="Enter Your Name" <?php if(loader_session_isset('mobile_no')){?>readonly="readonly"<?php }?>/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="mobile_no" class="col-sm-2 control-label">Mobile*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control required mobile_no numeric"  type="text" size="50" name="mobile_no" id="mobile_no" value="<?php loader_display($mobile_no)?>" placeholder="Enter 10 digit mobile No" <?php if(loader_session_isset('mobile_no')){?>readonly="readonly"<?php }?>/>
                    </div>
                 </div>
                  <div class="form-group row">
                    <label for="pickup_point" class="col-sm-2 control-label">Pickup Point*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control required"  type="text" size="50" name="pickup_point" id="pickup_point" value="<?php loader_display($pickup_point)?>" placeholder="Enter Pickup Point" readonly="readonly"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="booking_datetime" class="col-sm-2 control-label">Booking DateTime*</label>
                    <div class="col-sm-10">
                        <input class="large-form-control required datetime"  type="text" size="50" name="booking_datetime" id="booking_datetime" value="<?php loader_display($booking_datetime)?>" placeholder="Enter Booking DateTime" readonly="readonly"/>
                    </div>
                 </div>
                 <div class="form-group row">
                    <label for="coupon_code" class="col-sm-2 control-label">Coupon Code</label>
                    <div class="col-sm-10">
                        <input class="large-form-control"  type="text" size="50" name="coupon_code" id="coupon_code"  value="<?php loader_display($coupon_code)?>" placeholder="Coupon Code(Optional)"/>
                    </div>
                 </div>
                 <div class="form-group text-center">
                      <div class="">
                            <input type="submit" id="get_quote_button" name="get_quote_button" class="btn btn-large btn-default" value="Confirm Booking" />
                        </div>
                    </div>
               </form>
           </div>
        	 <div class="col-sm-6 body_white_round text-center">
                    <div class="googleMap" id="googleMap"></div>
             </div>
         </div>
       </div>
     </div>
    </div>
  </section>