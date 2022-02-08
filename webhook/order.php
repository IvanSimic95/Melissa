<?php
$data = file_get_contents('php://input');
$json_data = json_decode($data);


$order_email = $json_data->email;
$order_price = $json_data->price;
$order_buygoods = $json_data->bgorderid;
$cookie_id = $json_data->cookie;
$mOrderID = $json_data->morderid;
$cName = $json_data->cName;
$cPhone = $json_data->cPhone;
$productImage = $json_data->productImage;
$productFullTitle = $json_data->productFullTitle;

if($order_email) {
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

    $sql = "UPDATE `orders` SET `order_status`='paid',`order_email`='$order_email',`order_price`='$order_price',`buygoods_order_id`='$order_buygoods' WHERE order_id='$mOrderID'" ;

    if ($conn->query($sql) === TRUE) {
      //echo "Order Status updated to Paid succesfully!";
    } else {
      //echo "Error: " . $sql . "<br>" . $conn->error;
    }

//First create TalkJS User with same ID as conversation
$ch = curl_init();
$data = [
"id" => $mOrderID,
"name" => $cName,
"email" => $order_email,
"role" => "customer",
"phone" => $cPhone,
"photoUrl" => "https://avatars.dicebear.com/api/adventurer/".$order_email.".svg?skinColor=variant02",
"custom" => ["status" => "Paid"]
];
$data1 = json_encode($data);
print_r($data1);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/users/'.$mOrderID);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
$result = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);
echo $result;


//Now create new conversation
$ch2 = curl_init();
$data2 = [
"participants" => ["administrator", $mOrderID],
"custom" => ["status" => "Paid"]
];
$data22 = json_encode($data2);
print_r($data1);
curl_setopt($ch2, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/conversations/'.$mOrderID);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PUT');

curl_setopt($ch2, CURLOPT_POSTFIELDS, $data22);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch2);
if (curl_errno($ch2)) {
    echo 'Error:' . curl_error($ch2);
}
curl_close($ch2);
echo $result2;
}
?>