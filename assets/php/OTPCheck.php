<?php

$username = trim($_POST['username']);
$userEmail = trim($_POST['email']);
$userOTP = trim($_POST['otp']);

$response = "invalid";

include_once 'connection.php';

$result= mysqli_query($con, " SELECT * FROM user WHERE email = '$userEmail' AND username = '$username'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){
    if($row['passwordHash'] == $userOTP){
      $response = "success";
    }
  }
}else{
  $response = "invalid";
}

echo $response;

?>
