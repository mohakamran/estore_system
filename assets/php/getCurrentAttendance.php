<?php
session_start();
$empID = $_SESSION['id'];

date_default_timezone_set('GMT');
$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
$currentHour = date('H');


include_once 'connection.php';

$result= mysqli_query($con, " SELECT * FROM attendance WHERE empID = '$empID' AND attendanceDate = '$currentDate'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){
    if($row['status'] == 0){
      echo '<table style="width: 100%;">
      <tr style="width: 100%;">
      <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; In-Time:</td>
      <td style="width: 0;">'.$row['inTime'].'</td>
      <td style="position: relative; float: right;"></td>
      </tr>
      <tr style="height: 20px;"> <!-- Mimic the margin -->
      </tr>
      <tr style="width: 100%;">
      <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; Out-Time:</td>
      <td style="width: 0;"></td>
      <td style="position: relative; float: right;">
      <button class="btn btn-primary" name="button" onclick="markAttendance();">MARK</button>
      </td>
      </tr>
      </table><br><br>

      <span><span style="color: #CC0000;"><i class="fas fa-exclamation-circle"></i>&nbsp;</span>Attendance not marked for today!</span><br><br>';
    }else{
      echo '<table style="width: 100%;">
      <tr style="width: 100%;">
      <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; In-Time:</td>
      <td style="width: 0;">'.$row['inTime'].'</td>
      <td style="position: relative; float: right;"></td>
      </tr>
      <tr style="height: 20px;"> <!-- Mimic the margin -->
      </tr>
      <tr style="width: 100%;">
      <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; Out-Time:</td>
      <td style="width: 0;">'.$row['outTime'].'</td>
      <td style="position: relative; float: right;">
      </td>
      </tr>
      </table><br><br>

      <span><span style="color: #00C851;"><i class="fas fa-exclamation-circle"></i>&nbsp;</span>Attendance marked for today!</span><br><br>';
    }
  }
}else{
  echo '<table style="width: 100%;">
  <tr style="width: 100%;">
  <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; In-Time:</td>
  <td style="width: 0;"></td>
  <td style="position: relative; float: right;">
  <button class="btn btn-primary" name="button" onclick="markAttendance();">MARK</button>
  </td>
  </tr>
  <tr style="height: 20px;"> <!-- Mimic the margin -->
  </tr>
  <tr style="width: 100%;">
  <td style="width: 30%;"><i class="far fa-clock"></i> &nbsp; Out-Time:</td>
  <td style="width: 0;">In-Time not marked!</td>
  <td style="position: relative; float: right;"></td>
  </tr>
  </table><br><br>

  <span><span style="color: #CC0000;"><i class="fas fa-exclamation-circle"></i>&nbsp;</span>Attendance not marked for today!</span><br><br>';
}


?>
