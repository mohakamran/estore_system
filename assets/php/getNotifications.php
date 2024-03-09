<?php

$response = array();
$index = 0;
$notificationID = $_POST['notificationID'];

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM notification WHERE id ='$notificationID'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $notification = (object) array();

    $notification->id = $row['id'];
    $notification->title = $row['title'];
    $notification->description = $row['description'];
    $notification->folderName = $row['folderName'];
    $notification->fileNames = $row['fileNames'];
    $notification->notificationDate = $row['notificationDate'];

    $response[$index] = $notification;
    $index++;

    unset($notification);
  }
}

echo json_encode($response);
exit();

?>
