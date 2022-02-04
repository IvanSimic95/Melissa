<?php
$randomNumber = rand(155654654,955654654);
if(!isset($_SESSION['user_cookie_id'])) {
$_SESSION['user_cookie_id'] = $randomNumber;
}
?>