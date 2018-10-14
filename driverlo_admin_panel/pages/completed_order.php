<?php 
if(loader_session_isset('user_name')){  include_once(ACTION_PATH.'completed_order_action.php')?>
<script type="text/javascript">
  function LoadDropdown() {
		var search_index = document.getElementById("search_type");
		var search_type = search_index.options[search_index.selectedIndex].text;
		//var search_type =  $('option:selected', this).text();
		//alert(search_type);
		if("Booking Datetime" == search_type){
		   $('#booking_datetime').show();
		   $('#search_value').hide();
		}else{
			$('#booking_datetime').hide();
			$('#search_value').show();
		}
  }
  window.onload = LoadDropdown;
jQuery(function(){
	jQuery('#booking_start_datetime').datetimepicker({
		format:'d/m/Y h:i a',
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
	jQuery('#booking_end_datetime').datetimepicker({
		format:'d/m/Y h:i a',
		maxDate:'+1970/01/01',
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
                <h3>Completed Orders</h3>                                   
            </div><!-- End .heading-->
            <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
            <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="title">
                                <h4>
                                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                                    <span>Completed Order Table</span>
                                </h4>
                                <a href="#" class="minimize">Minimize</a>
                            </div>
                            <div class="content noPad clearfix">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                      <div style="padding-left:10px" >
                                            <form id="search_form" action="<?php loader_display(ROOT_PATH."completed_order")?>" method="POST" >
                                               <div class="form-row row-fluid">
                                                    <div class="span12">
                                                       <div class="span2">
                                                            <select class="required" id="search_type" name="search_type" >
                                                                <option value="" >Search By</option>
                                                                <option <?php if("mobile_no" == $search_type){?> selected="selected" <?php } ?> value="mobile_no" >Mobile No</option>
                                                                <option <?php if("brn_no" == $search_type){?> selected="selected" <?php } ?> value="brn_no" >BRN No</option>
                                                                <option <?php if("franchise_name" == $search_type){?> selected="selected" <?php } ?> value="franchise_name" >Franchise</option>

                                                                <option <?php if("booking_datetime" == $search_type){?> selected="selected" <?php } ?> value="booking_datetime" >Booking Datetime</option>
                                                            </select>
                                                        </div>
                                                        <div class="span2" id="search_value">
                                                            <input class="form-control required" id="search"  name="search_value" aria-controls="DataTables_Table_0" type="text" placeholder="Enter Value" value="<?php loader_display($search_value)?>" />
                                                        </div>
                                                        <div class="span4" id="booking_datetime" style="display:none">  
                                                        <div class="span6">                                                          
                                 							<input class="form-control required datetime" type="text" id="booking_start_datetime" name="booking_start_datetime" placeholder="Booking Start Datetime"  value="<?php loader_display($booking_start_datetime)?>">
                                                        </div>
                                                        <div class="span6">    
                                							 <input class="form-control required datetime" type="text" id="booking_end_datetime" name="booking_end_datetime" placeholder="Booking End Datetime"  value="<?php loader_display($booking_end_datetime)?>">
                                                         </div>    
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
                                            <th>BRN No</th>
                                            <th>Customer Name</th>
                                            <th>Mobile No</th>
                                            <th>Pickup Point</th>
                                            <th>Booking Datettime</th>
                                            <th>Driver Name</th>
                                            <th>Franchise Name</th>
                                            <th>Actions</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php loader_display($new_order_list)?>
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

<script type="text/javascript">

	$(function() {
		$("#search_type").change(function() {
			var search_type =  $('option:selected', this).text();
			//alert(search_type);
			if("Booking Datetime" == search_type){
			   $('#booking_datetime').show();
			   $('#search_value').hide();
			}else{
				$('#booking_datetime').hide();
				$('#search_value').show();
			}
		});
	});

</script>
        <form id="page_form" action="<?php loader_display(ROOT_PATH."completed_order") ?>" method="POST" style="display:none" >
            <input id="new_page_pag"  name="new_page_pag" onChange="$("#page_form").submit();" type="hidden" value="">
            <input type="text" name="search_type" value="<?php loader_display($search_type)?>">
            <input type="text" name="search_value" value="<?php loader_display($search_value)?>">
            <input type="text" name="booking_start_datetime" value="<?php loader_display($booking_start_datetime)?>">
            <input type="text" name="booking_end_datetime" value="<?php loader_display($booking_end_datetime)?>">
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

