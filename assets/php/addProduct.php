<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $pName = $_POST['pName'];
  $pDescription  = $_POST['pDescription'];

  include_once 'connection.php';

  $sql = "INSERT INTO product (productName, productDescription)
  VALUES ('$pName', '$pDescription')";

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
