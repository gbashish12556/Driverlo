<?php 
if(loader_session_isset('user_name')){ include_once(ACTION_PATH.'delete_order_action.php')?>
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
                <h3>Delete Order</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Delete Order</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="delete_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH.'delete_order')?>"  >
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Pickup Location</label>
                                                    <input class="span8 required" id="pickup_point" name="pickup_point" placeholder="Pickup Location" type="text" readonly="readonly"value="<?php loader_display($pickup_point)?>" />
                                                    <input type="text" name="id" value="<?php loader_display($id)?>" style="display:none" />
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
                                                    <label class="form-label span4" for="normal">Booking DateTime</label>
                                                    <input class="span8 required datetime" id="booking_datetime" name="booking_datetime" placeholder="Booking Datetime" type="text" readonly="readonly" value="<?php loader_display($booking_datetime)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Journey Type</label>
                                                    <div class="span8 controls">   
                                                        <select class="required" name="journey_type" readonly="readonly" >
                                                            <option <?php if("roundtrip" == $journey_type){?> selected="selected" <?php } ?> value="roundtrip" >Roundtrip</option>
                                                            <option <?php if("oneway" == $journey_type){?> selected="selected" <?php } ?>  value="oneway" >Oneway</option>
															<option <?php if("outstation" == $journey_type){?> selected="selected" <?php } ?>  value="outstation" >Outstation</option>
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
                                                        <select class="required" name="vehicle_type" readonly="readonly" >
                                                            <option <?php if("hatchback" == $vehicle_type){?> selected="selected" <?php } ?> value="hatchback" >Hatchback</option>
                                                            <option <?php if("sedan" == $vehicle_type){?> selected="selected" <?php } ?>  value="sedan" >Sedan</option>
															<option <?php if("suv" == $vehicle_type){?> selected="selected" <?php } ?> value="suv" >Suv</option>
                                                            <option <?php if("luxary" == $vehicle_type){?> selected="selected" <?php } ?> value="luxary" >Luxary</option>
                                                        </select>
                                                    </div> 
                                           </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                 <label class="form-label span4" for="normal">Vehicle Mode</label>
                                                 <div class="span8 controls">   
                                                        <select class="required" name="vehicle_mode" readonly="readonly" >
                                                            <option <?php if("manual" == $vehicle_mode){?> selected="selected" <?php } ?> value="manual" >Manual</option>
                                                            <option <?php if("automatic" == $vehicle_mode){?> selected="selected" <?php } ?> value="automatic" >Automatic</option>
														</select>
                                                    </div> 
												 </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Estimate Usage</label>
                                                    <input class="span8 required" id="estimate_time" name="estimate_time" placeholder="Estimate Usage" type="text" readonly="readonly" value="<?php loader_display($estimated_time)?>" />
                                                </div>                                            </div>
                                             <div class="span6">
                                             </div>
                                        </div>     
                                                                                                                                                                                                     					      <?php loader_set_session('form_session',rand(10,10000));?>
               							  <input type="text" name="session" id="session" value="<?php loader_display(loader_get_session('form_session'));?>" style="display:none" />

   										<div class="form-actions">
                                           <button type="submit" class="btn btn-info">Delete</button>
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
 <?php       }else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>    