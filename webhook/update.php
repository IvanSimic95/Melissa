<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', '1');

$error = "";
//Save to order log function
function f($array) {
    $dataToLog = $array;
    $data = $dataToLog;
    $data .= PHP_EOL;
    $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/update.log";
    $success = file_put_contents($pathToFile, $data, FILE_APPEND);
    if ($success === TRUE){
      echo "log saved";
    }
}
if(isset($_GET['data'])){
$dDecode = base64_decode($_GET['data']);
$d = explode("|", $dDecode);

//Assing variables by splitting up data received from main server
$action                 = $d[0];
$product_codename       = $d[1];
$customer_emailaddress  = $d[2];
$customer_phone         = $d[3];
$price                  = $d[4];
$bgOrderID              = $d[5];
$subid3                 = $d[6];
$subid4                 = $d[7];
$subid5                 = base64_decode($d[8]);
$ip                     = $d[9];
$agent                  = $d[10];

if (str_contains($subid5, '|')) { 
  $clean = explode("|", $subid5);
  $orderID  = $clean[0];
  $domain   = $clean[1];
  $c1       = $clean[2];
  $c2       = $clean[3];
  $c3       = $clean[4];
}else{
  $error = "ERROR WITH SUBID5: ".$action. " | " .$product_codename. " | " .$customer_emailaddress. " | " .$customer_phone. " | " .$subid3. " | " .$subid4. " | " .$subid5;
  f($error);
  echo $error;
}

if(str_contains($product_codename, 'soulmate')) {
  $checkCookie = $c1;
}elseif(str_contains($product_codename, 'twinflame')) {
  $checkCookie = $c1;
}elseif(str_contains($product_codename, 'husband')) {
  $checkCookie = $c1;
}elseif(str_contains($product_codename, 'xreadings')) {
  $checkCookie = $c2;
}elseif(str_contains($product_codename, 'baby')) {
  $checkCookie = $c3;
}else{
  $error = "ERROR UPDATING THIS ORDER: ".$action. " | " .$product_codename. " | " .$customer_emailaddress. " | " .$customer_phone. " | " .$subid3. " | " .$subid4. " | " .$orderID. " | " .$domain. " | " .$c1. " | " .$c2. " | " .$c3;
  f($error);
  echo $error;
}

//
if($action == "neworder" && $error == ""){
  if(isset($checkCookie)) {
  //Find Correct Order
  $sql = "SELECT * FROM `orders` WHERE `cookie_id` = '$checkCookie' ORDER BY  `order_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $count = $result->num_rows;

    //If order is found input data from BG and update status to paid
    if($result->num_rows != 0) {
      $row = $result->fetch_assoc();
      $ForderID = $row['order_id'];
      $Ffirst_name = $row['first_name'];
      $Flast_name = $row['last_name'];
      $Fproduct = $row['order_product'];
      $Fsex = $row['user_sex'];
      $FgenderAcc = $row['genderAcc'];
      $Faffid = $row['affid'];
      $Fbirthday = $row['birthday'];
      $Fs1 = $row['s1'];
      $Fs2 = $row['s2'];
      $Forder_product_nice = $row['order_product_nice'];
      $Fstatus = $row['order_status'];

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

$fixedBirthday = date("Ymd", strtotime($birthday));

      if($Fstatus == "pending"){
      $sql = "UPDATE `orders` SET `order_email`='$customer_emailaddress', `order_price`='$price', `buygoods_order_id`='$bgOrderID', `order_status`='paid' WHERE order_id='$ForderID'";
      $result = $conn->query($sql);
      $success = "Order #".$ForderID." status updated to Paid";
      f($success);
      echo $success;
    }else{
      $success = "Order #".$ForderID." NOT updated - Status: ".$Fstatus;
      f($success);
      echo $success;
    }

    //Facebook API conversion
    if($sendFBAPI == 1){
    $cleanPhone = preg_replace('/[^0-9]/', '', $customer_phone);
    $fbc = $subid3;
    $fbp = $subid4;
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
            "ph" => hash('sha256', $cleanPhone),
            "db" => hash('sha256', $fixedBirthday),
            "ge" => hash('sha256', $Fsex),
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
            "ph" => hash('sha256', $cleanPhone),
            "db" => hash('sha256', $fixedBirthday),
            "ge" => hash('sha256', $Fsex),
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
            "ph" => hash('sha256', $cleanPhone),
            "db" => hash('sha256', $fixedBirthday),
            "ge" => hash('sha256', $Fsex),
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
                  "ph" => hash('sha256', $cleanPhone),
                  "db" => hash('sha256', $fixedBirthday),
                  "ge" => hash('sha256', $Fsex),
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
        $ch = curl_init('https://graph.facebook.com/v11.0/{PIxel ID}/events');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($dataString))                                                                       
        );                                                                                                                                                                       
        $response = curl_exec($ch);
    }


    //Error Handling for not finding order with this Cookie ID
    }else{
      $error = "ORDER WITH THIS COOKIE ID NOT FOUND: ".$action. " | " .$product_codename. " | " .$customer_emailaddress. " | " .$customer_phone. " | " .$subid3. " | " .$subid4. " | " .$orderID. " | " .$domain. " | " .$c1. " | " .$c2. " | " .$c3;
      f($error);
      echo $error;
    }
  //Error Handling for check cookie variable not being set due to some error
  }else{
    $error = "CHECK COOKIE VARIABLE WASNT SET: ".$action. " | " .$product_codename. " | " .$customer_emailaddress. " | " .$customer_phone. " | " .$subid3. " | " .$subid4. " | " .$orderID. " | " .$domain. " | " .$c1. " | " .$c2. " | " .$c3;
    f($error);
    echo $error;
  }

//Error Handling for action type and empty error variable
}else{
  $error = "ACTION WASNT NEWORDER OR ERROR VARIABLE WASNT EMPTY: ".$action. " | " .$product_codename. " | " .$customer_emailaddress. " | " .$customer_phone. " | " .$subid3. " | " .$subid4. " | " .$subid5;
  f($error);
  echo $error;
}

//Error handling when data is missing from URL
}else{
$error = "Data wasn't sent";
echo $error;
}
  ?>