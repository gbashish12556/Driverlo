<?php
$search_type = $search_value = $where =  $customer_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("name" == $search_type){
			$where = "WHERE name LIKE '%".$search_value."%' ";
		}elseif("email" == $search_type){
			$where = "WHERE email LIKE '%".$search_value."%' ";
		}elseif("mobile_no" == $search_type){
			$where = "WHERE mobile_no LIKE '%".$search_value."%' ";
		}
	}
	$query = "SELECT name FROM view_customer_info ".$where." ";
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
				if("name" == $search_type){
					$where = "WHERE name LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}elseif("email" == $search_type){
					$where = "WHERE email LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}elseif("mobile_no" == $search_type){
					$where = "WHERE mobile_no LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "ORDER BY name DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT name, email, mobile_no, customer_ai_id FROM view_customer_info ".$where." ";
			$result = loader_query($query_job_listing);
			if($result)
			{
				    $customer_list = "";
					$job_posted = array();
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$name = $rowdata['name'];
							$email = $rowdata['email'];
							$mobile_no = $rowdata['mobile_no'];
							$customer_ai_id = $rowdata['customer_ai_id'];
							$customer_list .=   '<tr>
                                            <td>'.$i.'</td>
                                            <td>'.$name.'</td>
                                            <td>'.$email.'</td>
                                            <td>'.$mobile_no.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_customer/'.$customer_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_customer/'.$customer_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				  }
			  }
		}
	}  


?>