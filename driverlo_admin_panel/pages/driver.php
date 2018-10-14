<?php 
if(loader_session_isset('user_name')){ include_once(ACTION_PATH.'driver_action.php')?>
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
                <h3>Driver Table</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Driver Table</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content noPad clearfix">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                      <div style="padding-left:10px" >
                                            <form id="search_form" action="<?php loader_display(ROOT_PATH."driver")?>" method="POST" >
                                               <div class="form-row row-fluid">
                                                    <div class="span12">
                                                       <div class="span2">
                                                            <select name="search_type" class="form-control required" >
                                                                <option value="" >Search By</option>
                                                                <option <?php if("license_no" == $search_type){?> selected="selected" <?php } ?> value="license_no" >License No</option>
                                                                <option <?php if("driver_name" == $search_type){?> selected="selected" <?php } ?> value="driver_name" >Driver Name</option>
                                                            </select>
                                                        </div>
                                                        <div class="span2">
                                                            <input class="form-control required" id="search"  name="search_value" aria-controls="DataTables_Table_0" type="text" placeholder="Enter Value" value="<?php loader_display($search_value)?>" />
                                                        </div>
                                                        <div class="span1">
                                                            <button type="submit" class="btn">Search</button>
                                                        </div>
                                                        <dic class="span6"></div>
                                                </div>  
                                            </form>
                                       </div>	
                                      <div class="content noPad">
                                        <table class="responsive table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Sl No.</th>
                                            <th>Driver Name</th>
                                            <th>License No</th>
                                            <th>Rating</th>
                                            <th>Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php loader_display($driver_list)?>
                                        </tbody>
                                    </table>
                                        <div class="dataTables_info" id="DataTables_Table_0_info">
                                        Showing <?php loader_display($start_from)?> to <?php if($total_row >= ($start_from+5)){loader_display($start_from+5);}else{loader_display($total_row);}?> of <?php loader_display($total_row)?> entries
                                        </div>
                                        <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                                        <?php if(1!=$pageno){?>
                                                <a tabindex="0"  var_pageno=<?php loader_display( $pageno-1)?>  class="previous paginate_button" id="DataTables_Table_0_previous">Previous</a>
                                                <?php }?>
                                            <span>
                                              <?php loader_display($pagination)?>
                                            </span>
                                          <?php  if($total_pages!=$pageno){?>
                                                <a tabindex="0" var_pageno=<?php loader_display( $pageno+1)?>  class="next paginate_button paginate_button_disabled" id="DataTables_Table_0_next">Next</a>
                                            <?php }?>   
                                         </div>
                                     </div>
                                </div>
                            </div>
                         </div>  <!-- End .box -->
                    </div><!-- End .span12 -->
            	</div><!-- End .row-fluid -->
            <!-- Page end here -->
        </div><!-- End contentwrapper -->
    </div><!-- End Body content -->
</div><!-- End #wrapper -->
        <form id="page_form" action="<?php loader_display(ROOT_PATH."driver") ?>" method="POST" style="display:none" >
            <input id="new_page_pag"  name="new_page_pag" onChange="$("#page_form").submit();" type="hidden" value="">
            <input type="text" name="search_type" value="<?php loader_display($search_type)?>">
            <input type="text" name="search_value" value="<?php loader_display($search_value)?>">
        </form>
        <?php
}else{
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'admin_login'); ?>';
				</script>
		 <?php 
}
?>   