<?php
session_start();


$order_email = $_GET['emailaddress'];
$order_price = $_GET['total'];
$order_buygoods = $_GET['order_id'];
$cookie_id = $_SESSION['user_cookie_id'];
// echo $cookie_id;
if($order_email) {
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

$sql = "SELECT * FROM orders WHERE order_email ='$order_email'";

$result = $conn->query($sql);

if($result->num_rows == 0 || $order_email == "") {


} else {
    while($row = $result->fetch_assoc()) {
      $retained_username = $row["user_name"];
    }

}



    $sql = "UPDATE `orders` SET `user_name` = '$retained_username',`order_status`='paid',`order_email`='$order_email',`order_price`='$order_price',`buygoods_order_id`='$order_buygoods' WHERE cookie_id='$cookie_id'" ;
    // $sql = "INSERT INTO orders (order_id, cookie_id, user_age, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id)
    //                       VALUES (NULL, '$cookie_id', '$user_age', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '')";


    if ($conn->query($sql) === TRUE) {
      $sql = "SELECT * FROM orders WHERE cookie_id='$cookie_id'";

      $result = $conn->query($sql);

      if($result->num_rows == 0 || $order_email == "") {


      } else {
          while($row = $result->fetch_assoc()) {
            $order_id =  $row["order_id"];
            $user_name =  $row["user_name"];
            $order_email =  $row["order_email"];
            $order_product = 'Past Life Reading';
          }
		

	// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

$sql = "UPDATE `orders` SET `chatID`='$convoID' WHERE cookie_id='$cookie_id'" ;
    // $sql = "INSERT INTO orders (order_id, cookie_id, user_age, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id)
    //                       VALUES (NULL, '$cookie_id', '$user_age', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '')";


    if ($conn->query($sql) === TRUE) {
      // echo "Update successfully";

      //unset($_COOKIE['user_cookie_id']);
    } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    }


      }
      // echo "Update successfully";

      //unset($_COOKIE['user_cookie_id']);
    } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();



?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/create_chat.php'; ?>

<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    setTimeout(function(){
      window.location.href = "https://melissa-psychic.com/order-complete.php";
     }, 3000);
  });

</script>


<?php
}else{
  header('Location: /');
}

 ?>
