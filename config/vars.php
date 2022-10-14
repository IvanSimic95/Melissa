<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php';
date_default_timezone_set('Europe/Bucharest');
error_reporting(E_ALL);
ini_set('display_errors', '1');

$startpixel  = 1;
$startpixel2 = 1;
$startpixel3 = 1;
$FBPixel  = "3290293207717814";
$FBPixel2 = "849174466483788";
$FBPixel3 = "792407324843664";
$FBPurchasePixel = "";
$FBViewContent = "";
$productMETA = "";

$sendg1 = "SG.IbkVjaCLQymTp7Esy9F";
$sendg2 = "-uQ.WlamcbbyqJ5DZRqdWqC5ecAQPsudMsAjFBtgoVL1ttw";
$sendg3 = $sendg1.$sendg2;

//Data for FB Conversions API
$accessToken1 = "EAAxkvwzdc3kBAM3YGxUaEygEr7cdXJ9bxE8hGZC2tfmkW9BXAWZA67HcZB0SyoDYrMLs9Afgp086Yqm55zDg";
$accessToken2 = "DZAdoLErhsa7kHwFJVZA7C6HBMqdIsERWoJ8zXZAeaQtDqFgAMCTa8K0kVMdp3EPZBYGhnOjPjTOg9KkjPelq9Mu1qmvU9iTZBrm";
$fbAccessToken = $accessToken1.$accessToken2;
$sendFBAPI = 1; #Set to 1 to send data via api

if(!isset($_SESSION['PixelDATA'])){
$_SESSION['PixelDATA'] = 0;
}

#error_reporting(0);
#ini_set('display_errors', 0);


//START Order Messages
$processingWelcome = "We are now processing your *Order #%ORDERID%*\n\nYour order will be delivered to your email in %PRIORITY% hours or less.\n\nIf this is your first order your new account will be created automatically\n\nIn order to automatically login to your account just <%EMAILLINK%|Click Here!>\n\n_With Love!_\n*Melissa*";


//Complete Soulmate, Twin Flame & Future Spouse Text added Before and After Order Text
$generalOrderHeader = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! As we continue, please make yourself comfortable and feel wholeheartedly everything I've seen while connecting with your aura and energy. I hope that sharing this with you will kindle a light of joy in your heart, and let you know that beautiful things are on the way.\n\n";
$generalOrderFooter = "\n It was such a pleasure doing your reading, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa* \n\n Important: While connecting with your energy, I noticed that you have some unresolved emotional issues that may stop you from fully giving and receiving love from your loved ones and your future partner. I've already talked to Isabella, my spiritual mentor, about your situation. She said she is more than happy to help you heal everything and is waiting for your message. Please reach out to her as soon as you can:  fb HealerIsabella https://m.me/HealerIsabella or IG @healerisabella.
";

//Complete text used when user purchased premium but no reading
$generalOrderHeaderNoReading = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! Your drawing is complete and I hope you will enjoy it!";
$generalOrderFooterNoReading = "\n It was such a pleasure doing your drawing, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa* \n\n My dear, I sensed that over the last few years you have had the inability to receive love because of a blockage at your Heart Chakra level. I noticed some problems and I strongly recommend you contact Amelia, my mentor, and she helped me deal with my emotional journey. She is already aware of your case and she will help you move on from past experiences and find your path. For more details please talk to her directly on fb messenger: https://m.me/HealerIsabella ";

//Complete text when user purchased no reading and no premium
$generalOrderNoReading = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! Your drawing is complete and I hope you will enjoy it! \n It was such a pleasure doing your drawing, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa* \n\n My dear, I sensed that over the last few years you have had the inability to receive love because of a blockage at your Heart Chakra level. I noticed some problems and I strongly recommend you contact Amelia, my mentor, and she helped me deal with my emotional journey. She is already aware of your case and she will help you move on from past experiences and find your path. For more details please talk to her directly on fb messenger: https://m.me/HealerIsabella ";


//Complete Future Baby Text added Before and After Order Text
$babyOrderHeader = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! As we continue, please make yourself comfortable and feel wholeheartedly everything I've seen while connecting with your aura and energy. I hope that sharing this with you will kindle a light of joy in your heart, and let you know that beautiful things are on the way.\n\n";
$babyOrderFooter = "\n\n It was such a pleasure doing your reading, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa*";

//Complete Reading Text added Before and After Order Text
$readingOrderHeader = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! As we continue, please make yourself comfortable and feel wholeheartedly everything I've seen while connecting with your aura and energy. I hope that sharing this with you will kindle a light of joy in your heart, and let you know that beautiful things are on the way.\n\n";
$readingOrderFooter = "\n\n It was such a pleasure doing your reading, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa*";

