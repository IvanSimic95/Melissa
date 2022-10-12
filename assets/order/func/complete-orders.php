<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
echo "Starting complete-orders.php...<br><br>";




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
			$logError = "";
			$logArray = "";
			$logArray = array();
			$logError = array();
			$message = "";
			$missingTest = 0;
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

			$premium = $row["premium"];
			$reading = $row["reading"];
			$color = $row["color"];

			$trigger = 0;
			#$trigger = 1;
			$image_send = 0;
			$randomDelay = rand(0,3);

			echo "".$orderID." | ";
$logArray[] = "
".$orderID." | ";
			

			if ($hours >= ($orderPrio - $randomDelay )) {
				echo "Active | ";
				$logArray[] = "Active | ";
				 $trigger = 1;
			}else {
				echo "Waiting | ";
				$logArray[] = "Waiting | ";
			}
			
			echo ""  . $hours . " hours | <br>";

		
			//Check if text should be sent
			if($reading == 1 OR $premium == 1){
				$text_send = "1";
			}else{
				$text_send = "0";
			}

			//Check if no text should be sent
			if($reading == 0 AND $premium == 0){

				$noReadingMSG = $generalOrderNoReading;
	
			}

			//Check if only premium text should be sent
			if($reading == 0 AND $premium == 1){

			$generalOrderHeader = $generalOrderHeaderNoReading;
			$generalOrderFooter = $generalOrderFooterNoReading;

			}


		//If trigger is set to 1 (order is ready to be delivered)
		if ($trigger == 1) {


			
			if($premium == 1){
				if($orderProduct == "soulmate"){

					$premiumProdT = "soulmate's";

				}elseif($orderProduct == "futurespouse"){

					
					if($orderSex == "male"){
						$premiumProdT = "future husband's";
					}else{
						$premiumProdT = "future wife's";
					}


				}else{
					$premiumProdT = "soulmate's";
				}

				$sql_pick = "SELECT * FROM premium WHERE category = 'initials' order by RAND() limit 1";
				$sql_pick_res = $conn->query($sql_pick);
				if($sql_pick_res->num_rows > 0) {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
						$initials = $rowImages["text"];
						$logArray[] = "Initials: ".$initials;
					}
				}else{
					$initials = "";
				}

				$sql_pick = "SELECT * FROM premium WHERE category = 'place' order by RAND() limit 1";
				$sql_pick_res = $conn->query($sql_pick);
				if($sql_pick_res->num_rows > 0) {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
						$place = $rowImages["text"];
						$logArray[] = "Place: ".$place;
					}
				}else{
					$place = "";
				}


				$minMonth = rand(3,4);
				$maxMonth = rand(5,6);
				$meetTime = $minMonth." - ".$maxMonth;

				$premiumText = "\n\nYour ".$premiumProdT." initials: *".$initials."*\nYou will meet at *".$place."*\n";

			}else{
				$premiumText = "";
			}
			
				if ($orderProduct == "soulmate" || $orderProduct == "futurespouse" || $orderProduct =="twinflame") {
				    $image_send = 1;
					$prod_type = "";
					$img_folder_name = "general";

					$theader = $generalOrderHeader;
					$tfooter = $generalOrderFooter;

					if ($orderProduct == "soulmate") {
						$prod_type = "1";
					
					}elseif($orderProduct == "futurespouse"){
						$prod_type = "2";
					
					}elseif($orderProduct =="twinflame"){
						$prod_type = "3";
					
					}

					$age_max = $orderAge + 1;
					$age_min = $orderAge - 5;
					if ($age_max > 67) {
						$age_min = 63;
						$age_max = 67;
					}
					if ($age_min < 20) {
						$age_min = 20;
						$age_max = 24;
					}

					if($color == 1){
						$productSearch = "soulmatecolor";
					}else{
						$productSearch = "soulmate";
					}

					$sql_pick = "SELECT * FROM orders_image WHERE product = '$productSearch' AND age < '$age_max' AND age > '$age_min' AND sex = '$orderSex' order by RAND() limit 1";
					$sql_pick_res = $conn->query($sql_pick);
					if($sql_pick_res->num_rows == 0) {
							 $image_name = "";
							 $logError[] = "Missing Image";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);

					} else {
						while($rowImages = $sql_pick_res->fetch_assoc()) {
							$image_name = $rowImages["name"];
						}
					}


					if($reading == 0 AND $premium == 1){

						$generalOrderHeader = $generalOrderHeaderNoReading;
						$generalOrderFooter = $generalOrderFooterNoReading;
						$message = $theader.$premiumText.$tfooter;
					}else{

					$sql_text = "SELECT * FROM orders_text WHERE product = '$orderProduct' AND gender = '$orderSex' AND user_gender='$userSex' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
							 $email_text = "";
							 $logError[] = "Missing Text";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text = $rowText["text"];
						    $message = $theader.$email_text.$premiumText.$tfooter;
						}
					}

				  }

				}elseif ($orderProduct == "pastlife")  { 

					$image_send = 1;
					$prod_type = "pastlife";
					$img_folder_name = "pastlife";

					$theader = $generalOrderHeader;
					$tfooter = $generalOrderFooter;

					$sql_pick = "SELECT * FROM orders_image WHERE product = '$orderProduct' AND sex = '$orderSex' order by RAND() limit 1";
					$sql_pick_res = $conn->query($sql_pick);
					if($sql_pick_res->num_rows == 0) {
							 $image_name = "";
							 $logError[] = "Missing Image";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);

					} else {
						while($rowImages = $sql_pick_res->fetch_assoc()) {
							$image_name = $rowImages["name"];
						}
					}


					$sql_text = "SELECT * FROM orders_text WHERE product = '$orderProduct' AND gender = '$orderSex' AND user_gender='$userSex' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
							 $email_text = "";
							 $logError[] = "Missing Text";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text = $rowText["text"];
						    $message = $theader.$email_text.$tfooter;
						}
					}


				}elseif ($orderProduct == "higherself")  { 

					$image_send = 1;
					$prod_type = "higherself";
					$img_folder_name = "higherself";

					$theader = $generalOrderHeader;
					$tfooter = $generalOrderFooter;

					$sql_pick = "SELECT * FROM orders_image WHERE product = '$orderProduct' AND sex = '$orderSex' order by RAND() limit 1";
					$sql_pick_res = $conn->query($sql_pick);
					if($sql_pick_res->num_rows == 0) {
							 $image_name = "";
							 $logError[] = "Missing Image";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);

					} else {
						while($rowImages = $sql_pick_res->fetch_assoc()) {
							$image_name = $rowImages["name"];
						}
					}


					$sql_text = "SELECT * FROM orders_text WHERE product = '$orderProduct' AND gender = '$orderSex' AND user_gender='$userSex' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
							 $email_text = "";
							 $logError[] = "Missing Text";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text = $rowText["text"];
						    $message = $theader.$email_text.$tfooter;
						}
					}

				}elseif ($orderProduct == "spiritguide")  { 

					$image_send = 1;
					$prod_type = "spiritguide";
					$img_folder_name = "spiritguide";

					$theader = $generalOrderHeader;
					$tfooter = $generalOrderFooter;

					$sql_pick = "SELECT * FROM orders_image WHERE product = '$orderProduct' AND sex = '$orderSex' order by RAND() limit 1";
					$sql_pick_res = $conn->query($sql_pick);
					if($sql_pick_res->num_rows == 0) {
							 $image_name = "";
							 $logError[] = "Missing Image";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);

					} else {
						while($rowImages = $sql_pick_res->fetch_assoc()) {
							$image_name = $rowImages["name"];
						}
					}


					$sql_text = "SELECT * FROM orders_text WHERE product = '$orderProduct' AND gender = '$orderSex' AND user_gender='$userSex' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
							 $email_text = "";
							 $logError[] = "Missing Text";
							 $logError[] = $orderID;
							 $logError[] = $orderEmail;
							 missingLog($logError);
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
					

				$sql_pick = "SELECT * FROM  orders_image WHERE product = 'baby' AND sex = '$babyGender' order by RAND() limit 1";
				$sql_pick_res = $conn->query($sql_pick);
				
				if($sql_pick_res->num_rows == 0) {
					$image_name = "";
					$missingTest = 1;
					$logError[] = "Missing Image";
					$logError[] = $orderID;
					$logError[] = $orderEmail;
					missingLog($logError);
				} else {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
					$image_name = $rowImages['name'];
					}
				}
				$sql_text = "SELECT * FROM orders_text WHERE product = 'baby' AND gender = '$babyGender' order by RAND() limit 1";
				$sql_text_res = $conn->query($sql_text);
				if($sql_text_res->num_rows == 0) {
						$email_text = "";
						$missingTest = 1;
						$logError[] = "Missing Text";
						$logError[] = $orderID;
						$logError[] = $orderEmail;
						missingLog($logError);
				} else {
					while($rowText = $sql_text_res->fetch_assoc()) {
						$email_text = $rowText['text'];
						$message = $theader.$email_text.$tfooter;
						
					}
				}
				//END IF PRODUCT = FUTURE BABY




				}elseif (strpos($orderProduct, 'general') !== false || strpos($orderProduct, 'love') !== false || strpos($orderProduct, 'career') !== false || strpos($orderProduct, 'health') !== false) {
				$image_send = 0;
				$email_text = "";
				$theader = $readingOrderHeader;
				$tfooter = $readingOrderFooter;
				$finishOrder = 1;
				if (strpos($orderProduct, 'general') !== false) {

					$sql_text = "SELECT * FROM orders_text WHERE product = 'general' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'love') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'love' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'career') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'career' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if (strpos($orderProduct, 'health') !== false) {
					$sql_text = "SELECT * FROM orders_text WHERE product = 'health' order by RAND() limit 1";
					$sql_text_res = $conn->query($sql_text);
					if($sql_text_res->num_rows == 0) {
					} else {
						while($rowText = $sql_text_res->fetch_assoc()) {
							$email_text .= $rowText["text"] . "\n\n";
						}
					}
				}
				if($email_text == ""){
					$missingTest = 1;
					$logError[] = "Missing Text";
					$logError[] = $orderID;
					$logError[] = $orderEmail;
					missingLog($logError);
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
					 $missingTest = 1;
					 $logError[] = "Missing Image";
					 $logError[] = $orderID;
					 $logError[] = $orderEmail;
					 missingLog($logError);
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
						$missingTest = 1;
						$logError[] = "Missing Text";
						$logError[] = $orderID;
						$logError[] = $orderEmail;
						missingLog($logError);
				} else {
					while($rowText = $sql_text_res->fetch_assoc()) {
						$email_text = $rowText["text"];
						$message = $theader.$email_text.$tfooter;
					}
				}
				// end of past life
			}elseif ($orderProduct == "spirit") {
				$trigger = 1;
				$image_send = 0;
				$email_text = "";
				$theader = $spiritOrderHeader;
				$tfooter = $spiritOrderFooter;
				$finishOrder = 1;


				  //Find new message text to send
				  $sql_pick = "SELECT * FROM spirit_text WHERE message_count = '1' order by RAND() limit 1";
				  $sql_pick_res = $conn->query($sql_pick);
				  if($sql_pick_res->num_rows > 0) {
					while($rowImages = $sql_pick_res->fetch_assoc()) {
						$email_text = $rowImages["text"];
						$message = $theader.$email_text.$tfooter;
					}
				  }else{ //If not found stop the process and record to error log
					$message = "";
					$logError[] = "Missing Text";
					$logError[] = $orderID;
					$logError[] = $orderEmail;
					missingLog($logError);
				  }
			
			}
			

			$message = str_replace("%FIRSTNAME%", $fName, $message);
			if ($image_send == "1" && $text_send == "1") { //SEND IMAGE START
						// define image name and new path
							$rootDir = $_SERVER['DOCUMENT_ROOT'];
							$ext = ".jpg";
							$sPath = "/assets/order/images/general/";
							$randomImageName = rand(55547,75547);

						// Old Paths
					        $oldImagename = $image_name;
							$oldImageShortPath = "/assets/order/images/".$img_folder_name."/".$image_name.$ext;
							
							$oldImageFullPath = $base_url.$oldImageShortPath;
							
							$oldImageServerPath = $rootDir .$oldImageShortPath;

						// new Paths
							$newImagename = $orderProduct ."-" .$randomImageName ."-" .$orderID .$ext;
							$newImageShortPath = "/assets/email/delivery-images/".$newImagename;
							$newImageServerPath = $rootDir .$newImageShortPath;
							$newImageFullPath = $base_url .$newImageShortPath;

						//	echo 'New Image path = <a href="' .$newImageFullPath .'">' .$newImageFullPath ."</a><br> Old image path = ".$oldImageFullPath ."<br></a><br> ";
							echo $img_folder_name.'/'.$oldImagename.'.jpg | ';
							echo $newImagename.' | ';

						// Set new image path and name
							$newImageNameHash = copy($oldImageServerPath, $newImageServerPath);


							$ch = curl_init();
							$authorization = "Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98";
							curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/files');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);
							
						// Set image data for upload via CURL
						
                            $filename = $rootDir.'/assets/email/delivery-images/'.$newImagename;
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
								$finishOrder = 0;
							}else{
								$finishOrder = 1;
							}
							curl_close ($ch);
						    //echo $attachment;
						    $token = json_decode($attachment);
                            $Atoken_key = $token->attachmentToken;
						

			if($finishOrder == 1 && $missingTest == 0){
                // curl implementation
                $ch = curl_init();
                $data = [[
                "text" => $message,
                "sender"  => "soulmateAdminNew",
                "type" => "UserMessage"
				],[
				"attachmentToken" => $Atoken_key,
				"sender"  => "soulmateAdminNew",
				"type" => "UserMessage"
				],[
				"text" => $OrderCompleteMessage,
				"type" => "SystemMessage"
				],[
				"text" => $ContinueConvoMsg,
				"type" => "SystemMessage"
				]];

                $data1 = json_encode($data);

                curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/' . $row["order_id"] . '/messages');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

                curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
				//$logArray['4'] = $message;
				

				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
					$updateOrder = 0;
					$logArray[] = "TalkJS NOT Updated!" . curl_error($ch);
				}else{
					$updateOrder = 1;
					$logArray[] = "TalkJS Updated";
				}

                curl_close($ch);
				$logArray[] = $result;
                //SEND IMAGE END
			}
                	
			}elseif($image_send == "0" && $text_send == "1"){//SEND ONLY TEXT START
					  // curl implementation


					$finishOrder = 1;

					if($missingTest == 0){
						if($orderProduct == "spirit"){
							$ch = curl_init();
							$data = [[
							"text" => $message,
							"sender"  => "soulmateAdminNew",
							"type" => "UserMessage"
							]];
						}else{
					$ch = curl_init();
					$data = [[
					"text" => $message,
					"sender"  => "soulmateAdminNew",
					"type" => "UserMessage"
					],[
					"text" => $OrderCompleteMessage,
					"type" => "SystemMessage"
					],[
					"text" => $ContinueConvoMsg,
					"type" => "SystemMessage"
					]];

				}

					$data1 = json_encode($data);
				  
	  
					  curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/' . $row["order_id"] . '/messages');
					  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	  
					  curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
	  
					  $headers = array();
					  $headers[] = 'Content-Type: application/json';
					  $headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
					  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	  
					  $result = curl_exec($ch);
					  $logArray[] = $result;
					  if (curl_errno($ch)) {
						echo 'Error:' . curl_error($ch);
						$updateOrder = 0;
						$logArray[] = "TalkJS NOT Updated!" . curl_error($ch);
					}else{
						$updateOrder = 1;
						$logArray[] = "TalkJS Updated";
					}
					  curl_close($ch);	
					  $logArray[] = $result;	
					}

				
			}elseif($image_send == "1" && $text_send == "0"){ // Send Only Image
				$message = $generalOrderNoReading;
				$message = str_replace("%FIRSTNAME%", $fName, $message);
// define image name and new path
$rootDir = $_SERVER['DOCUMENT_ROOT'];
$ext = ".jpg";
$sPath = "/assets/order/images/general/";
$randomImageName = rand(55547,75547);

// Old Paths
$oldImagename = $image_name;
$oldImageShortPath = "/assets/order/images/".$img_folder_name."/".$image_name.$ext;

$oldImageFullPath = $base_url.$oldImageShortPath;

$oldImageServerPath = $rootDir .$oldImageShortPath;

// new Paths
$newImagename = $orderProduct ."-" .$randomImageName ."-" .$orderID .$ext;
$newImageShortPath = "/assets/email/delivery-images/".$newImagename;
$newImageServerPath = $rootDir .$newImageShortPath;
$newImageFullPath = $base_url .$newImageShortPath;

//	echo 'New Image path = <a href="' .$newImageFullPath .'">' .$newImageFullPath ."</a><br> Old image path = ".$oldImageFullPath ."<br></a><br> ";
echo $img_folder_name.'/'.$oldImagename.'.jpg | ';
echo $newImagename.' | ';

// Set new image path and name
$newImageNameHash = copy($oldImageServerPath, $newImageServerPath);


$ch = curl_init();
$authorization = "Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98";
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/files');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

// Set image data for upload via CURL

$filename = $rootDir.'/assets/email/delivery-images/'.$newImagename;
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
	$finishOrder = 0;
}else{
	$finishOrder = 1;
}
curl_close ($ch);
//echo $attachment;
$token = json_decode($attachment);
$Atoken_key = $token->attachmentToken;


