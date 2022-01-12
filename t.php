<?php
function randomDate($start_date, $end_date)
{
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d H:i:s', $val);
}

$i = 0;

while($i<150){
$cookie = rand(19482731, 194827311);
$age = rand(18, 60);
$user = "ivantest".rand(18, 60);
$status = "shipped";
$date = randomDate("2021-12-12", "2022-01-12");
$email = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5)."@test.com";
$product = "SOULMATE";
$priority ="24";
$price = rand(199, 499) / 10;
$bg = rand(123854, 129484);
$sex = "female";

echo "
INSERT INTO `orders` (`cookie_id`, `user_age`, `user_name`, `order_status`, `order_date`, `order_email`, `order_product`, `order_priority`, `order_price`, `buygoods_order_id`, `pick_sex`) 
VALUES ('".$cookie."', ".$age.", '".$user."', 'shipped', '".$date."', '".$email."', 'SOULMATE', 24, '".$price."', ".$bg.", 'female');
";






$i++;

}


?>