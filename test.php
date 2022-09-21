<?php
$token = "aj2zskw799ncm7rh2x2f6vs7k6ezud";
$utoken = "u24izth113b2jc8jwt4g68vvzppk12";
$order_email = $obj->customer->billing->email;
$order_price = $obj->totalOrderAmount;
$order_buygoods = $obj->receipt;
$cookie_id = $obj->vendorVariables->cookie_ID;
$mOrderID = $obj->vendorVariables->order_ID;
$cName = $obj->customer->billing->fullName;
$productImage = "https://soulmate-artist.com/assets/img/14dk.jpg";
$productFullTitle = $obj->lineItems[0]->productTitle;

$title = "New Order: #".$mOrderID." - ".$order_price;
$message = "Name: ".$cName." | Email: ".$order_email." | Product: ".$productFullTitle;

//First create TalkJS User with same ID as conversation
$ch = curl_init();
$data = [
"token" => $token,
"user" => $token,
"title" => $title,
"message" => $message
];
$data1 = json_encode($data);
curl_setopt($ch, CURLOPT_URL, 'https://api.pushover.net/1/messages.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    
$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
$result = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);
echo $result;



        ?>