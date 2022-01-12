<?php
session_start();
//echo $cookie_id;
// set parameters and execute
$order_email = $_GET['emailaddress'];
$order_price = $_GET['total'];
$order_buygoods = $_GET['order_id'];
$cookie_id = $_SESSION['user_cookie_id'];
//echo $cookie_id;

if($order_email) {


?>


<?php
// fetch email from past order
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

$sql = "SELECT * FROM orders WHERE order_email ='$order_email'";

$result = $conn->query($sql);

if($result->num_rows == 0 || $order_email == "") {


} else {
    while($row = $result->fetch_assoc()) {
      $retained_username = $row["user_name"];
    }

}





$conn->close();
// end of fetch email from past order
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


    $sql = "UPDATE `orders` SET `user_name` = '$retained_username', `order_status`='paid',`order_email`='$order_email',`order_price`='$order_price',`buygoods_order_id`='$order_buygoods' WHERE cookie_id='$cookie_id'" ;
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
            $order_product = 'Readings';
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

    $conn->close();
      }


       // echo "Update successfully";
      session_unset();
      session_destroy();
      //unset($_COOKIE['user_cookie_id']);
    } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();



?>



<?php $title = "Past Life | Melissa Psychic"; ?>
<?php $description = "Past Life Readings"; ?>
<?php $menu_order="men_0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>
<style>
h1 {
font-size: 36px;
    font-weight: bold;
    background: linear-gradient( 90deg,#d130eb,#4a30eb 80%,#2b216c);
    color: #fff!important;
    margin-top: -25px;
    margin-left: -25px;
    margin-right: -25px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    text-align: center;
    padding: 15px;
	text-transform:uppercase;
  font-family: Nunito,sans-serif;
    font-style: normal;
    font-weight: 800;
}
h2 {
  font-size: 28px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
    font-family: Nunito,sans-serif;
    font-style: normal;
    font-weight: 800;
}
h3 {
  font-size: 20px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
}
.fill-control-description {
  font-size: 24px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
}
.col-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}

.price_box{
text-align:center;
}
.gradient{
  font-size: 18px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
    margin-bottom:15px;
}

</style>
<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Past Life
  </div>
</div>


<div class="general_section upsale_page">
  <div class="container">
  <div class="white-wrapper col-md-10 offset-md-2"> <h1>Final Chance!</h1>
    <img src="/assets/img/psychic.jpg" alt="upsell">
    <form class="readings" action="/order3.php" method="get">
      <h2>Past Life Reading + Portrait</h2>
      <input class="cookie" type="hidden" name="cookie_id" value="<?php echo $_SESSION['user_cookie_id']; ?>">
      <div class="meta_part">

        <div class="sides">
          <div class="price_box">
            <span class="new_prce">$14.99</span>
          </div>
          <div class="gradient">Woudn't it be great to just know the truth instead of cunsumming yourself with constant thoughts?</div>
          <input type="submit" name="past_life" value="Yes i want my past life reading">

        </div>
      </div>
      
      <a class="nothanks" href="/order-complete.php">No thanks</a>
    </form>
  </div>
</div>


<div id="talkjs-container-<?php echo $row["order_id"]; ?>" style="width: 90%; margin: 30px; height: 500px; position:fixed;bottom:0;right:0;z-index:999;display:none !important">
    <i>Loading chat...</i>
</div>

<script>
   (function(t,a,l,k,j,s){
   s=a.createElement('script');s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s)
   ;k=t.Promise;t.Talk={v:3,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e])});l
   .push([f])},catch:function(){return k&&new k()},c:l}};})(window,document,[]);
</script>
<script>
   Talk.ready.then(function() {
     var other = new Talk.User({
         id: "<?php echo $order_id; ?>",
         name: "<?php echo $user_name; ?>",
         email: "<?php echo $order_email; ?>",
         photoUrl: "/assets/img/avatars/client.png",
         role: "client"
     });
     console.log(other);
     var me = new Talk.User(654321252);
     console.log(me);
     window.talkSession = new Talk.Session({
         appId: "tMXnCHK2",
         me: other
     });
     var conversation = talkSession.getOrCreateConversation("<?php echo $order_id; ?>");
         conversation.setAttributes({
         subject: "<?php echo $order_product . " #" . $order_id; ?>"
     });

     conversation.setParticipant(other);
     conversation.setParticipant(me);
       var chatbox = window.talkSession.createChatbox(conversation);
      chatbox.mount(document.getElementById("talkjs-container-<?php echo $row["order_id"]; ?>"));
   })

</script>
<?php
}else{
  header('Location: /');
}

 ?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>
