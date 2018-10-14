<?php
$search_type = $search_value = $where =  $driver_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("license_no" == $search_type){
			$where = "WHERE license_no LIKE '%".$search_value."%' ";
		}elseif("driver_name" == $search_type){
			$where = "WHERE name LIKE '%".$search_value."%' ";
		}
	}
	$query = "SELECT name FROM view_driver_info ".$where." ";
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
				if("license_no" == $search_type){
					$where = "WHERE license_no LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}elseif("driver_name" == $search_type){
					$where = "WHERE name LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "ORDER BY name DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT name, license_no, rating, driver_ai_id FROM view_driver_info ".$where." ";
			echo $query_job_listing;
			if($result = loader_query($query_job_listing))
			{
				if(loader_num_rows($result)>0)
				{
				    $driver_list = "";
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$name = $rowdata['name'];
							$license_no = $rowdata['license_no'];
							$rating = $rowdata['rating'];
							$driver_ai_id = $rowdata['driver_ai_id'];
							$driver_list .=   '<tr>
                                            <td>'.($start_from+$i).'</td>
                                            <td>'.$name.'</td>
                                            <td>'.$license_no.'</td>
											<td>'.$rating.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_driver/'.$driver_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_driver/'.$driver_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				     }
				}else{
					$success_message = NO_MATCH_FOUND;
				}
			  }else{
			  	$error_message = SERVER_ERROR;
			  }
		}
	}  


?>