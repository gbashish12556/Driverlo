<?php 
if(loader_session_isset('user_name')){
 include_once(ACTION_PATH.'create_fare_chart_action.php');?>
<script>
function initializ1() {
	var input = document.getElementById('city_name');
	var autocomplete = new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function () {
		var place = autocomplete.getPlace();
		document.getElementById('city_lat').value = place.geometry.location.lat();
		document.getElementById('city_lng').value = place.geometry.location.lng();
	});
}
google.maps.event.addDomListener(window, 'load', initializ1);
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
                <h3>Create Fare Chart</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Create Fare Chart</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="create_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH.'create_fare_chart')?>"  >
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">City</label>
                                                    <input class="span8 required" id="city_name" name="city_name" placeholder="City Name" type="text" value="<?php loader_display($city_name)?>" />
                                                    <input class="required" type="text" id="city_lat" name="city_lat" style="display:none" value="<?php loader_display($city_lat)?>" />
                                                    <input  class="required" type="text" id="city_lng" name="city_lng" style="display:none" value="<?php loader_display($city_lng)?>"  />
                                                </div>
                                            </div>
                                             <div class="span6">
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Base Fare(in Rs.)</label>
                                                    <input class="span8 required numeric" name="base_fare" Placeholder="Base Fare" type="text" value="<?php loader_display($base_fare)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Fare(Rs. /min)</label>
                                                    <input class="span8 required numeric" name="fare" Placeholder="fare" type="text" value="<?php loader_display($base_fare)?>"/>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Night Charge(in Rs.)</label>
                                                    <input class="span8 required numeric" name="night_charge" Placeholder="Night charge" type="text" value="<?php loader_display($night_charge)?>"/>
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Return Charge(Rs.)</label>
                                                    <input class="span8 required numeric" name="return_charge" Placeholder="Retun Charge" type="text" value="<?php loader_display($return_charge)?>"/>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Outstation Base Fare(in Rs.)</label>
                                                    <input class="span8 required numeric" name="outstation_base_fare" Placeholder="Outstation Base Fare" type="text" value="<?php loader_display($outstation_base_fare)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Outstation Fare(Rs. /min)</label>
                                                    <input class="span8 required numeric" name="outstation_fare" Placeholder="Outstation Fare" type="text" value="<?php loader_display($outstation_fare)?>" />
                                                </div>
                                             </div>
                                        </div>                                          <?php loader_set_session('form_session',rand(10,10000));?>
               							  <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" style="display:none" />

   										<div class="form-actions">
                                           <button type="submit" class="btn btn-info">Create Fare Chart</button>
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