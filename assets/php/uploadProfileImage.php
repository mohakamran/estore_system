<?php
session_start();

$response = array();
$index = 0;
$employeeID = $_POST["employeeID"];

if(isset($_POST["image"]))
{
  $data = $_POST["image"];
  $image_array_1 = explode(";", $data);
  $image_array_2 = explode(",", $image_array_1[1]);
  $data = base64_decode($image_array_2[1]);
  $imageName = $employeeID . '.png';
  $imageLocation = "../profiles/".$imageName;
  file_put_contents($imageLocation, $data);

  include_once 'connection.php';

  $sql = "UPDATE user SET profilePicture='$imageName' WHERE id = '$employeeID'";

  if ($con->query($sql)){
    $_SESSION['profilePicture'] = $imageName;
    $responseObject = (object) array();
    $responseObject->status = "success";
    $responseObject->target = $imageName;
    $response[$index] = $responseObject;
    $index++;
  }else{
    $responseObject = (object) array();
    $responseObject->status = mysqli_error($con);
    $response[$index] = $responseObject;
    $index++;
  }

}

echo json_encode($response);
exit();

?>