//Complete Past Life Text added Before and After Order Text
$pastOrderHeader = "Dear %FIRSTNAME%\n\nFirst of all, thank you so much for giving me the opportunity to create a meaningful connection with you! As we continue, please make yourself comfortable and feel wholeheartedly everything I've seen while connecting with your aura and energy. I hope that sharing this with you will kindle a light of joy in your heart, and let you know that beautiful things are on the way.\n\n";
$pastOrderFooter = "\n\n It was such a pleasure doing your reading, my dear. I hope that you enjoy it as much as I enjoyed connecting with your beautiful soul energy!\n\nWith Love,\n*Melissa*";


//Order Processing & Order Complete Notifications
$OrderProcessingMessage = "Your Order status is now set to *Processing*!";

$OrderCompleteMessage = "Your Order status is now set to *Complete*!";
$ContinueConvoMsg = "If you want to chat with Melissa, simply reply to this conversation!";
//END Order Messages


//EMAIL TEXTS
$AbandonSubject = "The Timer’s Going Off on Your Order!";
$AbandonMessage = "Look's like you forgot to finish your order... But don't worry, we kept it safe for you! Click the button below to finish your purchase & get closer to your soulmate.";

//Save to order log function
function formLog($array) {
    $dataToLog = $array;
    $data = implode(" | ", $dataToLog);
    $data .= PHP_EOL;
    $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/order.log";
    $success = file_put_contents($pathToFile, $data, FILE_APPEND);
    if ($success === TRUE){
      echo "log saved";
    }
  }

  //Save to order log function
function formLogNew($array) {
  $dataToLog = $array;
  $data = json_encode($dataToLog);
  $data .= PHP_EOL;
  $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/test.log";
  $success = file_put_contents($pathToFile, $data, FILE_APPEND);
  if ($success === TRUE){
    echo "log saved";
  }
}

function formLogNewAgain($array){
  $dataToLog = $array;
  $data = implode(" | ", $dataToLog);
  $data .= PHP_EOL;
  $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/paid.log";
  $success = file_put_contents($pathToFile, $data, FILE_APPEND);
  if ($success === TRUE){
    echo "log saved";
  }
}

//Save to order log function
function startLog($array) {
  $dataToLog = $array;
  $data = implode(" | ", $dataToLog);
  $data .= PHP_EOL;
  $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/start.log";
  $success = file_put_contents($pathToFile, $data, FILE_APPEND);
  if ($success === TRUE){
    echo "log saved";
  }
}

//Save to order log function
function missingLog($array) {
  $dataToLog = $array;
  $data = implode(" | ", $dataToLog);
  $data .= PHP_EOL;
  $pathToFile = $_SERVER['DOCUMENT_ROOT']."/logs/missing.log";
  $success = file_put_contents($pathToFile, $data, FILE_APPEND);
  if ($success === TRUE){
    echo "log saved";
  }
}



