<?php
$search_type = $search_value = $where =  $franchise_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("mobile_no" == $search_type){
			$where = "WHERE mobile_no LIKE '%".$search_value."%' ";
		}
	}
	$query = "SELECT name FROM view_franchise_info ".$where." ";
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
				if("mobile_no" == $search_type){
					$where = "WHERE mobile_no LIKE '%".$search_value."%' ORDER BY name DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "ORDER BY name DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT name,mobile_no, location, rating, franchise_ai_id FROM view_franchise_info ".$where." ";
			$result = loader_query($query_job_listing);
			if($result)
			{
				if(loader_num_rows($result)>0)
				{
				    $franchise_list = "";
					$job_posted = array();
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$job_posted[] = $rowdata;
							$name = $rowdata['name'];
							$location = $rowdata['location'];
							$mobile_no = $rowdata['mobile_no'];
							$rating = $rowdata['rating'];
							$franchise_ai_id = $rowdata['franchise_ai_id'];
							$franchise_list .=   '<tr>
                                            <td>'.($start_from+$i).'</td>
                                            <td>'.$name.'</td>
                                            <td>'.$location.'</td>
                                            <td>'.$mobile_no.'</td>
											<td>'.$rating.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_franchise/'.$franchise_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_franchise/'.$franchise_ai_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				   }
				}else{
					$success_message = NO_MATCH_FOUND;
				}
			  }
		}
	}  


?>