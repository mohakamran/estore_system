<?php
session_start();
if($_SESSION['username'] != ''){

  include_once 'connection.php';

  $response = "failed";

  $timestampID = $_POST['timestampID'];
  $ASINArray =$_POST['ASINArray'];
  $ASINDetails = $con -> real_escape_string($_POST['ASINDetails']);
  $primaryImage = $_POST['primaryImage'];
  $secondaryImages = $_POST['secondaryImages'];

  $sql = "UPDATE poster SET
  ASINArray = '$ASINArray',
  ASINDetails = '$ASINDetails',
  primaryImage = '$primaryImage',
  secondaryImages = '$secondaryImages'
  WHERE timestampID = '$timestampID'";

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
