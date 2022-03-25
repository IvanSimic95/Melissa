<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

$errorDisplay = "";


isset($_GET['order']) ? $orderID        = $_GET['order']    : $errorDisplay .= " Missing Order ID <br>";
isset($_GET['order']) ? $order_price    = $_GET['price']    : $errorDisplay .= " Missing Price <br>";
isset($_GET['order']) ? $order_email    = $_GET['email']    : $errorDisplay .= " Missing Email <br>";
isset($_GET['order']) ? $bgOrderID      = $_GET['BGid']     : $errorDisplay .= " Missing Buygoods Order ID <br>";


$signature = hash_hmac('sha256', strval($orderID), 'sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98');

empty($errorDisplay) ?  $testError = FALSE : $testError = TRUE;
if($testError == TRUE){
echo $errorDisplay;
$errorDisplay = str_replace('<br>', '', $errorDisplay);
$logArray[] = $errorDisplay;
formLogNewAgain($logArray);
}else{

  //Find Correct Order
  $sql = "SELECT * FROM `orders` WHERE `order_id` = '$orderID' ORDER BY  `order_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $count = $result->num_rows;

  //If order is found input data from BG and update status to paid
  if($result->num_rows != 0) {
    
    $row = $result->fetch_assoc();
    $orderStatus = $row['order_status'];

        if($orderStatus=="pending"){
            $sql = "UPDATE `orders` SET `order_email`='$order_email', `order_price`='$order_price', `buygoods_order_id`='$bgOrderID', `order_status`='paid' WHERE order_id='$orderID'";
            $result = $conn->query($sql);

            echo "Order Status is updated to Paid! <br>";
            echo "Additional order data is saved!";
        }else{
            echo "Order Status is already: ".$orderStatus;
            echo "<br> No Changes were made to order data.";
        }


  }

}

?>