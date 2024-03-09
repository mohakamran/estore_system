<?php

$username = trim($_POST['username']);
$userEmail = trim($_POST['email']);
$userOTP = trim($_POST['otp']);

$response = "failed";

include_once 'connection.php';

$result= mysqli_query($con, " SELECT * FROM user WHERE email = '$userEmail' AND username = '$username'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){

  while($row = mysqli_fetch_array($result)){

    if(md5($row['passwordHash']) == $userOTP){
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
      $mail->Subject = 'OTP for password change request';
      $mail->Body    = '
      <html>
      <body>
      <p>Hi '.$row['fname'].',</p>
      <p>Your OTP for changing the password is : '.$row['passwordHash'].'</p><br>
      <br><br><br>
      This is a system generated email do not reply.
      </body>
      </html>';

      $mail->AltBody = 'OTP for password change request';
    }

    if($mail->send()) {
      $response = $userOTP;
    }else{
      $response = "failed";
    }
  }
}else{
  $response = "failed";
}

echo $response;

?>
