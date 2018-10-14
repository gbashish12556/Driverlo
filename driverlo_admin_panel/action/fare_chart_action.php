<?php
$search_type = $search_value = $where =  $fare_chart_list = $pagination = $total_row = "";
if(loader_post_isset('search_type')){
	$search_type = loader_get_post_escape('search_type');
	$search_value = loader_get_post_escape('search_value');

}
	if(("" != $search_value))
	{
		if("city_name" == $search_type){
			$where = "WHERE city_name LIKE '%".$search_value."%' ";
		}
	}
	$query = "SELECT city_name FROM view_fare_chart ".$where." ";
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
				if("city_name" == $search_type){
					$where = "WHERE city_name LIKE '%".$search_value."%' ORDER BY city_name DESC LIMIT ".$start_from .",".$rec_page." ";
				}
			}
			else
			{
				$where = "ORDER BY city_name DESC LIMIT ".$start_from .",".$rec_page."  ";
			}
		    $query_job_listing = "SELECT city_name,base_fare, fare, outstation_base_fare, outstation_fare,return_charge, night_charge, city_id FROM view_fare_chart ".$where." ";
			$result = loader_query($query_job_listing);
			if($result)
			{
				    $franchise_list = "";
					$job_posted = array();
					$i=1;
					while($rowdata = loader_fetch_assoc($result))
					{
							$city_name = $rowdata['city_name'];
							$base_fare = $rowdata['base_fare'];
							$fare = $rowdata['fare'];
							$outstation_base_fare = $rowdata['outstation_base_fare'];
							$outstation_fare= $rowdata['outstation_fare'];
							$return_charge = $rowdata['return_charge'];
							$night_charge = $rowdata['night_charge'];
							$city_id = $rowdata['city_id'];
							$fare_chart_list .=   '<tr>
                                            <td>'.$i.'</td>
                                            <td>'.$city_name.'</td>
                                            <td>'.$base_fare.'</td>
                                            <td>'.$fare.'</td>
											<td>'.$outstation_base_fare.'</td>
											<td>'.$outstation_fare.'</td>
                                            <td>'.$return_charge.'</td>
                                            <td>'.$night_charge.'</td>
                                            <td>
                                                <div class="controls center">
                                                    <a href="'.ROOT_PATH.'edit_fare_chart/'.$city_id.'"  class="tip"><span class="icon12 icomoon-icon-pencil"></span></a>
                                                    <a href="'.ROOT_PATH.'delete_fare_chart/'.$city_id.'"  class="tip"><span class="icon12 icomoon-icon-remove"></span></a>
                                                </div>
                                            </td>
                                          </tr>';
						 $i++;				  
				  }
			  }
		}
	}  


?>