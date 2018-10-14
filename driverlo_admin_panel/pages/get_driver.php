<?php
	if(loader_post_isset("franchise_id")) 
	{
		$franchise_id = loader_get_post_escape("franchise_id");
		$query ="SELECT name, driver_ai_id from view_driver_info WHERE franchise_id =  '".$franchise_id."' AND is_active = '1' ORDER BY name ASC";
				 //echo $query;
	    ?>
	    <?php
		if($result = loader_query($query))
		{
			    ?>
					<option value="" >Select Driver</option>
				<?php
				while($row = loader_fetch_assoc($result))
				{
					?>
						<option value="<?php loader_display($row["driver_ai_id"]) ?>"><?php loader_display($row["name"]) ?></option>
					<?php
				}
		}
		else
		{
			$error_message = SERVER_ERROR;
		}
	}

?>