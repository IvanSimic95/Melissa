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
  <div class="white-wrapper col-md-10 offset-md-2"> <h1>Choose your Sexual Orientation!</h1>
  <!-- <form>
		<fieldset class="form__options">
			<legend class="form__question">What is your ideal match?</legend>
      <div class="form_box">
			<p class="form__answer"> 
			
			</p>
			
			<p class="form__answer"> 
			
			</p>
  </div>
			
			
		</fieldset>
		<button class="form__button" type="submit">Submit your info</button>
	</form>
   -->
    <form class="pick_sex" action="/readings.php" method="post">
      <div class="form_box">
          <span>I would like to recieve a drawing of a:</span>
          <div class="radio_box">
          <div class="row" style="display:flex;flex-wrap: wrap;">
          <div class='col-6 text-center'>
        <input type="radio" name="match" id="match_1" value="guy" checked> 
				<label class="imgbgchk label-man" for="match_1" style="position: relative;">
        <div class="labbel-wrapper">
        <img src="assets/img/man.png">
				<div class="tick_container">
                <div class="tick"><i class="fa fa-check"></i></div>
        </div>
  </div>
				</label> 
  </div>
  <div class='col-6 text-center'>
           	<input type="radio" name="match" id="match_2" value="girl"> 
				<label class="imgbgchk label-woman" for="match_2" style="position: relative;">
        <div class="labbel-wrapper">
        <img src="assets/img/woman.png">
          <div class="tick_container">
                <div class="tick"><i class="fa fa-check"></i></div>
              </div>
  </div>
				</label> 
  </div>
  </div>
          </div>
      </div>
      <div class="form_box">
        <input type="submit" class="disabled" id="submit-button" name="form_submit" value="Choose a man or a woman" disabled>
      </div>
    </form>


  </div>

  </div>
</div>
<script>
$(".label-man").click(function(){
  $(this).find('.tick_container').css('opacity', '1');
  $(this).find('.labbel-wrapper').addClass('greenshadow');
  $(".label-woman").find('.labbel-wrapper').removeClass('greenshadow');
  $(".label-woman").find('.tick_container').css('opacity', '0');
  $("#submit-button").val('Confirm a Man!');
  $("#submit-button").removeClass('disabled');
  $("#submit-button").removeAttr('disabled');
});

$(".label-woman").click(function(){
  $(this).find('.tick_container').css('opacity', '1');
  $(this).find('.labbel-wrapper').addClass('greenshadow');
  $(".label-man").find('.labbel-wrapper').removeClass('greenshadow');
  $(".label-man").find('.tick_container').css('opacity', '0');
  $("#submit-button").val('Confirm a Woman!');
  $("#submit-button").removeClass('disabled');
  $("#submit-button").removeAttr('disabled');
});
  </script>

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


<style>
  .labbel-wrapper {
height:100%;
border-radius:15px;

} 
  .disabled {

    cursor: not-allowed!important;
} 
  .col-6 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
@media only screen and (min-width: 768px) {
  .offset-md-2 {
    margin-left: 8.333333%;
}
}
.greenshadow{
  box-shadow: 1px -1px 18px 11px rgba(76,175,80,0.74);
-webkit-box-shadow: 1px -1px 18px 11px rgba(76,175,80,0.74);
-moz-box-shadow: 1px -1px 18px 11px rgba(76,175,80,0.74);
        }
   .imgbgchk:checked + label>.tick_container{
            opacity: 1;
        }
/*         aNIMATION */
        .imgbgchk:checked + label>img{
            transform: scale(1.25);
            opacity: 0.3;
        }
        .tick_container {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            cursor: pointer;
            text-align: center;
        }
        .tick {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 6px 12px;
            height: 35px;
            width: 40px;
            border-radius: 100%;
        }
  .pick_sex {
    width:100%;
    max-width:initial;
  }
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
}
.labbel-wrapper > img{
  width:250px;
}
label {
  border: 1px solid rgba(250, 250, 250, 0.15);
  box-sizing: border-box;
  display: block;
  height: 100%;
  width: 100%;
  padding: 10px 10px 30px 10px;
  cursor: pointer;
  opacity: 0.5;
  transition: all 0.5s ease-in-out;
}
label:hover, label:focus, label:active {
  border: 1px solid rgba(250, 250, 250, 0.5);
}

.form__button {
  height: 40px;
  border: none;
  background-color: #00703f;
  color: #FAFAFA;
  text-transform: uppercase;
  font-family: "Source Sans Pro", sans-serif;
  padding: 0 20px;
  border-radius: 20px;
  font-weight: 900;
  cursor: pointer;
  margin: 40px 0;
  transition: all 0.25s ease-in-out;
}
.form__button:hover, .form__button:focus {
  background-color: #00824A;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
  outline: none;
}

/* Input style */
input[type=radio] {
  opacity: 0;
  width: 0;
  height: 0;
}

input[type=radio]:active ~ label {
  opacity: 1;
}

input[type=radio]:checked ~ label {
  opacity: 1;
  border: 1px solid #FAFAFA;
}
    </style>

<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>
