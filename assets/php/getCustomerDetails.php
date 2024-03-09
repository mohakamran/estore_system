<?php

$response = array();
$index = 0;
$customerID = $_POST["customerID"];

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM customer WHERE id ='$customerID'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $customer = (object) array();

    $customer->id = $row['id'];
    $customer->name = $row['name'];
    $customer->email = $row['email'];
    $customer->phone = $row['contact'];

    $response[$index] = $customer;
    $index++;

    unset($customer);
  }
}

echo json_encode($response);
exit();

?>
