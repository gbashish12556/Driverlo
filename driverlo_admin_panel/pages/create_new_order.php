<?php include_once(ACTION_PATH.'create_new_order_action.php');?>
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
	});
}
google.maps.event.addDomListener(window, 'load', initializ2);
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
                <h3>New Orders</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Create New Order</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="create_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH.'create_new_order')?>"  >
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Pickup Location</label>
                                                    <input class="span8 required" id="pickup_point" name="pickup_point" placeholder="Pickup Location" type="text" autocomplete="on" runat="server"  value="<?php loader_display($pickup_point)?>" />
                                                    <input class="required" type="text" id="pickup_lat" name="pickup_lat" style="display:none" value="<?php loader_display($pickup_lat)?>" />
                                                    <input class="required" type="text" id="pickup_lng" name="pickup_lng" style="display:none" value="<?php loader_display($pickup_lng)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Dropoff Location</label>
                                                    <input class="span8 required" id="dropoff_point" name="dropoff_point" placeholder="Dropoff Location" type="text" value="<?php loader_display($dropoff_point)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Customer Name</label>
                                                    <input class="span8 required" id="name" name="name" placeholder="Customer Name" type="text" value="<?php loader_display($name)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Customer Mobile No</label>
                                                    <input class="span8 mask required numeric mobile_no" name="mobile_no" Placeholder="Customer Mobile No" type="text" value="<?php loader_display($mobile_no)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Booking DateTime</label>
                                                    <input class="span8 required datetime" id="booking_datetime" name="booking_datetime" placeholder="Booking Datetime" type="text" value="<?php loader_display($booking_datetime)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Type</label>
                                                    <div class="span8 controls">   
                                                        <select class="required" name="journey_type">
                                                            <option <?php if("roundtrip" == $journey_type){?> selected="selected" <?php }?> value="roundtrip" >Roundtrip</option>
                                                            <option <?php if("oneway" == $journey_type){?> selected="selected" <?php }?>  value="oneway" >Oneway</option>
															<option <?php if("outstation" == $journey_type){?> selected="selected" <?php }?>  value="outstation" >Outstation</option>
                                                        </select>
                                                    </div> 
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Vehicle Type</label>
												     <div class="span8 controls">   
                                                        <select class="required" name="vehicle_type">
                                                            <option <?php if("hatchback" == $vehicle_type){?> selected="selected" <?php }?>  value="hatchback" >Hatchback</option>
                                                            <option <?php if("sedan" == $vehicle_type){?> selected="selected" <?php }?>  value="sedan" >Sedan</option>
															<option <?php if("suv" == $vehicle_type){?> selected="selected" <?php }?>  value="suv" >Suv</option>
                                                            <option <?php if("luxary" == $vehicle_type){?> selected="selected" <?php }?>  value="luxary" >Luxary</option>
                                                        </select>
                                                    </div> 
                                           </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                 <label class="form-label span4" for="normal">Vehicle Mode</label>
                                                 <div class="span8 controls">   
                                                        <select class="required" name="vehicle_mode">
                                                            <option <?php if("manual" == $vehicle_mode){?> selected="selected" <?php }?>  value="manual" >Manual</option>
                                                            <option <?php if("automatic" == $vehicle_mode){?> selected="selected" <?php }?>  value="automatic" >Automatic</option>
														</select>
                                                    </div> 
												 </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Estimated Usage</label>
                                                    <input class="span3 required" id="spinner1" name="hour"  value="<?php loader_display($hour)?>" /><span class="add-on"> Hour </span>
                                                	<input class="span3 required" id="spinner3" name="minute"  value="<?php loader_display($minute)?>" /><span class="add-on"> Minute </span>
                                                </div>
                                            </div>
                                             <div class="span6">
                                                 <label class="form-label span4" for="normal">Coupon Code</label>
                                                 <input class="span8" id="coupon_code" name="coupon_code" placeholder="Coupon Code" type="text" value="<?php loader_display($coupon_code)?>" />
                                             </div>
                                        </div>     
                                        	<?php loader_set_session('form_session',rand(10,10000));?>
               							  <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" style="display:none" />

   										<div class="form-actions">
                                           <button  id="create_order_button" type="submit" class="btn btn-info">Create Order</button>
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
<script>
 $('#create_order_button').click(function(e){
      	    e.preventDefault();
			//alert('Ashish');
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
								$('#create_form').submit();
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
	return dateObject;}
</script>