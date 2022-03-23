<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

$title = "Future Baby Drawing | Melissa Psychic";
$description = "Future Baby Drawing"; 
$menu_order="men_0_0"; 


// set parameters and execute
if(isset($_GET['emailaddress']))$order_email = $_GET['emailaddress'];
if(isset($_GET['total']))$order_price = $_GET['total'];
if(isset($_GET['order_id']))$order_buygoods = $_GET['order_id'];
$cookie_id = $_SESSION['user_cookie_id2'];
$createChat = "";


if(isset($_GET['emailaddress'])) {

  //Find Correct Order
  $sql = "SELECT * FROM `orders` WHERE `cookie_id` = '$cookie_id' ORDER BY  `order_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $count = $result->num_rows;

  //If order is found input data from BG and update status to paid
  if($result->num_rows != 0) {
  $row = $result->fetch_assoc();
  $orderID = $row['order_id'];
  $first_name = $row['first_name'];
  $product = $row['order_product'];

  $sql = "UPDATE `orders` SET `order_email`='$order_email', `order_price`='$order_price', `buygoods_order_id`='$order_buygoods', `order_status`='paid' WHERE order_id='$orderID'";
  $result = $conn->query($sql);

  $createChat = 1;
  }

}



include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; 
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/create_chat.php';
?>
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
    <a href="/index.php">Melissa</a> > Future Baby Drawing
  </div>
</div>


<div class="general_section upsale_page">
  <div class="container">
  <div class="white-wrapper col-md-10 offset-md-2"> <h1>Final Chance!</h1>
    <img src="/assets/img/psychic.jpg" alt="upsell">
    <form class="readings" action="/order3.php" method="get">
      <h2>Future Baby Reading + Portrait</h2>
    
      <input class="cookie" type="hidden" name="cookie_id" value="<?php echo $_SESSION['user_cookie_id3']; ?>">
      <div class="meta_part">

        <div class="sides">
          <div class="price_box">
            <span class="new_prce">$29.99</span>
          </div>

          <div class="form_box input-group">
  
  <input id="prio12" type="radio" name="priority" value="12">
  <label for="prio12"><span><i class="fas fa-bolt" aria-hidden="true"></i>12 Hours</span></label>
  
<input id="prio24" type="radio" name="priority" value="24">
  <label for="prio24"> <span><i class="fas fa-stopwatch" aria-hidden="true"></i>24 Hours</span></label>

<input id="prio48" type="radio" name="priority" value="48" checked="true">
  <label for="prio48"> <span><i class="fas fa-clock" aria-hidden="true"></i>48 Hours</span></label>
</div>

          
          <br> 
          <div class="gradient">This reading will let you know when you will become pregnant, as well as an in-depth description about your future baby's gender, passions, skills, talents, and much more. Knowing more about your future baby will help you make sure that everything will be going well with your pregnancy, and prepare for the most wonderful experience your life has to offer!</div>
          <input type="submit" name="future_baby" value="Yes i want my future baby drawing">

        </div>
      </div>
      
      <a class="nothanks" href="/order3.php?skip=yes">No thanks</a>
    </form>
  </div>
</div>
<script>
jQuery('input[name="priority"]').change(function(){
    if (this.value == '12') {
        jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$49.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$499.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$450 (90%)').animate({'opacity': 1}, 400);});	
    }
    if (this.value == '24') {
		jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$39.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$399.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$360 (90%)').animate({'opacity': 1}, 400);});
    }
    if (this.value == '48') {
		jQuery('.new_prce').animate({'opacity' : 0}, 200, function(){jQuery('.new_prce').html('$29.99').animate({'opacity': 1}, 200);});
		jQuery('.old_price del').animate({'opacity' : 0}, 300, function(){jQuery('.old_price del').html('$299.99').animate({'opacity': 1}, 300);});
		jQuery('.saveda').animate({'opacity' : 0}, 400, function(){jQuery('.saveda').html('$270 (90%)').animate({'opacity': 1}, 400);});
    }
})
</script>
<script>


var product_code = $('.product_code').text()
$('.product').val(product_code);

</script>
<style>@media(max-width: 1080px) {
	
	
	.form_box > .sides{
		display: flex!important;
		 justify-content: space-between!important;
		
		 align-items:stretch;
		}
		
	form > div:nth-child(2) > div > div:nth-child(2)
	{
	margin-left:10px;
	margin-right:10px;
		}
	}
	
.third {
	margin-bottom:0!important;
   }
.input-group {
border-radius: 8px!important;
    height: 46px!important;
    border: 1px solid #cad1da!important;
	display: inline-flex!important;
	justify-content:space-evenly!important;
	width:100%!important;
	align-items: center;
}

select:invalid { color: gray; }
	
	
.input-group input[type="radio"] {
  display: none!important;
}
.input-group input[type="radio"] + label,
.input-group select {
  flex-grow: 0;
  flex-shrink: 0;
  flex-basis: 33%;
  padding: 13px 2px;
  text-align:center;
  cursor: pointer;
}
.input-group input[type="radio"] + label:first-of-type {
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  border-right: 1px solid #cad1da!important;
}
.input-group input[type="radio"] + label:last-of-type {
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-left: 1px solid #cad1da!important;
}
.input-group input[type="radio"] + label i {
  padding-right: 0.4em;
}
.input-group input[type="radio"]:checked + label,
.input-group input:checked + label:before,
.input-group select:focus,
.input-group select:active {
 background: linear-gradient(90deg,#d130eb,#4a30eb 80%,#2b216c);
  color: #fff!important;
  font-weight: bold;
  border-color: #bd8200;
}
</style>

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
.offset-md-4 {
    margin-left: 16.666666%;
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




<?php include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>