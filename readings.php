<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/noskip.php';

//Check if partner sex was manually picked by user
$sex_picked = "";
if(isset($_POST['pick_sex'])){
  $pick_sex = $_POST['pick_sex'];
  $sex_picked = "1";
}

//If sex was picked manually by user update it in order info
if ($sex_picked==1) {
    $order_id = $_POST['cookie_id'];
    $sql = "UPDATE `orders` SET `pick_sex`='$pick_sex' WHERE cookie_id='$order_id'" ;
    $conn->close();
}

$title = "Readings | Melissa Psychic";
$description = "Readings";
$menu_order="men_0_0";

include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; 
?>
<link rel="stylesheet" href="assets/css/upsell.css">
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
include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';
?>