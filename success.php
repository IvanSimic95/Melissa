<?php
session_start();

// set parameters and execute
$order_email = $_GET['emailaddress'];
$order_price = $_GET['total'];
$order_buygoods = $_GET['order_id'];
$cookie_id = $_SESSION['user_cookie_id'];
// echo $cookie_id;
if($order_email) {


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


    $sql = "UPDATE `orders` SET `order_status`='paid',`order_email`='$order_email',`order_price`='$order_price',`buygoods_order_id`='$order_buygoods' WHERE cookie_id='$cookie_id'" ;
    // $sql = "INSERT INTO orders (order_id, cookie_id, user_age, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id)
    //                       VALUES (NULL, '$cookie_id', '$user_age', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '')";


    if ($conn->query($sql) === TRUE) {
      // echo "Update successfully";

      //unset($_COOKIE['user_cookie_id']);
    } else {
      // echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();



?>



<?php $title = "Success | Melissa Psychic"; ?>
<?php $description = "Success"; ?>
<?php $menu_order="men_0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>

<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Success
  </div>
</div>


<div class="general_section">
  <div class="container">
    <form class="pick_sex" action="/readings.php" method="post">
      <div class="form_box">
          <span>I would like to recieve a drawing of a:</span>
          <div class="radio_box">
            <input type="radio" id="male" name="pick_sex" value="male" checked>
            <label class="inline" for="male">Male</label>
            <input type="radio" id="female" name="pick_sex" value="female">
            <label class="inline" for="female">Female</label>

          </div>
      </div>
      <div class="form_box">
        <input type="submit" name="form_submit" value="Update Preferences">
      </div>
    </form>
  </div>
</div>


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

$sql = "SELECT * FROM orders WHERE cookie_id='$cookie_id'";

$result = $conn->query($sql);

if($result->num_rows == 0 || $order_email == "") {


} else {
    while($row = $result->fetch_assoc()) {
      $order_id =  $row["order_id"];
      $user_name =  $row["user_name"];
      $order_email =  $row["order_email"];
      $order_product = $row["order_product"];
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


 ?>
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
          subject: "<?php echo ucwords($order_product) . " Drawing #" . $order_id; ?>"
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
