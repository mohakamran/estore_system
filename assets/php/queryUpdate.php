<?php
session_start();
if ($_SESSION['username'] != '') {

  include_once 'connection.php';

  $response = "failed";

  $queryID = $_POST['queryID'];
  $customerName = $_POST['customerName'];
  $customerContact = $_POST['customerContact'];
  $customerEmail = $_POST['customerEmail'];
  $queryDate = $_POST['queryDate'];
  $queryStatus = $_POST['queryStatus'];
  $queryDescription = $con->real_escape_string($_POST['queryDescription']);

  if ($_SESSION["userType"] == "0") {
    $sql = "UPDATE query SET customerName = '$customerName', customerContact = '$customerContact', customerEmail = '$customerEmail', queryDate = '$queryDate', queryStatus = '$queryStatus', queryDescription = '$queryDescription' WHERE id = '$queryID'";
  } else {
    $sql = "UPDATE query SET customerName = '$customerName', queryDate = '$queryDate', queryStatus = '$queryStatus', queryDescription = '$queryDescription' WHERE id = '$queryID'";
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