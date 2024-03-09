<?php

if( !isset($_COOKIE["estoresexpertsUsername"]) || !isset($_COOKIE["estoresexpertsPassword"])){

  ?>
  <script>window.open('pages/login/','_self')</script>
  <?php

}

else{

  $username = $_COOKIE["estoresexpertsUsername"];
  $password = $_COOKIE["estoresexpertsPassword"];
  $validCredentials = false;

  include('assets/php/connection.php');

  $result= mysqli_query($con, " SELECT * FROM user WHERE username = '$username' ")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){

    while($row = mysqli_fetch_array($result)){

      if(strcmp($password, md5($row['password'])) == 0 && $row['status'] == 1){

        $validCredentials = true;
        session_start();
        $_SESSION['id'] = $row['id'];
        $_SESSION['profilePicture'] = $row['profilePicture'];
        $_SESSION['userType'] = $row['userType'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['fname'];

        ?>
        <script>window.open('pages/dashboard/','_self')</script>
        <?php

        break;
      }
    }
  }

  if($validCredentials == false){
    $exp=time()-31536000;
    setcookie("estoresexpertsUsername","",$exp,'/');
    setcookie("estoresexpertsPassword","",$exp,'/');
    session_start();
    session_unset();
    session_destroy();
    ?>
    <script>window.open('pages/login/','_self')</script>
    <?php
  }

}
?>
