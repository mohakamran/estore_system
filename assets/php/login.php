<?php
session_start();
$username = $_POST['Username'];
$password = $_POST['Password'];
$rememberMe  =$_POST['Remember'];

$response = "";

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM user WHERE username = '$username' ")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){

  while($row = mysqli_fetch_array($result)){

    if(strcmp($password, $row['password']) == 0 && $row['status'] == 1){

      if($rememberMe == '1'){
        $expireTime = time() + 31536000;
        setcookie("estoresexpertsUsername", $row['username'], $expireTime, '/');
        setcookie("estoresexpertsPassword", md5($row['password']), $expireTime, '/');
      }

      $_SESSION['id'] = $row['id'];
      $_SESSION['userType'] = $row['userType'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['fname'] = $row['fname'];
      $_SESSION['profilePicture'] = $row['profilePicture'];

      if(strcmp($row['userType'], '0') == 0){
        $response = "admin";
      }else{
        $response = "employee";
      }

      break;
    }
  }
}

if($response == ""){
  $response = "failed";
}

echo $response;

?>
