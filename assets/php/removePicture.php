<?php
session_start();

$empID = $_POST['employeeID'];

include_once 'connection.php';

$sql = "UPDATE user SET profilePicture=null WHERE id = '$empID'";

if ($con->query($sql)){
  $_SESSION['profilePicture'] = null;
  echo "success";
}else{
  echo mysqli_error($con);
}
