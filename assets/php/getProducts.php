<?php

$response = array();
$index = 0;

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM product WHERE productStatus ='1'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $product = (object) array();

    $product->id = $row['id'];
    $product->name = $row['productName'];
    $product->description = $row['productDescription'];

    $response[$index] = $product;
    $index++;

    unset($product);
  }
}

echo json_encode($response);
exit();

?>
