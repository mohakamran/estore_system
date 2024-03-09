<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $empID = $_POST['empID'];
  $attendanceDate = $_POST['attendanceDate'];
  $attendanceID = $_POST['attendanceID'];
  $inTime = $_POST['inTime'];
  $outTime  = $_POST['outTime'];

  include_once 'connection.php';

  if($attendanceID != '-1'){
    $duration = (strtotime($outTime) - strtotime($inTime))/(3600);
    $sql = "UPDATE attendance SET inTime='$inTime', outTime='$outTime', duration = '$duration' WHERE id = '$attendanceID'";

    if ($con->query($sql)){
    echo "success";
    }else{
      echo mysqli_error($con);
    }
  }else{
    $duration = (strtotime($outTime) - strtotime($inTime))/(3600);
    $sql = "INSERT INTO attendance (empID, inTime, outTime, duration, attendanceDate, status)
    VALUES ('$empID', '$inTime', '$outTime', '$duration', '$attendanceDate', '1' )";

    if ($con->query($sql)){
      echo "success";
    }else{
      echo mysqli_error($con);
    }
  }



}
else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
</script>
<?php
}
?>
