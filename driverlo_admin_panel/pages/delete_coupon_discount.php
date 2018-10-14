<?php 
if(loader_session_isset('user_name')){  include_once(ACTION_PATH.'delete_coupon_discount_action.php')?>
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
                <h3>Create Coupon</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Create Coupon</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content">
                                    <form id="delete_form" method="post" class="form-horizontal" action="<?php loader_display(ROOT_PATH.'delete_coupon_discount')?>"   >
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Coupon Code</label>
                                                    <input class="span8 required" id="coupon_code" name="coupon_code" placeholder="Coupon Code" type="text" readonly="readonly" value="<?php loader_display($coupon_code)?>" />
                                                    <input type="text" name="id" value="<?php loader_display($id)?>" style="display:none" />
                                                </div>
                                            </div>
                                             <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Discount</label>
                                                    <input class="span8 required numeric" name="coupon_discount" Placeholder="coupon_discount" type="text" readonly="readonly" value="<?php loader_display($coupon_discount)?>" />
                                                </div>
                                             </div>
                                        </div>
                                        <div class="form-row row-fluid">
                                            <div class="span6">
                                                <div class="row-fluid">
                                                    <label class="form-label span4" for="normal">Is Referal ?</label>
                                                    <div class="span8 controls">   
                                                        <select class="required" name="is_referal" readonly="readonly" >
                                                            <option <?php if("1" == $is_referal){?> selected="selected" <?php } ?> value="1" >Yes</option>
                                                            <option <?php if("0" == $is_referal){?> selected="selected" <?php } ?>  value="0" >No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
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

<?php
}else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>      