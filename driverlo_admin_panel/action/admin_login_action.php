<?php
$user_name = $password =$error_message = $success_message = "";
if(loader_post_isset('username')){
	
	$user_name = loader_get_post_escape('username');
	$password = loader_get_post_escape('password');
	if(("" == $user_name)||("" == $password)){
       $error_message = SERVER_ERROR;	
	}else{
		 $query_login = "select user_name, level from view_admin where user_name = '".$user_name."' and password = '".$password."' ";
		 //echo $query_login;
		 if($result=loader_query($query_login)){
		 	if(loader_num_rows($result)>0){
				$row = loader_fetch_assoc($result);
				loader_set_session("user_name", $row['user_name']);
				//loader_set_session("level", $row['level']);
		  ?>
				<script type="text/javascript">
					 window.location='<?php loader_display(ROOT_PATH.'dashboard'); ?>';
				</script>
		 <?php 
			}else{
				$error_message = LOGIN_FAILED;
			}
		 }else{
		 	$error_message = SERVER_ERROR;
		 }
	}
}
?>