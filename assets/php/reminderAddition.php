<?php
session_start();
if($_SESSION['username'] != ''){

  include_once 'connection.php';

  $response = "failed";

  $reminderDate = $_POST['reminderDate'];
  $reminderTime = $_POST['reminderTime'];
  $customerName = $con -> real_escape_string($_POST['customerName']);
  $customerContact = $con -> real_escape_string($_POST['customerContact']);
  $customerEmail = $con -> real_escape_string($_POST['customerEmail']);
  $reminderDescription = $con -> real_escape_string($_POST['reminderDescription']);
  $employeeID = $_SESSION['id'];


  $sql = "INSERT INTO reminder (employeeID, reminderDate, reminderTime, customerName, customerContact, customerEmail, reminderDescription)
  VALUES ('$employeeID', '$reminderDate', '$reminderTime', '$customerName', '$customerContact', '$customerEmail', '$reminderDescription')";

  if ($con->query($sql)){
    $response = "success";
  }else {
    $response = mysqli_error($con);
  }

  echo $response;

}
else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
</script>
<?php
}
?>
