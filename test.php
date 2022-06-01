<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
if(isset($_GET['remove'])){
session_unset();
}
?>