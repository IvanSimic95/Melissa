<?php
$domain = $_SERVER['SERVER_NAME'];
if ($domain == "melissa.test") {
    //Define your host here.
    $host = "localhost";
    //Define your database username here.
    $user = "root";
    //Define your database password here.
    $password = "";
    //Define your database name here.
    $db = "melissap_melissa";
} else {
    //Define your host here.
    $host = "localhost";
    //Define your database username here.
    $user= "melissap_melissapsychic";
    //Define your database password here.
    $password = ";w[#i&[zcrm?";
    //Define your database name here.
    $db = "melissap_melissa";
}

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
     $conn = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
     echo $e->getMessage();
}

$sql = 'INSERT INTO blog(title, text, shortlink) VALUES(:title, :text, :shortlink)';

$statement = $conn->prepare($sql);

$statement->execute([
     ':title' => $_REQUEST['title'],
     ':text' => $_REQUEST['content'],
     ':shortlink' => $_REQUEST['shortlink']
]);

echo "Post saved successfully!";
?>