<?php
$search_type = $search_value = $where =  $franchise_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("coupon_code" == $search_type){
			$where = "WHERE coupon_code LIKE '%".$search_value."%' ";
		}
	}
	$query = "SELECT coupon_code FROM view_coupon_discount ".$where." ";
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
			if (loader_get_post('new_page_pag')) 
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
				if("coupon_code" == $search_type){
					$where = "WHERE coupon_code LIKE '%".$search_value."%' ORDER BY coupon_code DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "ORDER BY coupon_code DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT coupon_code, coupon_discount, is_referal, coupon_id FROM view_coupon_discount ".$where." ";
			$result = loader_query($query_job_listing);
			if($result)
			{
				    $coupon_discount_list = "";
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$coupon_code = $rowdata['coupon_code'];
							$coupon_discount = $rowdata['coupon_discount'];
							$is_referal = $rowdata['is_referal'];
							$coupon_id = $rowdata['coupon_id'];
							$coupon_discount_list .=   '<tr>
                                            <td>'.$i.'</td>
                                            <td>'.$coupon_code.'</td>
                                            <td>'.$coupon_discount.'</td>
                                            <td>'.$is_referal.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_coupon_discount/'.$coupon_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_coupon_discount/'.$coupon_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				  }
			  }
		}
	}  


?>