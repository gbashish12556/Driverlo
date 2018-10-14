<?php
//phpinfo();
//header('Access-Control-Allow-Origin: *');
//ini_set('display_errors', 0);
//ini_set('log_errors', 0);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(1);
include_once('includes/config.php');
include_once('includes/db.php');
include_once('includes/loader_function.php');
include_once('includes/message.php');
include_once('includes/mailTemplate.php');
$page = $case = $ajax = "";
if(isset($_REQUEST['page']))
{
	//echo "pageset";
    $page = $_REQUEST['page'];
}
if(isset($_REQUEST['case']))
{
	//echo "caseset";
    $case = $_REQUEST['case'];
}

if($page == "")
{
	$page = "home";
}

include("pages/".$page.".php");
?>
