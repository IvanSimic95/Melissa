<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
include $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// set parameters and execute
$cookie_id = $_GET['cookie_id'];
$user_age = $_GET['form_year'];
$user_name = $_GET['form_name'];
$order_product = $_GET['product'];
$order_priority = $_GET['priority'];
$order_date = date('Y-m-d H:i:s');
$partnerGender = "male";

//Full name -> First and Last Name
$parser = new TheIconic\NameParser\Parser();
$name = $parser->parse($user_name);

$fName = $name->getFirstname();
$lName = $name->getLastname();


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

$returnURL = "https://melissa-psychic.com/success.php";
$returnEncoded = base64_encode($returnURL);


if($user_name ) {




    $sql = "INSERT INTO orders (order_id, cookie_id, user_age, first_name, last_name, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id, user_sex, genderAcc, pick_sex)
                          VALUES (NULL, '$cookie_id', '$user_age', '$fName', '$lName', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '', '$userGender', '$userGenderAcc', '$partnerGender')";

    $lastRowInsert = mysqli_insert_id($conn);
    if ($conn->query($sql) === TRUE) {
      //echo "New record created successfully";
    } else {
      //echo "Error: " . $sql . "<br>" . $conn->error;
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
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
var prio = getUrlParameter('priority');
var product = getUrlParameter('product');

 window.location.href = "https://www.buygoods.com/secure/checkout.html?account_id=6274&product_codename=" + product + prio + "&subid=<?php echo $cookie_id; ?>&subid2=<?php echo $lastRowInsert; ?>&redirect=<?php echo $returnEncoded; ?>";
</script>


<?php
}else{
  header('Location: /');
}

 ?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>
