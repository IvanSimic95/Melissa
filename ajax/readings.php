<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

if(!$conn){ //CHECK DB CONNECTION FIRST
$submitStatus = "Database Error!";
$EMessage = 'Could not Connect to Database Server:'.mysql_error();
$returnData = [$submitStatus,$EMessage];
echo json_encode($returnData);
die();
}

$request = $_SERVER['REQUEST_METHOD'];

if ($request === 'POST') {
    
    $submit = $_POST['submitbtnselect'];
    if($submit == "NoThanks"){
        $_SESSION['fbfireUpsellpixel'] = 0;
        $submitStatus = "NoThanks";
        $RedirectURL = "https://melissapsy.pay.clickbank.net/?cbur=d&cbitems=5";
        $returnData = [$submitStatus,$RedirectURL];
        echo json_encode($returnData);
    }else{

$user_name = $_POST['form_name'];
$fName = $_POST['first_name'];
$lName = $_POST['last_name'];

$pricenow = $_POST['price'];

$cookie_id = $_POST['cookie_id'];
$birthday = $_POST['form_birthday'];
$user_age = $_POST['form_age'];

$user_birthday = $birthday;

$ReadingsCounter = 0;

if(isset($_POST['general'])) {
    $general = $_POST['general']." "; 
    $ReadingsCounter = $ReadingsCounter + 1;
}else{
    $general = "";
}

if(isset($_POST['love'])) {
    $love = $_POST['love']." "; 
    $ReadingsCounter = $ReadingsCounter + 1;
}else{
    $love = "";
}
if(isset($_POST['career'])) {
    $career = $_POST['career']." ";
    $ReadingsCounter = $ReadingsCounter + 1;
}else{
    $career = "";
}
if(isset($_POST['health'])) {
    $health = $_POST['health']; 
    $ReadingsCounter++;
}else{
    $health = "";
}

$quantity = $ReadingsCounter;

$order_product = $general.$love.$career.$health;
$order_priority = "24";

$order_date = date('Y-m-d H:i:s');

$bgemail = $_POST['bgemail'];

$userGender = $_POST['usergender'];
$partnerGender = $_POST['partnergender'];
$userGenderAcc = 100;
$order_product_nice = "Personal Reading";
$oStatus = "pending";

isset($_POST['fbp']) ? $uFBP = $_POST['fbp'] : $uFBP = "";
isset($_POST['fbc']) ? $uFBC = $_POST['fbc'] : $uFBC = "";

switch ($ReadingsCounter) {
    case 1:
        $personalIDcount = "5";
        break;

        case 2:
            $personalIDcount = "6";
            break;

            case 3:
                $personalIDcount = "7";
                break;

                case 4:
                    $personalIDcount = "8";
                    break;
    
    default:
    $personalIDcount = "5";
    break;

}


$sql = "INSERT INTO orders (cookie_id, user_age, first_name, last_name, user_name, birthday, order_status, order_date, order_email, order_product, order_product_nice, order_priority, order_price, buygoods_order_id, user_sex, genderAcc, pick_sex, fbc, fbp) VALUES 
('$cookie_id', '$user_age', '$fName', '$lName', '$user_name', '$user_birthday', '$oStatus', '$order_date', '$bgemail', '$order_product', '$order_product_nice', '$order_priority', '$pricenow', '', '$userGender', '$userGenderAcc', '$partnerGender', '$uFBC', '$uFBP')";

if(mysqli_query($conn,$sql)){
    $lastRowInsert = mysqli_insert_id($conn);
$redirectPayment = "https://melissapsy.pay.clickbank.net/?cbur=a&cbfid=52075&cbitems=".$personalIDcount."&cbskin=39040&order_ID=".$lastRowInsert;
$submitStatus = "Success";
$SuccessMessage = "Information saved, Redirecting you to Payment Page Now!";
$returnData = [$submitStatus,$SuccessMessage,$redirectPayment];
echo json_encode($returnData);
} else {
$submitStatus = "Error";
$ErrorMessage = "Error: " . $sql . "" . mysqli_error($conn);
$returnData = [$submitStatus,$ErrorMessage];
echo json_encode($returnData);
}
mysqli_close($conn);


}
}else{
echo "Direct access is not allowed!";  
}


?>