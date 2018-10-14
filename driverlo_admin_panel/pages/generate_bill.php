<?php 
if(loader_session_isset('user_name')){ include_once(ACTION_PATH.'generate_bill_action.php')?>
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
	     jQuery(function(){
		jQuery('#booking_end_datetime').datetimepicker({
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
                                    <form id="create_form" method="post" class="form-horizontal"  action="<?php loader_display(ROOT_PATH."confirm_bill")?>">
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
                                                    <input class="span8 required" id="customer_name" name="name" placeholder="Customer Name" type="text" readonly="readonly" value="<?php loader_display($name)?>" />
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
                                                    <input class="span8 required numeric_5" id="customer_rating" name="customer_rating" placeholder="Customer Rating" type="text"  value="<?php loader_display($customer_rating)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Driver Feedback</label>
                                                    <input class="span8 required" name="driver_feedback" Placeholder="Driver Feedback" type="text"  value="<?php loader_display($driver_feedback)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Type</label>
                                                    <div class="span8 controls">   
                                                        <select class="required" id="journey_type" name="journey_type">
                                                            <option <?php if("roundtrip" == $journey_type){?> selected="selected" <?php }?> value="roundtrip" >Roundtrip</option>
                                                            <option <?php if("oneway" == $journey_type){?> selected="selected" <?php }?> value="oneway" >Oneway</option>
															<option <?php if("outstation" == $journey_type){?> selected="selected" <?php }?> value="outstation" >Outstation</option>
                                                        </select>
                                                    </div> 
                                                </div>
                                           </div>
                                             <div class="span6">
                                               <div class="row-fluid">
                                                <label class="form-label span4" for="normal">City</label>
                                                 <div class="span8 controls">   
                                              	   <?php get_citylist();?>
                                                </div> 
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid" id="short_trip">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Start DateTime</label>
                                                    <input class="span8 required datetime" id="booking_start_datetime" name="booking_start_datetime" placeholder="Booking Start Datetime" type="text" value="<?php loader_display($booking_start_datetime)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey End DateTime</label>
                                                    <input class="span8 required datetime" id="booking_end_datetime" name="booking_end_datetime" placeholder="Booking End Datetime" type="text" value="<?php loader_display($booking_end_datetime)?>" />
                                                </div>
                                             </div>
                                        </div>
                                           <div class="form-row row-fluid" id="long_trip" style="display:none">
                                                <div class="span6">
                                                        <div class="row-fluid">
                                                            <label class="form-label span4" for="normal">Total Days</label>
                                                            <input class="span8 required numeric" id="total_day" name="total_day" placeholder="Total Day" type="text" value="<?php loader_display($total_day)?>" />
                                                        </div>                              
                                                    </div>
                                                <div class="span6">
                                                      <div class="row-fluid">
                                                        <label class="form-label span4" for="normal">Total Hour</label>
                                                        <div class="span8 controls">   
                                                            <select name="total_hour">
                                                                <option value="" >Please Select</option>
                                                                <option value="12" >12 Hour</option>
                                                            </select>
                                                        </div> 
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                          <?php loader_set_session('form_session',rand(10,10000));?>
               							  <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" style="display:none" />
   										<div class="form-actions">
                                           <button type="submit" class="btn btn-info">Genereate Bill</button>
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
<script type="text/javascript">
$(function() {
    $("#journey_type").change(function() {
        var journye_type =  $('option:selected', this).text();
		//alert(journye_type);
		if("Outstation" == journye_type){
		   $('#long_trip').show();
		   $('#short_trip').hide();
		}else{
			$('#long_trip').hide();
			$('#short_trip').show();
		}
    });
});
</script>
<?php
}else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>      