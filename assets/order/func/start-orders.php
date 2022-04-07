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


		 //	Update Order Status Processing
			$sqlupdate = "UPDATE `orders` SET `order_status`='processing' WHERE order_id='$orderId'";
			if ($conn->query($sqlupdate) === TRUE) {
      		echo "Updated";



			// curl implementation
$ch = curl_init();
$data = [
"custom" => ["status" => "Processing"]
];
$data1 = json_encode($data);
print_r($data1);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/'.$orderId);
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
//Change chat order status

      		} else {
			echo "Error";
			}
		}
	}
	echo "<br><hr>";
	$signature = hash_hmac('sha256', strval($orderID), 'sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98');
 ?>


<script>
    (function(t,a,l,k,j,s){
    s=a.createElement('script');s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s)
    ;k=t.Promise;t.Talk={v:3,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e])});l
    .push([f])},catch:function(){return k&&new k()},c:l}};})(window,document,[]);
</script>


<script>  
    Talk.ready.then(function() {
      var other = new Talk.User({
          id: "<?php echo $orderID; ?>",
          name: "<?php echo $customerName; ?>",
          email: "<?php echo $orderEmail; ?>",
          photoUrl: "https://avatars.dicebear.com/api/adventurer/<?php echo $orderEmail; ?>.svg?skinColor=variant02",
          role: "customer",
          custom: {
          email: "<?php echo $orderEmail; ?>",
          lastOrder: "<?php echo $orderID; ?>"
          }
      });
      var me = new Talk.User("administrator");
      window.talkSession = new Talk.Session({
          appId: "ArJWsup2",
          me: other,
          signature: "<?php echo $signature; ?>"
      });
      var conversation = talkSession.getOrCreateConversation("<?php echo $orderID; ?>");
          conversation.setAttributes({
          subject: "<?php echo "Order #" . $orderID . " | " .$orderProduct; ?>",
          custom: { 
          category: "<?php echo $orderProduct; ?>", 
          status: "Paid"
          }
      });

      conversation.setParticipant(other);
      conversation.setParticipant(me);

        var chatbox = window.talkSession.createChatbox(conversation);
        chatbox.mount(document.getElementById("talkjs-container-<?php echo $orderID; ?>"));
    })

</script>

<div id="talkjs-container-<?php echo $orderID; ?>">

</div>