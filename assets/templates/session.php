<?php

// Generating a random number in a
// Specified range.



$randomNumber = rand(155654654,955654654);
$_SESSION['user_cookie_id'] = $randomNumber;
if(!isset($_SESSION['user_cookie_id'])) {
$_SESSION['user_cookie_id'] = $randomNumber;

}

?>
