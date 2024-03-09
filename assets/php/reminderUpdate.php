<?php
session_start();
if ($_SESSION['username'] != '') {

  include_once 'connection.php';

  $response = "failed";
  $reminderDate = $_POST['reminderDate'];
  $reminderTime = $_POST['reminderTime'];
  $customerName = $con->real_escape_string($_POST['customerName']);
  $customerContact = $con->real_escape_string($_POST['customerContact']);
  $customerEmail = $con->real_escape_string($_POST['customerEmail']);
  $reminderDescription = $con->real_escape_string($_POST['reminderDescription']);
  $reminderID = $_POST['reminderID'];

  if ($_SESSION["userType"] == "0") {
    $sql = "UPDATE reminder SET reminderDate = '$reminderDate', reminderTime = '$reminderTime', customerName = '$customerName', customerContact = '$customerContact', customerEmail = '$customerEmail', reminderDescription = '$reminderDescription' WHERE id = '$reminderID'";
  } else {
    $sql = "UPDATE reminder SET reminderDate = '$reminderDate', reminderTime = '$reminderTime', customerName = '$customerName', reminderDescription = '$reminderDescription' WHERE id = '$reminderID'";
  }

  if ($con->query($sql)) {
    $response = "success";
  } else {
    $response = mysqli_error($con);
  }

  echo $response;
} else {
?>
  <script>
    window.open('../php/logout.php', '_self')
  </script>
<?php
}
?>