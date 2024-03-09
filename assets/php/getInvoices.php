<?php
session_start();

$response = array();
$index = 0;

$empId = $_POST['empId'];
$fromDate = $_POST['fromDate'];

include('connection.php');

if($_SESSION['userType'] == '0'){
  $result= mysqli_query($con, " SELECT invoiceDate, paymentTotal FROM invoice WHERE invoiceDate >= '$fromDate' ORDER BY invoiceDate")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));
}else{
  $result= mysqli_query($con, " SELECT invoiceDate, paymentTotal FROM invoice WHERE employeeID = '$empId' AND invoiceDate >= '$fromDate' ORDER BY invoiceDate")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));
}

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $invoice = (object) array();

    $invoice->invoiceDate = $row['invoiceDate'];
    $invoice->total = $row['paymentTotal'];

    $response[$index] = $invoice;
    $index++;

    unset($invoice);
  }
}

if($_SESSION['userType'] == '0'){
  $result= mysqli_query($con, " SELECT invoiceDate, paymentTotal FROM invoiceproperty WHERE invoiceDate >= '$fromDate' ORDER BY invoiceDate")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));
}else{
  $result= mysqli_query($con, " SELECT invoiceDate, paymentTotal FROM invoiceproperty WHERE employeeID = '$empId' AND invoiceDate >= '$fromDate' ORDER BY invoiceDate")
  or die('An error occurred! Unable to process this request. '. mysqli_error($con));
}

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $invoice = (object) array();

    $invoice->invoiceDate = $row['invoiceDate'];
    $invoice->total = $row['paymentTotal'];

    $response[$index] = $invoice;
    $index++;

    unset($invoice);
  }
}


//echo mysqli_error($con);
echo json_encode($response);
exit();

?>
