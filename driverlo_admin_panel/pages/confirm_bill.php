<?php
if(loader_session_isset('user_name')){ 
 include_once(ACTION_PATH.'confirm_bill_action.php')?>
<script>
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
function initializ2() {
	var input = document.getElementById('dropoff_point');
	var autocomplete = new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function () {
		var place = autocomplete.getPlace();
		document.getElementById('dropoff_lat').value = place.geometry.location.lat();
		document.getElementById('dropoff_ng').value = place.geometry.location.lng();
	});
}
google.maps.event.addDomListener(window, 'load', initializ2);
     jQuery(function(){
		jQuery('#booking_start_datetime').datetimepicker({
			format:'d/m/Y h:i a',
			minDate:'+1970/01/01',
			maxDate:'+1970/01/08'
		});
	});
	     jQuery(function(){
		jQuery('#booking_end_datetime').datetimepicker({
			format:'d/m/Y h:i a',
			minDate:'+1970/01/01',
			maxDate:'+1970/01/08'
		});
	});
</script>
<div id="wrapper">
    <?php include_once('left_menu.php')?>
    <!--Body content-->
    <div id="content" class="clearfix">
        <div class="contentwrapper"><!--Content wrapper-->
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
            <div class="heading">
                <h3>Generate Bill</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Generate Bill</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="create_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH."confirm_bill")?>">
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Pickup Location</label>
                                                    <input class="span8 required" id="pickup_point" name="pickup_point" placeholder="Pickup Location" type="text" readonly="readonly" value="<?php loader_display($pickup_point)?>" />
                                                       <input type="text" name="id" value="<?php loader_display($id)?>" style="display:none">
                                                       <input type="text" name="brn_no" value="<?php loader_display($brn_no)?>" style="display:none">
                                                       <input type="text" name="franchise_mobile_no" value="<?php loader_display($franchise_mobile_no)?>" style="display:none">
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Dropoff Location</label>
                                                    <input class="span8 required" id="dropoff_point" name="dropoff_point" placeholder="Dropoff Location" type="text" readonly="readonly" value="<?php loader_display($dropoff_point)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Customer Name</label>
                                                    <input class="span8 required" id="name" name="name" placeholder="Customer Name" type="text" readonly="readonly" value="<?php loader_display($name)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Customer Mobile No</label>
                                                    <input class="span8 mask required numeric mobile_no" name="mobile_no" Placeholder="Customer Mobile No" type="text" readonly="readonly" value="<?php loader_display($mobile_no)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Franchise Name</label>
                                                    <input class="span8 required" id="franchise_name" name="franchise_name" placeholder="Franchise Name" type="text" readonly="readonly" value="<?php loader_display($franchise_name)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Driver Name</label>
                                                    <input class="span8 mask required" name="driver_name" Placeholder="Driver Name" type="text" readonly="readonly" value="<?php loader_display($driver_name)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Cutomer Rating</label>
                                                    <input class="span8 required numeric_5" id="customer_rating" name="customer_rating" placeholder="Franchise Name" type="text"  value="<?php loader_display($customer_rating)?>" readonly="readonly" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Driver Feedback</label>
                                                    <input class="span8 required" name="driver_feedback" Placeholder="Driver Name" type="text"  value="<?php loader_display($driver_feedback)?>" readonly="readonly" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Time</label>
                                                    <input class="span8 required" id="journey_time" name="journey_time" placeholder="Journey Time" type="text" value="<?php loader_display($journey_time)?>" readonly="readonly"  />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Total Time</label>
                                                    <input class="span8 required" id="total_time" name="total_time" placeholder="Total Duration" type="text" value="<?php loader_display($total_time)?>" readonly="readonly" />
                                                </div>
                                             </div>
                                        </div>
                                         <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Type</label>
                                                    <input class="span8 required" id="journey_type" name="journey_type" placeholder="Booking Start Datetime" type="text" value="<?php loader_display($journey_type)?>" readonly="readonly" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Total Fare</label>
                                                    <input class="span8 required" id="total_fare" name="total_fare" placeholder="Total Duration" type="text" value="<?php loader_display($total_fare)?>" readonly="readonly" />
                                                </div>
                                             </div>
                                        </div>
                                          <?php loader_set_session('form_session',rand(10,10000));?>
               							  <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" style="display:none" />
   										<div class="form-actions">
                                           <button type="submit" class="btn btn-info">Confirm Bill</button>
                                        </div>
                                    </form>
                                </div>
                         </div>  <!-- End .box -->
                    </div><!-- End .span12 -->
            	</div><!-- End .row-fluid -->
            <!-- Page end here -->
        </div><!-- End contentwrapper -->
    </div><!-- End Body content -->
</div><!-- End #wrapper -->

<?php
}else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>      