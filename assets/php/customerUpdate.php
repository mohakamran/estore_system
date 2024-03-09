<?php
session_start();
if ($_SESSION['username'] != '') {

  $customerID = $_POST['customerID'];
  $Name = $_POST['Name'];
  $ProjectName = $_POST['ProjectName'];
  $Email = $_POST['Email'];
  $StartDate = $_POST['StartDate'];
  $Contact = $_POST['Contact'];
  $CustomerType = $_POST['CustomerType'];

  include_once 'connection.php';

  $sql = "UPDATE customer SET name='$Name', email='$Email', project_name='$ProjectName', project_start_date='$StartDate',
  contact='$Contact', customer_type=$CustomerType WHERE id = '$customerID'";

  if ($con->query($sql)) {
    echo "success";
  } else {
    echo mysqli_error($con);
  }
} else {
?>
  <script>
    window.open('../php/logout.php', '_self')
  </script>
<?php
}
?>