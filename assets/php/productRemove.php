<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $productID = $_POST['productID'];

  include_once 'connection.php';

  $sql = "UPDATE product SET productStatus='0' WHERE id = '$productID'";

  if ($con->query($sql)){
    echo "success";
  }else{
    echo mysqli_error($con);
  }

}else{
  ?>
  <script>
  window.open('../php/logout.php','_self')
</script>
<?php
}
?>
