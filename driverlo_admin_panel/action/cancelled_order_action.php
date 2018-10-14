<?php
$search_type = $search_value = $where =  $new_order_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("mobile_no" == $search_type){
			$where = "WHERE mobile_no LIKE '%".$search_value."%' AND is_cancelled = '1' ";
		}elseif("brn_no" == $search_type){
			$where = "WHERE brn_no LIKE '%".$search_value."%' AND is_cancelled = '1' ";
		}
	}else{
		$where =  "WHERE is_cancelled = '1' ";
	}
	$query = "SELECT brn_no FROM view_booking_detail ".$where." AND is_cancelled = '1' ";
	//standin_file_put_content('query_data', $query);
	$query_result = loader_query($query);
	if(!$query_result)
	{
	    $error_message = SERVER_ERROR;
	}
	else
	{
		 $row = loader_num_rows($query_result);
		 $total_row = $row;
		 if("" == $case) 
	     {
			$error_message = "" ;
			$rec_page = REC_PAGE;
			if (loader_post_isset('new_page_pag')) 
			{
				$pageno  = loader_get_post_escape('new_page_pag'); 
			}
			else
			{
				  $pageno=1; 
			}
			$total_pages = ceil($row/ $rec_page);
			 for($i = 1; $i <= $total_pages; $i++) 
			{

				$pagination .=  '<a tabindex="0" var_pageno='.$i.' class="paginate_button">'.$i.'</a>';
			}
			$start_from = ($pageno-1)*$rec_page;
			//$member_id = standin_get_session(VARIABLE_PREFIX."member_id");
			if("" != $search_value)
			{
				if("mobile_no" == $search_type){
					$where = "WHERE mobile_no LIKE '%".$search_value."%' AND is_cancelled = '1' ORDER BY brn_no DESC LIMIT ".$start_from .",".$rec_page." ";
				}elseif("brn_no" == $search_type){
					$where = "WHERE brn_no LIKE '%".$search_value."%' AND is_cancelled = '1' ORDER BY brn_no DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "WHERE is_cancelled = '1' ORDER BY brn_no DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT brn_no, mobile_no, customer_name, booking_datetime, pickup_point, booking_ai_id FROM view_booking_detail ".$where." ";
			$result = loader_query($query_job_listing);
			if($result)
			{
				    $franchise_list = "";
					$job_posted = array();
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$brn_no = $rowdata['brn_no'];
							$mobile_no = $rowdata['mobile_no'];
							$customer_name = $rowdata['customer_name'];
							$pickup_point = $rowdata['pickup_point'];
							$booking_datetime = getConvertedDatetime($rowdata['booking_datetime']);
							$booking_ai_id = $rowdata['booking_ai_id'];
							$new_order_list .=   '<tr>
                                            <td>'.$brn_no.'</td>
											<td>'.$customer_name.'</td>
                                            <td>'.$mobile_no.'</td>
											<td>'.$pickup_point.'</td>
                                            <td>'.$booking_datetime.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_cancelled_order/'.$booking_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_order/'.$booking_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				  }
			  }
		}
	}  


?>