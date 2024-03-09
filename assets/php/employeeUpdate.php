<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $EmpID = $_POST['EmpID'];
  $fName = $_POST['FName'];
  $lName = $_POST['LName'];
  $contact = $_POST['Contact'];
  $email = $_POST['Email'];
  $userType = $_POST['EmpType'];
  $address  = $_POST['Address'];
  $status  = $_POST['Status'];

  include_once 'connection.php';

    $sql = "UPDATE user SET userType='$userType', fname='$fName', lname='$lName', email='$email', phone='$contact', address='$address', status='$status' WHERE id = '$EmpID'";

  if ($con->query($sql)){
  echo "success";
  }else{
    echo mysqli_error($con);
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
