<?php


$secretKey = "ASFASFASF124"; // secret key from your ClickBank account
 
// get JSON from raw body...
$message = json_decode(file_get_contents('php://input'));
 
// Pull out the encrypted notification and the initialization vector for
// AES/CBC/PKCS5Padding decryption
$encrypted = $message->{'notification'};
$iv = $message->{'iv'};
error_log("IV: $iv");
 
// decrypt the body...
$decrypted = trim(
 openssl_decrypt(base64_decode($encrypted),
 'AES-256-CBC',
 substr(sha1($secretKey), 0, 32),
 OPENSSL_RAW_DATA,
 base64_decode($iv)), "\0..\32");
  
error_log("Decrypted: $decrypted");
 
////UTF8 Encoding, remove escape back slashes, and convert the decrypted string to a JSON object...
$sanitizedData = utf8_encode(stripslashes($decrypted));
$obj = json_decode($decrypted);

$type = $obj->transactionType;

if($type == "SALE" OR $type == "TEST_SALE" OR $type == "TEST"){

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
"user" => $utoken,
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

error_log("Pushover: $result");
}

?>