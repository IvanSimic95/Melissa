<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

echo "Starting start-orders.php...<br><br>";
    





// 1. Check and select paid orders.

	$sqlpending = "SELECT * FROM `orders` WHERE `order_status` = 'paid'";
	$resultpending = $conn->query($sqlpending);
	if($resultpending->num_rows == 0) {
	   echo "No Orders with STATUS = PAID found in database.";
	}else{
		while($row = $resultpending->fetch_assoc()) {
			echo "Paid Orders: ".$resultpending->num_rows."<br><br>";
			
			$orderName = $row["user_name"];
		    $ex = explode(" ",$orderName);
			$customerName =  $ex["0"];
			$orderId = $row["order_id"];
			$orderProduct = $row["order_product"];
			$orderPriority = $row["order_priority"];
			$orderEmail = $row["order_email"];
			$emailLink = $base_url ."/dashboard.php?check_email=" .$orderEmail;
			$message = $processingWelcome;

			$message = str_replace("%ORDERID%",   $orderId, $message);
			$message = str_replace("%PRIORITY%",  $orderPriority, $message);
			$message = str_replace("%EMAILLINK%", $emailLink , $message);

			echo $orderId." | ";
			echo $orderEmail." | ";
			echo $orderProduct." | ";
			echo $orderPriority." | ";


          


		 //	Update Order Status Processing
			$sqlupdate = "UPDATE `orders` SET `order_status`='processing' WHERE order_id='$orderId'";
			if ($conn->query($sqlupdate) === TRUE) {
      		echo "Updated";


//First create TalkJS User with same ID as conversation
$ch = curl_init();
$data = [
"id" => $orderId,
"name" => $customerName,
"email" => [$orderEmail],
"role" => "customer",
"photoUrl" => "https://avatars.dicebear.com/api/adventurer/".$orderEmail.".svg?skinColor=variant02",
"custom" => ["email" => $orderEmail, "lastOrder" => $orderId]
];
$data1 = json_encode($data);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/users/'.$orderId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
    
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
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
"subject" => "Order #".$orderId,
"participants" => ["administrator", $orderId],
"custom" => ["status" => "Paid"]
];
$data22 = json_encode($data2);
curl_setopt($ch2, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/'.$orderId);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PUT');

curl_setopt($ch2, CURLOPT_POSTFIELDS, $data22);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch2);
if (curl_errno($ch2)) {
    echo 'Error:' . curl_error($ch2);
}
curl_close($ch2);
echo $result2;			  

  //Send CURL for message -> TalkJS
  $ch = curl_init();
  $data = [[
	  "text" => $OrderProcessingMessage,
	  "type" => "SystemMessage"
  ],
  [
	  "sender"  => "administrator",
	  "text" => $message,
	  "type" => "UserMessage"
  ]];
  
  $data1 = json_encode($data);

  curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/' . $orderId . '/messages');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

  $headers = array();
  $headers[] = 'Content-Type: application/json';
  $headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  if (curl_errno($ch)) {
	  echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);

			// curl implementation
$ch = curl_init();
$data3 = [
"custom" => ["status" => "Processing"]
];
$data33 = json_encode($data);
print_r($data1);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/'.$orderId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

curl_setopt($ch, CURLOPT_POSTFIELDS, $data33);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
//Change chat order status

      		} else {
			echo "Error";
			}
		}
	}
	echo "<br><hr>";
 ?>
