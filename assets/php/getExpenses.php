<?php

$response = array();
$index = 0;
$expenseID = $_POST['expenseID'];

include('connection.php');

$result= mysqli_query($con, " SELECT * FROM expense WHERE id ='$expenseID'")
or die('An error occurred! Unable to process this request. '. mysqli_error($con));

if(mysqli_num_rows($result) > 0 ){
  while($row = mysqli_fetch_array($result)){

    $expense = (object) array();

    $expense->folderName = $row['folderName'];
    $expense->fileNames = $row['fileNames'];

    $response[$index] = $expense;
    $index++;

    unset($expense);
  }
}

echo json_encode($response);
exit();

?>
