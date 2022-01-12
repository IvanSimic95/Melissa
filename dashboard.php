<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = $order_name = $order_email = "";

if(isset($_SESSION['email'])){

$order_email = $_SESSION['email'];
}else{

// set parameters and execute
if(isset($_GET['check_email'])) {
$order_email = $_GET['check_email'];}

if(isset($_GET['username'])) {
$order_name = str_replace('%20', ' ', $_GET['username']);}


}

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

$sql = "SELECT * FROM orders WHERE order_email = '$order_email' OR user_name = '$order_name '";

$result = $conn->query($sql);

if( ($result->num_rows == 0 || $order_email == "") && ($result->num_rows == 0 || $order_name == "")) {

			if($order_email==""){$error = "";}else{$error = "Email is not valid, account not found!";}

   include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/check_user.php';

} else {

$_SESSION['valid'] = true;
$_SESSION['timeout'] = time();
$_SESSION['email'] = $order_email;

include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/signed_in2.php';
}

 ?>
