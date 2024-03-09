<?php
session_start();
if ($_SESSION['username'] != '') {

  include_once 'connection.php';

  $response = "failed";

  $employeeID = $_POST['employeeID'];
  $customerName = $_POST['customerName'];
  $customerContact = $_POST['customerContact'];
  $customerEmail = $_POST['customerEmail'];
  $queryDate = $_POST['queryDate'];
  $queryStatus = $_POST['queryStatus'];
  $queryDescription = $con->real_escape_string($_POST['queryDescription']);

  $sql = "INSERT INTO query (employeeID, customerName, customerContact, customerEmail, queryDate, queryStatus, queryDescription)
  VALUES ('$employeeID', '$customerName', '$customerContact', '$customerEmail', '$queryDate', '$queryStatus', '$queryDescription')";

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