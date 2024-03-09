<?php
session_start();
if ($_SESSION['username'] != '') {

  $response = "failed";

  $Name = $_POST['Name'];
  $ProjectName = $_POST['ProjectName'];
  $Email = $_POST['Email'];
  $StartDate = $_POST['StartDate'];
  $Contact = $_POST['Contact'];
  $CustomerType = $_POST['CustomerType'];

  include_once 'connection.php';

  $result = mysqli_query($con, " SELECT * FROM customer WHERE email = '$Email' OR contact = '$Contact'")
    or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
      if ($row['email'] == $Email) {
        $response = "email";
      } else {
        $response = "phone";
      }
    }
  } else {
    $sql = "INSERT INTO customer (name, email, project_name, project_start_date, customer_type, contact)
    VALUES ('$Name', '$Email', '$ProjectName', '$StartDate', $CustomerType, '$Contact')";

    if ($con->query($sql)) {
      $response = "success";
    } else {
      $response = mysqli_error($con);
    }
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