//Find First and Last name
function splitNames($name) {
  $apiKey = 'Whc29bSnvP3zrQG3hYCwXKMoYu5h4ZQukS6n'; //Your API Key
  $getNames = json_decode(file_get_contents('https://gender-api.com/get?key=' . $apiKey . '&split=' . urlencode($name)));
  $data = [[
          "fname" => $getNames->first_name,
          "lname"  => $getNames->last_name
          ]];
  return $data;
  }
  
  //Find User Gender
  function findGender($name) {
  $apiKey = 'Whc29bSnvP3zrQG3hYCwXKMoYu5h4ZQukS6n'; //Your API Key
  $getGender = json_decode(file_get_contents('https://gender-api.com/get?key=' . $apiKey . '&name=' . urlencode($name)));
  $data = [[
          "gender" => $getGender->gender,
          "accuracy"  => $getGender->accuracy
          ]];
  return $data;
  }


  function escapeJsonString($value) {
    $escapers =     array("\\",     "/",   "\"",  "\n",  "\r",  "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
  }



function normalizeChars($s) {
  $replace = array(
      'ъ'=>'-', 'Ь'=>'-', 'Ъ'=>'-', 'ь'=>'-',
      'Ă'=>'A', 'Ą'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
      'Þ'=>'B',
      'Ć'=>'C', 'ץ'=>'C', 'Ç'=>'C',
      'È'=>'E', 'Ę'=>'E', 'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
      'Ğ'=>'G',
      'İ'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
      'Ł'=>'L',
      'Ñ'=>'N', 'Ń'=>'N',
      'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
      'Ş'=>'S', 'Ś'=>'S', 'Ș'=>'S', 'Š'=>'S',
      'Ț'=>'T',
      'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
      'Ý'=>'Y',
      'Ź'=>'Z', 'Ž'=>'Z', 'Ż'=>'Z',
      'â'=>'a', 'ǎ'=>'a', 'ą'=>'a', 'á'=>'a', 'ă'=>'a', 'ã'=>'a', 'Ǎ'=>'a', 'а'=>'a', 'А'=>'a', 'å'=>'a', 'à'=>'a', 'א'=>'a', 'Ǻ'=>'a', 'Ā'=>'a', 'ǻ'=>'a', 'ā'=>'a', 'ä'=>'ae', 'æ'=>'ae', 'Ǽ'=>'ae', 'ǽ'=>'ae',
      'б'=>'b', 'ב'=>'b', 'Б'=>'b', 'þ'=>'b',
      'ĉ'=>'c', 'Ĉ'=>'c', 'Ċ'=>'c', 'ć'=>'c', 'ç'=>'c', 'ц'=>'c', 'צ'=>'c', 'ċ'=>'c', 'Ц'=>'c', 'Č'=>'c', 'č'=>'c', 'Ч'=>'ch', 'ч'=>'ch',
      'ד'=>'d', 'ď'=>'d', 'Đ'=>'d', 'Ď'=>'d', 'đ'=>'d', 'д'=>'d', 'Д'=>'D', 'ð'=>'d',
      'є'=>'e', 'ע'=>'e', 'е'=>'e', 'Е'=>'e', 'Ə'=>'e', 'ę'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'Ē'=>'e', 'Ė'=>'e', 'ė'=>'e', 'ě'=>'e', 'Ě'=>'e', 'Є'=>'e', 'Ĕ'=>'e', 'ê'=>'e', 'ə'=>'e', 'è'=>'e', 'ë'=>'e', 'é'=>'e',
      'ф'=>'f', 'ƒ'=>'f', 'Ф'=>'f',
      'ġ'=>'g', 'Ģ'=>'g', 'Ġ'=>'g', 'Ĝ'=>'g', 'Г'=>'g', 'г'=>'g', 'ĝ'=>'g', 'ğ'=>'g', 'ג'=>'g', 'Ґ'=>'g', 'ґ'=>'g', 'ģ'=>'g',
      'ח'=>'h', 'ħ'=>'h', 'Х'=>'h', 'Ħ'=>'h', 'Ĥ'=>'h', 'ĥ'=>'h', 'х'=>'h', 'ה'=>'h',
      'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'į'=>'i', 'ĭ'=>'i', 'ı'=>'i', 'Ĭ'=>'i', 'И'=>'i', 'ĩ'=>'i', 'ǐ'=>'i', 'Ĩ'=>'i', 'Ǐ'=>'i', 'и'=>'i', 'Į'=>'i', 'י'=>'i', 'Ї'=>'i', 'Ī'=>'i', 'І'=>'i', 'ї'=>'i', 'і'=>'i', 'ī'=>'i', 'ĳ'=>'ij', 'Ĳ'=>'ij',
      'й'=>'j', 'Й'=>'j', 'Ĵ'=>'j', 'ĵ'=>'j', 'я'=>'ja', 'Я'=>'ja', 'Э'=>'je', 'э'=>'je', 'ё'=>'jo', 'Ё'=>'jo', 'ю'=>'ju', 'Ю'=>'ju',
      'ĸ'=>'k', 'כ'=>'k', 'Ķ'=>'k', 'К'=>'k', 'к'=>'k', 'ķ'=>'k', 'ך'=>'k',
      'Ŀ'=>'l', 'ŀ'=>'l', 'Л'=>'l', 'ł'=>'l', 'ļ'=>'l', 'ĺ'=>'l', 'Ĺ'=>'l', 'Ļ'=>'l', 'л'=>'l', 'Ľ'=>'l', 'ľ'=>'l', 'ל'=>'l',
      'מ'=>'m', 'М'=>'m', 'ם'=>'m', 'м'=>'m',
      'ñ'=>'n', 'н'=>'n', 'Ņ'=>'n', 'ן'=>'n', 'ŋ'=>'n', 'נ'=>'n', 'Н'=>'n', 'ń'=>'n', 'Ŋ'=>'n', 'ņ'=>'n', 'ŉ'=>'n', 'Ň'=>'n', 'ň'=>'n',
      'о'=>'o', 'О'=>'o', 'ő'=>'o', 'õ'=>'o', 'ô'=>'o', 'Ő'=>'o', 'ŏ'=>'o', 'Ŏ'=>'o', 'Ō'=>'o', 'ō'=>'o', 'ø'=>'o', 'ǿ'=>'o', 'ǒ'=>'o', 'ò'=>'o', 'Ǿ'=>'o', 'Ǒ'=>'o', 'ơ'=>'o', 'ó'=>'o', 'Ơ'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
      'פ'=>'p', 'ף'=>'p', 'п'=>'p', 'П'=>'p',
      'ק'=>'q',
      'ŕ'=>'r', 'ř'=>'r', 'Ř'=>'r', 'ŗ'=>'r', 'Ŗ'=>'r', 'ר'=>'r', 'Ŕ'=>'r', 'Р'=>'r', 'р'=>'r',
      'ș'=>'s', 'с'=>'s', 'Ŝ'=>'s', 'š'=>'s', 'ś'=>'s', 'ס'=>'s', 'ş'=>'s', 'С'=>'s', 'ŝ'=>'s', 'Щ'=>'sch', 'щ'=>'sch', 'ш'=>'sh', 'Ш'=>'sh', 'ß'=>'ss',
      'т'=>'t', 'ט'=>'t', 'ŧ'=>'t', 'ת'=>'t', 'ť'=>'t', 'ţ'=>'t', 'Ţ'=>'t', 'Т'=>'t', 'ț'=>'t', 'Ŧ'=>'t', 'Ť'=>'t', '™'=>'tm',
      'ū'=>'u', 'у'=>'u', 'Ũ'=>'u', 'ũ'=>'u', 'Ư'=>'u', 'ư'=>'u', 'Ū'=>'u', 'Ǔ'=>'u', 'ų'=>'u', 'Ų'=>'u', 'ŭ'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ů'=>'u', 'ű'=>'u', 'Ű'=>'u', 'Ǖ'=>'u', 'ǔ'=>'u', 'Ǜ'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'У'=>'u', 'ǚ'=>'u', 'ǜ'=>'u', 'Ǚ'=>'u', 'Ǘ'=>'u', 'ǖ'=>'u', 'ǘ'=>'u', 'ü'=>'ue',
      'в'=>'v', 'ו'=>'v', 'В'=>'v',
      'ש'=>'w', 'ŵ'=>'w', 'Ŵ'=>'w',
      'ы'=>'y', 'ŷ'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Ŷ'=>'y',
      'Ы'=>'y', 'ž'=>'z', 'З'=>'z', 'з'=>'z', 'ź'=>'z', 'ז'=>'z', 'ż'=>'z', 'ſ'=>'z', 'Ж'=>'zh', 'ж'=>'zh'
  );
  return strtr($s, $replace);
}

//START Database Configuration
$domain = $_SERVER['HTTP_HOST'];
if($domain == "melissa.test"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "melissa";
	$base_url = "https://melissa.test";
}else{
    $servername = "localhost";
    $username = "melissap_melissapsychic";
    $password = ";w[#i&[zcrm?";
    $dbname = "melissap_website";
	$base_url = "https://melissa-psychic.com";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query('set character_set_client=utf8');
$conn->query('set character_set_connection=utf8');
$conn->query('set character_set_results=utf8');
$conn->query('set character_set_server=utf8');
$conn->set_charset('utf8mb4');

// Check connection
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
//END Database Configuration



if(isset($_GET['utm_campaign'])){
  $fbTrack = 1;
  
  $fbVariable = $_GET['utm_campaign'];
  $ex = explode(" ",$fbVariable);
  
  $fbCampaign = $ex["0"];
  $fbAdset = $ex["1"];
  $fbAd = $ex["2"];
  
  //Set fb ads session variables
  $_SESSION['fbCampaign'] = $fbCampaign;
  $_SESSION['fbAdset'] = $fbAdset;
  $_SESSION['fbAd'] = $fbAd;
  }else{
  $fbTrack = 0;
  
    $fbCampaign = "";
    $fbAdset = "";
    $fbAd = "";
  
    if(!isset($_SESSION['fbCampaign'])){
      $_SESSION['fbCampaign'] = $fbCampaign;
    }
  
    if(!isset($_SESSION['fbAdset'])){
      $_SESSION['fbAdset'] = $fbAdset;
    }
  
    if(!isset($_SESSION['fbAd'])){
      $_SESSION['fbAd'] = $fbAd;
    }
  
  }
  

?>