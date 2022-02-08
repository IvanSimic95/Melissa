<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
include $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

if(isset($_GET['skip'])){ 
  if($_GET['skip']=="yes"){ 
  $_SESSION['funnel_page'] = "funnel-complete";
  header('Location: /order-complete.php');
  die();
  }
}
$cookie_id = $_GET['cookie_id'];

$order_product = "baby";
$order_date = date('Y-m-d H:i:s');
$partnerGender = "male";

$fName = $_SESSION['orderFName'];
$lName = $_SESSION['orderLName'];

$user_name = $fName . $lName;

$user_age = $_SESSION['orderAge'];

$order_priority = $_GET['priority'];

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

    
$findGenderFunc = findGender($fName);
$userGender = $findGenderFunc['0']['gender'];
$userGenderAcc = $findGenderFunc['0']['accuracy'];

if($userGender=="male"){$partnerGender = "female";}
if($userGender=="female"){$partnerGender = "male";}

$returnURL = "https://melissa-psychic.com/order-complete.php";
$returnEncoded = base64_encode($returnURL);

if($cookie_id) {



  $sql = "INSERT INTO orders (cookie_id, user_age, first_name, last_name, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id, user_sex, genderAcc, pick_sex)
  VALUES ('$cookie_id', '$user_age', '$fName', '$lName', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '', '$userGender', '$userGenderAcc', '$partnerGender')";


    if ($conn->query($sql) === TRUE) {
      // echo "New record created successfully";
    } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>



<?php $title = "Order | Melissa Psychic"; ?>
<?php $description = "Order"; ?>
<?php $menu_order="men_0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>

<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Order
  </div>
</div>


<div class="general_section">
  <div class="container">
      <h1>You will be redirected to the Payment Processor. Please dont close this page</h1>
  </div>
</div>
<script>
var prio = getUrlParameter('priority');
var product = "baby";

window.location.href = "https://www.buygoods.com/secure/upsell?account_id=6274&product_codename=" + product + prio + "&subid=<?php echo $cookie_id; ?>&subid2=<?php echo $lastRowInsert; ?>&redirect=<?php echo $returnEncoded; ?>";
</script>






<?php
}else{
  header('Location: /');
}

 ?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>
