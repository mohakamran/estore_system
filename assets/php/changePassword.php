<?php

$username = trim($_POST['username']);
$userEmail = trim($_POST['email']);
$userOTP = trim($_POST['otp']);
$userPassword =  trim($_POST['password']);

include_once 'connection.php';

$result= mysqli_query($con, " SELECT * FROM user WHERE email = '$userEmail' AND username = '$username'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){
    if($row['passwordHash'] == $userOTP){
      $sqlUpdate = " UPDATE user SET password = '$userPassword' WHERE username = '$username'";
      if ($con->query($sqlUpdate)){
        require("email/class.phpmailer.php");
        $mail = new PHPMailer();
        //$mail->IsSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Port = EMAIL_PORT;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->setFrom(EMAIL_USERNAME, EMAIL_NAME);
        $mail->addAddress($userEmail, $row['fname']);
        $mail->addReplyTo(EMAIL_USERNAME, EMAIL_NAME);
        $mail->isHTML(true);
        $mail->Subject = 'New password for Microshield';
        $mail->Body    = '
        <html>
        <body>
        <p>Hi '.$row['fname'].',</p>
        <p>Use below credentials for login to your Microshield account.</p>
        <p>Username : '.$username.'</p>
        <p>Password : '.$userPassword.'</p>
        <br><br><br>
        This is a system generated email do not reply.
        </body>
        </html>';

        $mail->AltBody = 'New password for Microshield';

        if($mail->send()) {
          echo "success";
          break;
        }else{
          echo "failed1";
        }
      }else{
        echo "failed2";
      }
    }else{
      echo "invalid";
    }
  }
}else{
  echo "failed3";
}

?>
