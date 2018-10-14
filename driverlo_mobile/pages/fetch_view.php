<?php

/*
	 ******  Created by:          Sourav Halder
	 ******  Last Edit Date:      04/05/2016
	 ******  Works Done:          Fetch data from tables and return as json data
*/

loader_file_put_content('includes/logs/post_data','fetch_view',$_REQUEST);
if(loader_post_isset("view_name")&&loader_post_isset("latest_date"))
{
	$userRow = array();
	$error_message = $success_message = $view = $latest_date = "";
	//file_put_contents("post_data/".date('d_m_Y', time())."driver_registration.txt", date('d/m/Y h:i:s a', time())." ".print_r($_REQUEST,true), FILE_APPEND);
	$error_message = $success_message = "";
	$view = loader_get_post_escape("view_name");
	$latest_date = loader_get_post_escape("latest_date");
	$query1 = "SELECT MAX(update_date) FROM ".$view." WHERE is_active = '1'";
	loader_file_put_content('includes/logs/query_data','fetch_view',$query1."\r\n");
	if("" == $view)
	{
		$error_message = MANDATORY_MISSING;
	}
	else
	{
		if(($view != "view_fare_chart"))
		{
			$error_message = WRONG_HAPPEN;
		}
		else
		{
			if(($latest_date=="")||(loader_validateDate($latest_date,"Y-m-d H:i:s")))
			{
				if($result1 = loader_query($query1))
				{
					$row = loader_fetch_assoc($result1);
					if($row["MAX(update_date)"] == $latest_date)
					{
						$success_message = VIEW_IS_UP_TO_DATE;
					}
					else
					{
						$query2 = "SELECT * FROM ".$view." WHERE is_active = '1'";
						loader_file_put_content('includes/logs/query_data','fetch_view',$query2."\r\n");
						if($result2 = loader_query($query2))
						{
							if(0 < loader_num_rows($result2))
							{
								$userRow['likes'] = array();
								$success_message = IS_SUCCESS;
								$i = 0;
								while($row = loader_fetch_assoc($result2))
								{
									//$userRow["likes"][$i]["location_lat"] = $row["location_lat"];
									//$userRow["likes"][$i]["location_lng"] = $row["location_lng"];
									$userRow["likes"][$i]=$row;
									$i++;
								}
							}
							else
							{
								$success_message = IS_SUCCESS;
							}
						}
						else
						{
							$error_message = SERVER_ERRROR;
						}
					}
				}
				else
				{
							$error_message = SERVER_ERROR;
				}
			}
			else
			{
				$error_message = DATETIME_INVALID;
			}


		}
	}

	if($error_message == "")
	{
		$errFlag = "0";			// Success status
		$errMsg = $success_message;
	}
	else
	{
		$errFlag = "1";			// Failure status
		$errMsg = $error_message;
		//$userRow['likes'][0]['isupdated'] = "0";
	}
  	$userRow["errFlag"] = $errFlag."";
  	$userRow["errMsg"] = $errMsg."";

	//$json = array("errFlag" => $errFlag, "errMsg" => $errMsg, "likes" => $noteRow);
	//header('Content-Type: application/json');
	$send_data = json_encode($userRow);
	echo $send_data;
	loader_file_put_content('includes/logs/send_data','fetch_view',$send_data);
}

?>
