<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  include_once 'connection.php';

  $response = "failed";
  $expenseID = $_POST['expenseID'];
  $expenseAmount = $_POST['expenseAmount'];
  $expenseDate = $_POST['expenseDate'];
  $fileNames = $_POST['fileNames'];
  $expenseDescription = $con -> real_escape_string($_POST['expenseDescription']);

  $sql = "UPDATE expense SET expenseAmount = '$expenseAmount', expenseDate = '$expenseDate', expenseDescription = '$expenseDescription', fileNames = '$fileNames' WHERE id = '$expenseID'";

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
