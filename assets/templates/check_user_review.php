<?php
// set parameters and execute
$order_email = $_POST['check_email'];
// echo "order email=" . $order_email;
?>

<?php
$domain = $_SERVER['SERVER_NAME'];
	if($domain == "melissa.test"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "melissap_melissa";
}else{
    $servername = "localhost";
    $username = "melissap_melissapsychic";
    $password = ";w[#i&[zcrm?";
    $dbname = "melissap_melissa";
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM orders WHERE order_email = '$order_email'";

$result = $conn->query($sql);


$referrer  = $_SERVER['HTTP_REFERER'];
$referrer = strtok($referrer, '?');
$referrerYes = $referrer ."?status=no_orders";
// echo $referrerYes;
$referrerNo = $referrer ."?postas=" . $order_email;
// echo $referrerNo;

if($result->num_rows == 0 || $order_email == "") {

   header("Location: $referrerYes");
   die();


} else {
   header("Location: $referrerNo");
   die();
}
 ?>
