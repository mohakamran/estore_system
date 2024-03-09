<?php
session_start();
$empID = $_SESSION['id'];

date_default_timezone_set('GMT');
$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$currentHour = date('H');

//In Time
include_once 'connection.php';

$result= mysqli_query($con, " SELECT * FROM attendance WHERE empID = '$empID' AND attendanceDate = '$currentDate'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){
    $attendanceID = $row['id'];
    $duration = (strtotime($currentTime) - strtotime($row['inTime']))/(3600);
    $sql = "UPDATE attendance SET outTime = '$currentTime', duration = '$duration', status = '1'  WHERE id = '$attendanceID'";
    if ($con->query($sql)){
      echo "success";
    }else{
      echo mysqli_error($con);
    }
  }
}else{
  $sql = "INSERT INTO attendance (empID, inTime, attendanceDate)
  VALUES ('$empID', '$currentTime', '$currentDate')";
  if ($con->query($sql)){
    echo "success";
  }else{
    echo mysqli_error($con);
  }
}


?>
