<?php
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_DATABASE);
// Check connection
if (mysqli_connect_errno())
  {
   echo $error_message =  "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>