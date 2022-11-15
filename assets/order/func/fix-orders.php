<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

echo "Starting start-orders.php...<br><br>";
    





// 1. Check and select paid orders.

	$sqlpending = "SELECT * FROM `orders` WHERE `order_status` = 'paid' LIMIT 20";
	$resultpending = $conn->query($sqlpending);
	if($resultpending->num_rows == 0) {
	   echo "No Orders with STATUS = PAID found in database.";
	}else{
		while($row = $resultpending->fetch_assoc()) {
			echo "Paid Orders: ".$resultpending->num_rows."<br><br>";

			$orderName = $orderID = $orderId = $orderProduct = $orderPriority = $emailLink = $message = $orderPriority = $ch = "";
			$logArray = "";
			$logArray = array();
			$partnerGender = $row["pick_sex"];
			$orderName = $row["user_name"];
		    $ex = explode(" ",$orderName);
			$customerName =  $ex["0"];
			$orderId = $row["order_id"];
			$orderProduct = $row["order_product"];
			$orderPrice = $row["order_price"];
			$orderPriority = $row["order_priority"];
			$orderEmail = $row["order_email"];
			$fbc = $row["fbc"];
			$fbp = $row["fbp"];
			$agent = $row["user_agent"];
			$checkpixel = $row["pixel"];
			$ip = $row["user_ip"];
			$emailLink = $base_url ."/dashboard.php?check_email=" .$orderEmail;
			$message = $processingWelcome;
			$order_product_nice = $row["order_product_nice"];

			$zip = $row["zip"];
			$country = strtolower($row["country"]);

			if($checkpixel == 1){
				$fbAccessToken = $fbAccessToken;
				$FBPixel = $FBPixel;
			}else{
				$fbAccessToken = $sfbAccessToken;
				$FBPixel = $FBPixel2;
			}



			$message = str_replace("%ORDERID%",   $orderId, $message);
			$message = str_replace("%PRIORITY%",  $orderPriority, $message);
			$message = str_replace("%EMAILLINK%", $emailLink , $message);

			echo $orderId." | ";
			echo $orderEmail." | ";
			echo $orderProduct." | ";
			echo $orderPriority." | ";
			echo "Pixel: ".$checkpixel." | ";
			

			switch ($orderProduct) {
				case "husband":
				  if($partnerGender=="male"){
					$product  = "Future Spouse Drawing";
				  }else{
					$product  = "Future Spouse Drawing";
				  }
				  break;
				  case "futurespouse":
					if($partnerGender=="male"){
					  $product  = "Future Spouse Drawing";
					}else{
					  $product  = "Future Spouse Drawing";
					}
					break;
			  case "pastlife":
				  $product = "Past Life Drawing";
				  break;
			  case "baby":
				  $product = "Future Baby Drawing";
				  break;
			  case "soulmate":
				  $product = "Soulmate Drawing";
				  break;
			  case "twinflame":
					  $product = "Twin Flame Drawing";
					  break;
				case "spiritguide":
					$product = "Spirit Guide Drawing";
					break;
				case "higherself":
					$product = "Higher Self Drawing";
					break;
default:
$product = $orderProduct;
break;
			  }


			  $logArray[] = $orderId." | ". $orderEmail." | ".$product." | ".$orderPriority." | ";

		 //	Update Order Status Processing
			$sqlupdate = "UPDATE `orders` SET `order_status`='processing', `abandoned_cart`='paid' WHERE order_id='$orderId'";
			if ($conn->query($sqlupdate) === TRUE) {
      		echo "Updated";




$partnerGender = $row["pick_sex"];
$orderName = $row["user_name"];
$ex = explode(" ",$orderName);
$customerName =  $ex["0"];
$orderId = $row["order_id"];
$orderProduct = $row["order_product"];
$orderPriority = $row["order_priority"];

$emailLink = $base_url ."/dashboard.php?check_email=" .$orderEmail;
$message = $processingWelcome;
$order_product_nice = $row["order_product_nice"];

$userSex = $row["user_sex"];
$Ffirst_name = $row["first_name"];
$Flast_name = $row["last_name"];
$customer_emailaddress = $row["order_email"];
$birthday = $row["birthday"];


if($userSex == "male"){
	$usersex1 = "m";
}else{
	$usersex1 = "f";
}

//Facebook API conversion
if($orderProduct == "soulmate" OR $orderProduct == "futurespouse" OR $orderProduct == "twinflame"){
   if($sendFBAPI == 1){
    $fixedBirthday = date("Ymd", strtotime($birthday));


	if (!empty($fbc) AND empty($fbp)) {
		$data = array( // main object
			"data" => array( // data array
				array(
					
					"event_name" => "Purchase",
					"event_time" => time(),
					"event_id" => $orderId,
					"user_data" => array(
						"fn" => hash('sha256', $Ffirst_name),
						"ln" => hash('sha256', $Flast_name),
						"em" => hash('sha256', $customer_emailaddress),
						"db" => hash('sha256', $fixedBirthday),
						"ge" => hash('sha256', $usersex1),
						"external_id" => hash('sha256', $orderId),
						"fbc" => $fbc,
						"client_ip_address" => $ip,
						"client_user_agent" => $agent,
						"zp" => hash('sha256', $zip),
						"country" => hash('sha256', $country),
					),
					"contents" => array(
						array(
						"id" => $orderProduct,
						"quantity" => 1
						),
					),
					"custom_data" => array(
						"currency" => "USD",
						"value"    => $orderPrice,
					),
					"action_source" => "website",
					"event_source_url"  => "https://".$domain."/readings.php",
			   ),
			),
			   "access_token" => $fbAccessToken,
			   
			); 
	}elseif(empty($fbp) AND !empty($fbc)){
		$data = array( // main object
			"data" => array( // data array
				array(
					
					"event_name" => "Purchase",
					"event_time" => time(),
					"event_id" => $orderId,
					"user_data" => array(
						"fn" => hash('sha256', $Ffirst_name),
						"ln" => hash('sha256', $Flast_name),
						"em" => hash('sha256', $customer_emailaddress),
						"db" => hash('sha256', $fixedBirthday),
						"ge" => hash('sha256', $usersex1),
						"external_id" => hash('sha256', $orderId),
						"fbp" => $fbp,
						"client_ip_address" => $ip,
						"client_user_agent" => $agent,
						"zp" => hash('sha256', $zip),
						"country" => hash('sha256', $country),
					),
					"contents" => array(
						array(
						"id" => $orderProduct,
						"quantity" => 1
						),
					),
					"custom_data" => array(
						"currency" => "USD",
						"value"    => $orderPrice,
					),
					"action_source" => "website",
					"event_source_url"  => "https://".$domain."/readings.php",
			   ),
			),
			   "access_token" => $fbAccessToken,
			   
			); 

	}elseif(!empty($fbp) AND !empty($fbc)){
		$data = array( // main object
			"data" => array( // data array
				array(
					
					"event_name" => "Purchase",
					"event_time" => time(),
					"event_id" => $orderId,
					"user_data" => array(
						"fn" => hash('sha256', $Ffirst_name),
						"ln" => hash('sha256', $Flast_name),
						"em" => hash('sha256', $customer_emailaddress),
						"db" => hash('sha256', $fixedBirthday),
						"ge" => hash('sha256', $usersex1),
						"external_id" => hash('sha256', $orderId),
						"fbc" => $fbc,
						"fbp" => $fbp,
						"client_ip_address" => $ip,
						"client_user_agent" => $agent,
						"zp" => hash('sha256', $zip),
						"country" => hash('sha256', $country),
					),
					"contents" => array(
						array(
						"id" => $orderProduct,
						"quantity" => 1
						),
					),
					"custom_data" => array(
						"currency" => "USD",
						"value"    => $orderPrice,
					),
					"action_source" => "website",
					"event_source_url"  => "https://".$domain."/readings.php",
			   ),
			),
			   "access_token" => $fbAccessToken,
			   
			); 
	}else{
    $data = array( // main object
        "data" => array( // data array
            array(
				
                "event_name" => "Purchase",
                "event_time" => time(),
                "event_id" => $orderId,
                "user_data" => array(
                    "fn" => hash('sha256', $Ffirst_name),
                    "ln" => hash('sha256', $Flast_name),
                    "em" => hash('sha256', $customer_emailaddress),
                    "db" => hash('sha256', $fixedBirthday),
                    "ge" => hash('sha256', $usersex1),
                    "external_id" => hash('sha256', $orderId),
					"client_ip_address" => $ip,
					"client_user_agent" => $agent,
					"zp" => hash('sha256', $zip),
					"country" => hash('sha256', $country),
                ),
                "contents" => array(
					array(
                    "id" => $orderProduct,
                    "quantity" => 1
					),
                ),
                "custom_data" => array(
                    "currency" => "USD",
                    "value"    => $orderPrice,
                ),
                "action_source" => "website",
                "event_source_url"  => "https://".$domain."/readings.php",
           ),
        ),
           "access_token" => $fbAccessToken,
		   
        );  
        
	}
        $dataString = json_encode($data);                                                                                                              
        $ch = curl_init('https://graph.facebook.com/v11.0/'.$FBPixel.'/events');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($dataString))                                                                       
        );                                                                                                                                                                       
        $response = curl_exec($ch);
		$logArray[] = $response;
		echo "<br>Sent to Pixel ID: ".$FBPixel;
		echo $response;
    }
}

      		} else {
			echo "Error";
			}

			startLog($logArray);
		}
	}
	echo "<br><hr>";
 ?>
