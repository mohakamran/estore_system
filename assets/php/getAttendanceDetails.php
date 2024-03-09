<?php

$response = array();
$index = 0;
$empID = $_POST['empID'];
$attendanceDate = $_POST['attendanceDate'];


include('connection.php');

$result= mysqli_query($con, " SELECT * FROM attendance WHERE attendanceDate ='$attendanceDate' AND empID = '$empID'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $attendance = (object) array();

    $attendance->id = $row['id'];
    $attendance->inTime = $row['inTime'];
    $attendance->outTime = $row['outTime'];
    $attendance->status = $row['status'];

    $response[$index] = $attendance;
    $index++;

    unset($attendance);
  }
}

echo json_encode($response);
exit();

?>
