<?php
$data = file_get_contents('php://input');
$json_data = json_decode($data);
$obj = $json_data;


file_put_contents('test.txt', print_r($obj, true));
?>