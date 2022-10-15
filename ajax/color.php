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
$order_ID = $_POST['order_id'];
    if($submit == "NoThanks"){
        $_SESSION['fbfireUpsellpixel'] = 0;
        $submitStatus = "NoThanks";
        $RedirectURL = "https://soulmateps.pay.clickbank.net/?cbur=d&cbitems=14";
        $returnData = [$submitStatus,$RedirectURL];
        echo json_encode($returnData);
    }else{


$redirectPayment = "https://gabeaff_melissapsy.pay.clickbank.net/?cbur=a&cbfid=52260&cbitems=14&cbskin=39040&order_ID=".$order_ID."&main_ID=".$order_ID;
$submitStatus = "Success";
$SuccessMessage = "Redirecting you to Payment Page Now!";
$returnData = [$submitStatus,$SuccessMessage,$redirectPayment];
echo json_encode($returnData);


}
}else{
echo "Direct access is not allowed!";  
}


?>