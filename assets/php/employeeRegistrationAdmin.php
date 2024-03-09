<?php
session_start();
if($_SESSION['username'] != '' && $_SESSION['userType'] == '0'){

  $response = "failed";

  $fName = $_POST['FName'];
  $lName = $_POST['LName'];
  $contact = $_POST['Contact'];
  $email = $_POST['Email'];
  $empType  = $_POST['EmpType'];
  $address  = $_POST['Address'];
  $username="TW_".$fName.substr($lName,0,2).rand(10,1000);
  $joiningDate = date('Y-m-d');

  $generator = "1abcd3efgh5yz7ijkl90mnop24qrst6uvwx8";
  $password = "";
  for ($i = 1; $i <= 8; $i++) {
    $password .= substr($generator, (rand()%(strlen($generator))), 1);
  }
  $password=trim($password);
  $password=strtoupper($password);

  include_once 'connection.php';

  $result= mysqli_query($con, " SELECT * FROM user WHERE email = '$email' OR phone = '$contact'")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));

  if(mysqli_num_rows($result) > 0 ){
    while($row = mysqli_fetch_array($result)){
      if($row['email'] == $email){
        $response = "email";
      }else{
        $response = "phone";
      }
    }
  }else{
    $sql = "INSERT INTO user (userType, username, password, fname, lname, email, phone, address, joiningDate, status)
    VALUES ('$empType', '$username', '$password', '$fName', '$lName', '$email', '$contact', '$address', '$joiningDate', '1')";

    if ($con->query($sql)){

      require("email/class.phpmailer.php");
      $mail = new PHPMailer();
      //$mail->IsSMTP();
      $mail->Host = EMAIL_HOST;
      $mail->SMTPAuth = true;
      $mail->Port = EMAIL_PORT;
      $mail->Username = EMAIL_USERNAME;
      $mail->Password = EMAIL_PASSWORD;
      $mail->setFrom(EMAIL_USERNAME, EMAIL_NAME);
      $mail->addAddress($email, $fName);
      $mail->addReplyTo(EMAIL_USERNAME, EMAIL_NAME);
      $mail->isHTML(true);
      $mail->Subject = EMAIL_NAME.' account created';
      $mail->Body    = '
      <html>
      <body>
      <h4>Hi <span style="text-transform:capitalize;"> <B>'.$fName.",".'</B></span><br><br>You have been successfully registered on '.EMAIL_NAME.'. Please use below credential to sign-in.<br><br>
      Username:<span style="color:red;text-transform:capitalize;">&nbsp;&nbsp;'.$username.'</span><br>
      Password:<span style="color:red;text-transform:capitalize;">&nbsp;&nbsp;'.$password.'</span><br>
      </h4><br><br><br>
      This is a system generated email do not reply.
      </body>
      </html>';

      $mail->AltBody = EMAIL_NAME.' account created!';

      if($mail->send()) {
        $response = "success";
      }else{
        $sqlRemove = "DELETE FROM user WHERE username = '$username'";
        $con->query($sqlRemove);
      }
    }
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
