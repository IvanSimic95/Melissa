<?php

// Generating a random number in a
// Specified range.



$randomNumber = rand(155654654,955654654);
session_start();
session_unset();
session_destroy();
session_start();
?>
<?php
if(!isset($_SESSION['user_cookie_id'])) {
$_SESSION['user_cookie_id'] = $randomNumber;

}

?>
