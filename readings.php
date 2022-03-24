<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
//Check if partner sex was manually picked by user
$sex_picked = "";
if(isset($_POST['pick_sex'])){
  $pick_sex = $_POST['pick_sex'];
  $sex_picked = "1";
}

//If sex was picked manually by user update it in order info
if ($sex_picked==1) {
    $order_id = $_POST['cookie_id'];
    $sql = "UPDATE `orders` SET `pick_sex`='$pick_sex' WHERE cookie_id='$order_id'";
    $result = $conn->query($sql);

    $conn->close();
}

$title = "Readings | Melissa Psychic";
$description = "Readings";
$menu_order="men_0_0";

include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; 
?>
<link rel="stylesheet" href="assets/css/upsell.css">
<style>
  @media only screen and (min-width: 768px) {
  .offset-md-2 {
    margin-left: 8.333333%;
}
.offset-md-4 {
    margin-left: 16.666666%;
}
}
.upsale_page h1 {
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
.upsale_page h2 {
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
.upsale_page h3 {
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
    <a href="/index.php">Melissa</a> > Readings
  </div>
</div>


<div class="general_section upsale_page">
  <div class="container">
  <div class="white-wrapper col-md-10 offset-md-2"> <h1>You Unlocked a Special Service!</h1>
    
    <center> <img src="/assets/img/sitee91.jpg" alt="upsell"> </center>
    <h3>This is an exclusive service which I'm only offering to a small number of customers. You can't get back to this page later!</h3>
   
    
  </div>
  <div class="white-wrapper col-md-10 offset-md-2">
  <form class="readings" action="/order2.php" method="get">
      <h1>Personal Psychic Reading</h1>
    
 <br>
          <center> <b> <div class="gradient"> <h3> WOULDN'T BE GREAT TO JUST KNOW THE TRUTH INSTEAD OF CUNSUMMING YOURSELF WITH CONSTANT THOUGHTS? </h3></span> </b> </center>
           <br> </r>
          <div class="gradient">Your personal psychic reading will help answer some important questions that you've been asking yourself for a long time. If you would like to know more about your future love life, career, health, or where your life is headed in general, this is the perfect service for you.</div>
                   <br>
            
                   <div class="gradient"> You will receive your reading within 24 hours with everything you need to find out about yourself. </div>
                   <br>
                   <center> 
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
          
				</ul></center>
        <input class="cookie" type="hidden" name="cookie_id" value="<?php echo $_SESSION['user_cookie_id2']; ?>">

      <div class="meta_part">

        <div class="sides">
          <div class="price_box">
            <span class="new_prce">$19.99</span>
          </div>
          <input type="submit" name="form_submit" value="Add to my Purchase">

        </div>
      </div>
     
      <a class="nothanks" href="/order2.php?skip=yes">No thanks</a>
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
<?php 
$FirePixel = $_SESSION['fbfirepixel'];

if($FirePixel == 1){
  $orderID = $_SESSION['fborderID'];
  $orderPrice = $_SESSION['fborderPrice'];
  $product = $_SESSION['fbproduct'];

$FBPurchasePixel = <<<EOT
<script>
fbq('track', 'Purchase', {
  value: $orderPrice , 
  currency: 'USD',
  content_type: 'product', 
  content_ids: '$product'
}, 
{eventID: '$orderID'});
</script>
EOT;

$_SESSION['fbfirepixel'] = 0;
}
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';

?>