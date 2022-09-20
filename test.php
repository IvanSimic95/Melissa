<?php
$birthday = "29-03-1995";
$Ffirst_name = "Ivan";
$Flast_name = "Simic";
$customer_emailaddress = "ivan.simic2903@gmail.com";
$userSex = "male";
$orderId = "44570";
$orderProduct = "soulmate";
$orderPrice = "49.99";
$domain = "melissa-psychic.com";
$accessToken1 = "EAAxkvwzdc3kBAM3YGxUaEygEr7cdXJ9bxE8hGZC2tfmkW9BXAWZA67HcZB0SyoDYrMLs9Afgp086Yqm55zDg";
$accessToken2 = "DZAdoLErhsa7kHwFJVZA7C6HBMqdIsERWoJ8zXZAeaQtDqFgAMCTa8K0kVMdp3EPZBYGhnOjPjTOg9KkjPelq9Mu1qmvU9iTZBrm";
$fbAccessToken = $accessToken1.$accessToken2;
$FBPixel = "3290293207717814";

$fixedBirthday = date("Ymd", strtotime($birthday));
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
                    "ge" => hash('sha256', $userSex),
                    "external_id" => hash('sha256', $orderId),
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
                "event_source_url"  => $domain,
           ),
        ),
        "test_event_code" => "TEST24904",
           "access_token" => $fbAccessToken
        );  
        
        
        $dataString = json_encode($data);        
        print_r($dataString);                                                                                                      
        $ch = curl_init('https://graph.facebook.com/v11.0/'.$FBPixel.'/events');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($dataString))                                                                       
        );                                                                                                                                                                       
        $response = curl_exec($ch);
		echo $response;


        ?>