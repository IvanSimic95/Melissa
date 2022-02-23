<?php
//Check if session is set, if not set a new one
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
session_start();
}

//Check if user cookie ID is set, if not set a new one
$randomNumber = rand(155654654,955654654);
if(!isset($_SESSION['user_cookie_id'])) {
$_SESSION['user_cookie_id'] = $randomNumber;
}

$randomNumber2 = rand(155654654,955654654);
if(!isset($_SESSION['user_cookie_id2'])) {
$_SESSION['user_cookie_id2'] = $randomNumber2;
}

$randomNumber3 = rand(155654654,955654654);
if(!isset($_SESSION['user_cookie_id3'])) {
$_SESSION['user_cookie_id3'] = $randomNumber2;
}

//Check if funnel page is set, if not set a new one
if(!isset($_SESSION['funnel_page'])) {
$_SESSION['funnel_page'] = "main";
}

if(isset($_GET['logout'])){
$_SESSION = array();
session_destroy();
}
?>