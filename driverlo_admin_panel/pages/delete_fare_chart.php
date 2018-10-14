<?php 
if(loader_session_isset('user_name')){ include_once(ACTION_PATH.'delete_fare_chart_action.php')?>
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
                <h3>Delete Fare Chart</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Delete Fare Chart</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="delete_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH.'delete_fare_chart')?>"   >
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">City</label>
                                                    <input class="span8 required" id="city_name" name="city_name" placeholder="City Name" type="text" readonly="readonly" value="<?php loader_display($city_name)?>" />
                                                    <input type="text" name="id" value="<?php loader_display($id)?>" style="display:none" />

                                                </div>
                                            </div>
                                             <div class="span6">
                                                
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Base Fare(in Rs.)</label>
                                                    <input class="span8 required numeric" name="base_fare" Placeholder="base_fare" type="text" readonly="readonly" value="<?php loader_display($base_fare)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Fare(Rs. /min)</label>
                                                    <input class="span8 required numeric" name="fare" Placeholder="fare" type="text" readonly="readonly" value="<?php loader_display($fare)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Night Charge(in Rs.)</label>
                                                    <input class="span8 required numeric" name="night_charge" Placeholder="Night charge" type="text" readonly="readonly" value="<?php loader_display($night_charge)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Return Charge(Rs.)</label>
                                                    <input class="span8 required numeric" name="return_charge" Placeholder="Retun Charge" type="text"  readonly="readonly" value="<?php loader_display($return_charge)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Outstation Base Fare(in Rs.)</label>
                                                    <input class="span8 required numeric" name="outstation_base_fare" Placeholder="Outstation Base Fare" type="text" readonly="readonly" value="<?php loader_display($outstation_base_fare)?>" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Outstation Fare(Rs. /min)</label>
                                                    <input class="span8 required numeric" name="outstation_fare" Placeholder="Outstation Fare" type="text" readonly="readonly" value="<?php loader_display($outstation_fare)?>" />
                                                </div>
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

<?php
}else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>      