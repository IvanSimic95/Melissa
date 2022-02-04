<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
// set parameters and execute
$cookie_id = $_SESSION['user_cookie_id'];

$genderAcc = $_SESSION['genderAcc'];
$userGender = $_SESSION['userGender'];
$partnerGender = $_SESSION['partnerGender'];

$sex_picked = "";
if(isset($_POST['pick_sex'])){
  $pick_sex = $_POST['pick_sex'];
  $sex_picked = "1";
}


if ($sex_picked==1) {
  

    $sql = "UPDATE `orders` SET `pick_sex`='$pick_sex' WHERE cookie_id='$cookie_id'" ;


    if ($conn->query($sql) === true) {
        $sql = "SELECT * FROM orders WHERE cookie_id='$cookie_id'";

        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
        } else {
            while ($row = $result->fetch_assoc()) {
                $order_id =  $row["order_id"];
                $user_name =  $row["user_name"];
                $order_email =  $row["order_email"];
                $order_product = 'Readings';
            }
        }
        // echo "Update successfully";

    //unset($_COOKIE['user_cookie_id']);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  
} 
?>



<?php $title = "Readings | Melissa Psychic"; ?>
<?php $description = "Readings"; ?>
<?php $menu_order="men_0_0"; ?>
<?php  ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php';
$cookie_id = $_SESSION['user_cookie_id'];
 ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>
<link rel="stylesheet" href="assets/css/upsell.css">
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
}
h2 {
  font-size: 28px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
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
@media only screen and (min-width: 768px) {
  .offset-md-2 {
    margin-left: 8.333333%;
}
.offset-md-4 {
    margin-left: 16.666666%;
}
}

</style>
<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Readings
  </div>
</div>


<div class="general_section upsale_page">
  <div class="container">
  <div class="white-wrapper col-md-10 offset-md-2"> <h1>You Unlocked a Special Service!</h1>
    
    <img src="/assets/img/psychic.jpg" alt="upsell">
    <h3>This is an exclusive service which I'm only offering to a small number of customers. You can't get back to this page later!</h3>
   
    
  </div>
  <div class="white-wrapper col-md-10 offset-md-2">
  <form class="readings" action="/order2.php" method="get">
      <h1>Personal Psychic Reading</h1>
    
 
      <ul class="list-group list-group-flush">
          <li class="list-group-control">
					<label class="custom-control fill-checkbox">
			    <input type="checkbox" class="fill-control-input"  id="general" name="general" value="general" checked>
			    <span class="fill-control-indicator"></span>
			    <span class="fill-control-description">General Reading</span>
		      </label>
					</li>
          <li class="list-group-control">
					<label class="custom-control fill-checkbox">
			    <input type="checkbox" class="fill-control-input"  id="love" name="love" value="love">
			    <span class="fill-control-indicator"></span>
			    <span class="fill-control-description">Love Reading</span>
		      </label>
					</li>
          <li class="list-group-control">
					<label class="custom-control fill-checkbox">
			    <input type="checkbox" class="fill-control-input"  id="career" name="career" value="career">
			    <span class="fill-control-indicator"></span>
			    <span class="fill-control-description">Career Reading</span>
		      </label>
					</li>
          <li class="list-group-control">
					<label class="custom-control fill-checkbox">
			    <input type="checkbox" class="fill-control-input"  id="health" name="health" value="health">
			    <span class="fill-control-indicator"></span>
			    <span class="fill-control-description">Health Reading</span>
		      </label>
					</li>
          
				</ul>
        <input class="cookie" type="hidden" name="cookie_id"
            value="<?php echo $_SESSION['user_cookie_id']; ?>">

      <div class="meta_part">

        <div class="sides">
          <div class="price_box">
            <span class="new_prce">$19.99</span>
          </div>
          <span class="gradient">Woudn't it be great to just know the truth instead of cunsumming yourself with constant thoughts?</span>
          <input type="submit" name="form_submit" value="Add to my Purchase">

        </div>
      </div>
     
      <a class="nothanks" href="/future-baby.php">No thanks</a>
      </div></div>
    </form>
   
</div>




<script>
      var $checkboxes = $('.list-group-control input[type="checkbox"]');

      $checkboxes.change(function() {
        var $boxes = $('input:checked');
        var countCheckedCheckboxes = $boxes.length;
        if (countCheckedCheckboxes == 1) {
          $('.new_prce').text('$19.99');
          $('input[type="submit"]').show();
        }
        if (countCheckedCheckboxes == 2) {
          $('.new_prce').text('$29.99');
          $('input[type="submit"]').show();
        }
        if (countCheckedCheckboxes == 3) {
          $('.new_prce').text('$39.99');
          $('input[type="submit"]').show();
        }
        if (countCheckedCheckboxes == 4) {
          $('.new_prce').text('$49.99');
          $('input[type="submit"]').show();
        }
        if (countCheckedCheckboxes == 0) {
          $('.new_prce').text('');
          $('input[type="submit"]').hide();
        }
      });
    </script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';


?>