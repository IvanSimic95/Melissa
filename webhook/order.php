<?php
$data = file_get_contents('php://input');
$json_data = json_decode($data);


$order_email = $json_data->email;
$order_price = $json_data->price;
$order_buygoods = $json_data->bgorderid;
$cookie_id = $json_data->cookie;

if($order_email) {
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

    $sql = "UPDATE `orders` SET `order_status`='paid',`order_email`='$order_email',`order_price`='$order_price',`buygoods_order_id`='$order_buygoods' WHERE cookie_id='$cookie_id'" ;

    if ($conn->query($sql) === TRUE) {
      echo "Update successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
?>