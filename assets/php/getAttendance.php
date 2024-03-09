<?php

$empID = $_POST['empID'];

$response = array();
$index = 0;

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM attendance WHERE empID = '$empID' AND status = '1'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $attendance = (object) array();
    $attendance->date = $row['attendanceDate'];
    $attendance->duration = $row['duration'];

    $response[$index] = $attendance;
    $index++;

    unset($attendance);
  }
}


echo json_encode($response);
exit();

?>