if($finishOrder == 1 && $missingTest == 0){
// curl implementation
$ch = curl_init();
$data = [[
"text" => $message,
"sender"  => "soulmateAdminNew",
"type" => "UserMessage"
],[
"attachmentToken" => $Atoken_key,
"sender"  => "soulmateAdminNew",
"type" => "UserMessage"
],[
"text" => $OrderCompleteMessage,
"type" => "SystemMessage"
],[
"text" => $ContinueConvoMsg,
"type" => "SystemMessage"
]];

$data1 = json_encode($data);

curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/' . $row["order_id"] . '/messages');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
//$logArray['4'] = $message;


if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
$updateOrder = 0;
$logArray[] = "TalkJS NOT Updated!" . curl_error($ch);
}else{
$updateOrder = 1;
$logArray[] = "TalkJS Updated";
}

curl_close($ch);
$logArray[] = $result;
//SEND IMAGE END
}



			}
			


				// Set order to shipped
			if($updateOrder==1 && $missingTest == 0){
			$sqlupdate = "UPDATE `orders` SET `order_status`='shipped' WHERE order_id='$orderID'";
			if ($conn->query($sqlupdate) === TRUE) {
		    echo "<br> Updated";

		}else{
			echo "<br> Order NOT Updated!";

		}

	

// curl implementation
$ch = curl_init();
$data = [
"custom" => ["status" => "Completed"]
];
$data1 = json_encode($data);
print_r($data1);
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/ArJWsup2/conversations/'.$orderID);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: Bearer sk_live_Ncow50B9RdRQFeXBsW45c5LFRVYLCm98';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
curl_close($ch);
//Change chat order status
}
if($trigger==1){
formLog($logArray);
}


	}
		} 	// end of loop



	}
	 // end of processing
?>