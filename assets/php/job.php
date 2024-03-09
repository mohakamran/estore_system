<?php
include_once 'connection.php';

$response = "failed";

$sql = "SELECT id FROM `invoice` WHERE recurring = 1 AND endDate >= CURDATE() and MOD(DATEDIFF(CURDATE(), invoiceDate), 30) = 0 and DATEDIFF(CURDATE(), invoiceDate) <> 0";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        var_dump($row);
        $insertQuery = "INSERT INTO `invoice`(`id`, `invoiceID`, `referenceNumber`, `recurring`, `endDate`, `invoiceDate`, `paymentDate`, `company`, `employeeID`, `customerID`, `customerName`, `customerMobile`, `customerEmail`, `productID`, `productCostPrice`, `productSellingPrice`, `productQuantity`, `orderTotal`, `paymentTotal`, `paymentAmount`, `paidDate`, `paymentType`, `status`, `attachments`, `notes`)
    SELECT
        NULL, `invoiceID`, `referenceNumber`, `recurring`, `endDate`, CURDATE(), `paymentDate`, `company`, `employeeID`, `customerID`, `customerName`, `customerMobile`, `customerEmail`, `productID`, `productCostPrice`, `productSellingPrice`, `productQuantity`, `orderTotal`, `paymentTotal`, `paymentAmount`, `paidDate`, `paymentType`, `status`, `attachments`, `notes`
    FROM invoice
    WHERE id = '" . $row["id"] . "'";

        if ($con->query($insertQuery)) {
            $response = "success";
        } else {
            $response = "failed for id " . $row["id"];
        }
    }
} else {
    $response = mysqli_error($con);
}

echo $response;
