<?php
include '/home/melissapsychic/public_html/config/vars.php';
echo "Starting complete-orders.php...<br><br>";


$trigger = "1";


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}


	$sql = 'SELECT * from orders WHERE order_status = "processing"';
	$sqlResoult = $conn->query($sql);
	if($sqlResoult->num_rows == 0) {
	   echo "No Orders with STATUS = PROCESSING found in database.<br><hr>";
	} else {
		echo "Processing Orders: ".$sqlResoult->num_rows."<br><br>";
		while($row = $sqlResoult->fetch_assoc()) {
			$orderDate = $row["order_date"];
			$orderName = $row["user_name"];
			$ex = explode(" ",$orderName);
			$fName = $ex["0"];
			$orderID = $row["order_id"];
			$orderEmail = $row["order_email"];
			$orderAge = $row["user_age"];
			$orderPrio = $row["order_priority"];
			$orderProduct = $row["order_product"];
			$orderSex = $row["pick_sex"];
			$userSex = $row["user_sex"];
			$date1 = $orderDate;
			$date2 =  date("Y-m-d H:i:s");
			$start = new \DateTime($date1);
			$end = new \DateTime($date2);
			$interval = new \DateInterval('PT1H');
			$periods = new \DatePeriod($start, $interval, $end);
			$hours = iterator_count($periods);
			
			//$trigger = 0;
			$trigger = 1;
			$image_send = 0;
			$randomDelay = rand(0,4);

			echo "".$orderID." | ";
			

			if ($hours >= ($orderPrio - $randomDelay )) {
				echo "Active | ";
				 $trigger = 1;
			}else {
				echo "Waiting | ";
			}
			
			echo ""  . $hours . " hours | <br>";
			
				if ($orderProduct == "soulmate" || $orderProduct == "husband" || $orderProduct =="twinflame") {
				    $image_send = 1;
					$prod_type = "";
					$img_folder_name = "general";

					$theader = $generalOrderHeader;
					$tfooter = $generalOrderFooter;

					if ($orderProduct == "soulmate") {
						$prod_type = "1";
					
					}elseif($orderProduct == "husband"){
						$prod_type = "2";
					
					}elseif($orderProduct =="twinflame"){
						$prod_type = "3";
					
					}

					$age_max = $orderAge + 7;
					$age_min = $orderAge + 2;
					if ($age_max > 67) {
						$age_min = 63;
						$age_max = 67;
					}
					if ($age_min < 20) {
						$age_min = 20;
						$age_max = 24;
					}

					$sql_pick = "SELECT * FROM orders_image WHERE age < '$age_max' AND age > '$age_min' AND sex = 'male' order by RAND() limit 1";
					$sql_pick_res = $conn->query($sql_pick);
					if($sql_pick_res->num_rows == 0) {
							 $image_name = "";
					} else {
						while($rowImages = $sql_pick_res->fetch_assoc()) {
							$image_name = $rowImages["name"];
						}
					}


					$sql_text = "SELECT * FROM orders_text WHERE product = '$orderProduct' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
							 $email_text = "";
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text = $rowText["text"];
						    $message = $theader.$email_text.$tfooter;
						}
					}
					
				//START IF PRODUCT = FUTURE BABY
			    }elseif ($orderProduct == "baby")  { 
				$image_send = 1;
				$prod_type = "baby";
				$img_folder_name = "baby";
				$babyGender = "female";

				$theader = $babyOrderHeader;
				$tfooter = $babyOrderFooter;

						
				if($userSex == "male"){ //If customer sex is set as male
				$babyGender = "male";
				}elseif($userSex == "female"){ //If customer sex is set as female
				$babyGender = "female";
				}
					

				$sql_pick = "SELECT * FROM  orders_image WHERE product = 'baby' order by RAND() limit 1";
				$sql_pick_res = $conn->query($sql_pick);
				
				if($sql_pick_res->num_rows == 0) {
					$image_name = "";
				} else {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
					$image_name = $rowImages["name"];
					}
				}
				$sql_text = "SELECT * FROM orders_text WHERE product = '$prod_type' AND gender = '$babyGender' order by RAND() limit 1";
				$sql_text_res = $conn->query($sql_text);
				if($sql_text_res->num_rows == 0) {
						$email_text = "";
				} else {
					while($rowText = $sql_text_res->fetch_assoc()) {
						$email_text = $rowText["text"];
						$message = $theader.$email_text.$tfooter;
					}
				}
				//END IF PRODUCT = FUTURE BABY




				}elseif (strpos($orderProduct, 'general') !== false || strpos($orderProduct, 'love') !== false || strpos($orderProduct, 'career') !== false || strpos($orderProduct, 'health') !== false) {
				$image_send = 0;
				$email_text = "";
				$theader = $readingOrderHeader;
				$tfooter = $readingOrderFooter;
				if (strpos($orderProduct, 'general') !== false) {

					$sql_text = "SELECT * FROM orders_text WHERE product = 'General' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'love') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'Love' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'career') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'Career' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'health') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'Health' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				
				$message = $theader.$email_text.$tfooter;

			}elseif ($orderProduct == "past") {
				$image_send = 1;
				$img_folder_name = "past";

				$theader = $pastOrderHeader;
				$tfooter = $pastOrderFooter;

				$sql_pick = "SELECT * FROM orders_image WHERE product = 'past' order by RAND() limit 1";
				$sql_pick_res = $conn->query($sql_pick);
				if($sql_pick_res->num_rows == 0) {
					 $image_name = "";
				} else {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
						$image_name = $rowImages["name"];
						 //echo $image_name . " </br>";
					}
				}

				$sql_text = "SELECT * FROM orders_text WHERE product = 'past' order by RAND() limit 1";
				$sql_text_res = $conn->query($sql_text);
				if($sql_text_res->num_rows == 0) {
						$email_text = "";
				} else {
					while($rowText = $sql_text_res->fetch_assoc()) {
						$email_text = $rowText["text"];
						$message = $theader.$email_text.$tfooter;
					}
				}
			}
			// end of past life
			
		//If trigger is set to 1 (order is ready to be delivered)
		if ($trigger == 1) {

			$message = str_replace("%FIRSTNAME%", $fName, $message);

			if ($image_send == "1") { //SEND IMAGE START
						// define image name and new path
							$rootDir = $_SERVER['DOCUMENT_ROOT'];
							$ext = ".jpg";
							$sPath = "/assets/order/images/general/";
							$randomImageName = rand(55547,75547);

						// Old Paths
					        $oldImagename = $image_name;
							$oldImageShortPath = "assets/order/images/".$img_folder_name."/".$image_name.$ext;
							
							$oldImageFullPath = $base_url.$oldImageShortPath;
							
							$oldImageServerPath = $rootDir .$oldImageShortPath;

						// new Paths
							$newImagename = $orderProduct ."-" .$randomImageName ."-" .$orderID .$ext;
							$newImageShortPath = "assets/email/delivery-images/".$newImagename;
							$newImageServerPath = $rootDir .$newImageShortPath;
							$newImageFullPath = $base_url .$newImageShortPath;

						//	echo 'New Image path = <a href="' .$newImageFullPath .'">' .$newImageFullPath ."</a><br> Old image path = ".$oldImageFullPath ."<br></a><br> ";
							echo $img_folder_name.'/'.$oldImagename.'.jpg | ';
							echo $newImagename.' | ';

						// Set new image path and name
							$newImageNameHash = copy($oldImageServerPath, $newImageServerPath);


							$ch = curl_init();
							$authorization = "Bearer sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL";
							curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/files');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);
							
						// Set image data for upload via CURL
						
                            $filename = $rootDir.'assets/email/delivery-images/'.$newImagename;
                            $finfo = new \finfo(FILEINFO_MIME_TYPE);
                            $mimetype = $finfo->file($filename);
							$cfile = curl_file_create($filename, $mimetype, basename($filename));
							$imgdata = array('file' => $cfile);
							
							curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
							
							$headers = array();
							$headers[] = 'Content-Type: multipart/form-data';
							$headers[] = 'Authorization: ' . $authorization;
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							$attachment = curl_exec($ch);
							if (curl_errno($ch)) {
							    echo 'Error:' . curl_error($ch);
							}
							curl_close ($ch);
						    //echo $attachment;
						    $token = json_decode($attachment);
                            $Atoken_key = $token->attachmentToken;


                // curl implementation
                $ch = curl_init();
                $data = [[
                "text" => $message,
                "sender"  => "654321252",
                "type" => "UserMessage"
				],
				[
				"attachmentToken" => $Atoken_key,
				"sender"  => "654321252",
				"type" => "UserMessage",
				],[
				"text" => $OrderCompleteMessage,
				"type" => "SystemMessage"
				],[
					"text" => $ContinueConvoMsg,
					"type" => "SystemMessage"
					]];

                $data1 = json_encode($data);
            

                curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/conversations/' . $row["order_id"] . '/messages');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

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
                //SEND IMAGE END
                	}else{//SEND ONLY TEXT START
					 // curl implementation
					 $ch = curl_init();
					 $data = [[
					 "text" => $message,
					 "sender"  => "654321252",
					 "type" => "UserMessage"
					 ],
					[
					"text" => $OrderCompleteMessage,
					"type" => "SystemMessage"
					],[
						"text" => $ContinueConvoMsg,
						"type" => "SystemMessage"
						]];
	 
					 $data1 = json_encode($data);
				 
	 
					 curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/conversations/' . $row["order_id"] . '/messages');
					 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	 
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
					 //SEND ONLY TEXT END
				}



				// Set order to shipped
			$sqlupdate = "UPDATE `orders` SET `order_status`='shipped' WHERE order_id='$orderID'";
					if ($conn->query($sqlupdate) === TRUE) {
		     		echo "Updated";

// curl implementation
$ch = curl_init();
$data = [
"custom" => ["status" => "Completed"]
];
$data1 = json_encode($data);
print_r($data1);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/conversations/'.$orderID);
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
//Change chat order status

		    	} else {
					echo "Error";
					//   echo "Error: " . $sql . "<br>" . $conn->error;
					}
			}


		} 	// end of loop



	}
	 // end of processing
?>
