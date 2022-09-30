<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';


if(isset($_SESSION['lastorder'])){
  $lastOrderID = $_SESSION['lastorder'];
  $order_ID = $lastOrderID;
  $sql = "SELECT * FROM `orders` WHERE `order_id` = '$lastOrderID' ORDER BY `order_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $count = $result->num_rows;
  $row = $result->fetch_assoc();
  
  //If order is found input data from BG and update status to paid
  if($result->num_rows != 0) {
  
    $affid = $row['affid'];
    $s1 = $row['s1'];
    $s2 = $row['s2'];
  

  $_SESSION['orderFName'] = $row['first_name'];
  $_SESSION['orderLName'] = $row['last_name'];
  $_SESSION['orderBirthday'] = $row['birthday'];
  $_SESSION['orderAge'] = $row['user_age'];
  $_SESSION['orderGender'] = $row['user_sex'];
  $_SESSION['orderPartnerGender'] = $row['pick_sex'];
  $_SESSION['BGEmail'] = $row['order_email'];
  
  $_SESSION['fbfirepixel'] = 1;
  $_SESSION['fborderID'] = $_SESSION['lastorder'];
  $_SESSION['fborderPrice'] = $row['order_price'];
  $_SESSION['fbproduct'] = $row['order_product'];
  
    if($affid == 1){
      $fireIframe = 1;
    }
  
  }
  }else{
    if(isset($_GET['main_ID'])){
  $ord = $_GET['main_ID'];
  $order_ID = $ord;
  $sql = "SELECT * FROM `orders` WHERE `order_id` = '$ord' ORDER BY `order_id` DESC LIMIT 1";
  $result = $conn->query($sql);
  $count = $result->num_rows;
  $row = $result->fetch_assoc();
  
  //If order is found input data from BG and update status to paid
  if($result->num_rows != 0) {
  
    $affid = $row['affid'];
    $s1 = $row['s1'];
    $s2 = $row['s2'];
  
  $_SESSION['lastorder'] = $_GET['main_ID'];
  $_SESSION['orderFName'] = $row['first_name'];
  $_SESSION['orderLName'] = $row['last_name'];
  $_SESSION['orderBirthday'] = $row['birthday'];
  $_SESSION['orderAge'] = $row['user_age'];
  $_SESSION['orderGender'] = $row['user_sex'];
  $_SESSION['orderPartnerGender'] = $row['pick_sex'];
  $_SESSION['BGEmail'] = $row['order_email'];
  
  $_SESSION['fbfirepixel'] = 1;
  $_SESSION['fborderID'] = $_GET['main_ID'];
  $_SESSION['fborderPrice'] = $row['order_price'];
  $_SESSION['fbproduct'] = $row['order_product'];
  
  
  }
  
  
  
  
    }
  }


$title = "Color Upgrade | Melissa Psychic";
$description = "soulmate drawing color upgrade";
$menu_order="men_0_0";

include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; 
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
    <a href="/index.php">Melissa</a> > Upgrade Color Drawing
  </div>
</div>

<div class="general_section upsale_page">
  <div class="container">
    <div class="white-wrapper col-md-10 offset-md-2"> 
        <h1>Upgrade Your Soulmate Drawing To Color!</h1>



        <center> <img src="/assets/img/done2.jpg" alt="upsell" style="border-radius:4px;"> </center>


   
  
  <form id="ajax-form" class="form-order" name="order_form" action="javascript:void(0)" method="post">

    
 <br>
           <center> <b> <div class="gradient"> <h3> <b>Isabella,</b> <br> Please upgrade my black and white drawing to dazzling full HD drawing so that I can easily recognize my Soulmate when I meet him </h3></span> </b> </center>
           <br> 
          
                   <br>
                   <div id="purchasedupsell" class="alert alert-succes">Awesome! We will use same payment method as for your previous order.<br> Redirecting to payment page now...</div>
                   <div class="onsubmithide">
              

        <input class="customer_name" type="hidden" id="fullname" name="form_name" value="<?php echo $_SESSION['orderFName'].' '.$_SESSION['orderLName']; ?>">
        <input class="customer_name" type="hidden" id="firstname" name="first_name" value="<?php echo $_SESSION['orderFName']; ?>">
        <input class="customer_name" type="hidden" id="lastname" name="last_name" value="<?php echo $_SESSION['orderLName']; ?>">
        <input class="birthday" type="hidden" id="birthday" name="form_birthday" value="<?php echo $_SESSION['orderBirthday']; ?>">
        <input class="userage" type="hidden" id="userage" name="form_age" value="<?php echo $_SESSION['orderAge']; ?>">
        <input class="usergender" type="hidden" id="usergender" name="usergender" value="<?php echo $_SESSION['orderGender']; ?>">
        <input class="partnergender" type="hidden" id="partnergender" name="partnergender" value="<?php echo $_SESSION['orderPartnerGender']; ?>">
        <input class="email" type="hidden" name="bgemail" value="<?php echo $_SESSION['BGEmail']; ?>">
        <input class="cookie" type="hidden" name="cookie_id" value="<?php echo $_SESSION['user_cookie_id2']; ?>">
        <input class="cookie" type="hidden" name="order_id" value="<?php echo $order_ID; ?>">
        <input class="price" type="hidden" id="product_price" name="price" value="13.99">
        <input class="fbp" type="hidden" name="fbp" value="<?php echo $UserFBP; ?>">
        <input class="fbc" type="hidden" name="fbc" value="<?php echo $UserFBC; ?>">
        <input class="submitbtnselect" type="hidden" name="submitbtnselect" id="submitbtnselect" value="submit">
        <div id="error" class="alert alert-danger" style="display: none"></div>
      <div class="meta_part">

        <div class="sides" style="position:relative;overflow:hidden;">
          <div class="price_box">
          <font color = "#FF00FF"> <center> <h2> ONLY </font><font color = "#49ff00 ">  $17.99</font> </h2> </center> </font>
          </div>
          <div class="smallerText">Choose at least one option to Proceed!</div>
          <button id="addtopurchase" type="submit" name="submit" value="Add to my Purchase" style="width:100%; margin-top:20px; padding:15px; line-height:1.2;">Yes, Please Upgrade My Order</button>

        </div>
      </div>
      <button id="nothanks" class="nothanks" type="submit" name="submit" value="No Thanks">No Thanks! I don't want to see the color of my soulmate's eyes</button>
</div>
      </div></div>
    </form>
   


    </div>
  </div>
</div>



<style>
    #addtopurchase{
    display: inline-block;
    padding: 15px 25px;
    border-top: 2px solid #ff7cb3;
    border-radius: 6px;
    background-color: #c52886;
    font-family: Lato, sans-serif;
    font-size: 1rem;
    text-align: center;
    color: white;
    width: 100%;
    line-height:1.2;
    }
#nothanks{
    margin-top:20px;
    display: inline-block;
    padding: 13px 17px;
    border-radius: 6px;
    background-color: gray;
    font-family: Lato, sans-serif;
    font-size: 20px;
    text-align: center;
    color: white;
    width: 100%;
}

.smallerText {
    display: none;
}
#purchasedupsell{
    display:none;
}

.modal-content {
    position: relative;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgb(0 0 0 / 50%);
    box-shadow: 0 3px 9px rgb(0 0 0 / 50%);
}
.modal-title{
    font-size: 20px!important;
    font-weight: bold;
    background: -webkit-linear-gradient(#d130eb,#4a30eb 80%,#2b216c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
}
</style>

<script>
      var $checkboxes = $('.list-group-control input[type="checkbox"]');

      $checkboxes.change(function() {
        var $boxes = $('input:checked');
        var countCheckedCheckboxes = $boxes.length;
        if (countCheckedCheckboxes == 1) {
          $('.new_prce').text('$19.99');
          $('#product_price').val('19.99');
          $('.new_prce').show();
          $('.smallerText').hide();
          $('#addtopurchase').prop("disabled",false);
        }
        if (countCheckedCheckboxes == 2) {
          $('.new_prce').text('$29.99');
          $('#product_price').val('29.99');
          $('.new_prce').show();
          $('.smallerText').hide();
          $('#addtopurchase').prop("disabled",false);
        }
        if (countCheckedCheckboxes == 3) {
          $('.new_prce').text('$39.99');
          $('#product_price').val('39.99');
          $('.new_prce').show();
          $('.smallerText').hide();
          $('#addtopurchase').prop("disabled",false);
        }
        if (countCheckedCheckboxes == 4) {
          $('.new_prce').text('$49.99');
          $('#product_price').val('49.99');
          $('.new_prce').show();
          $('.smallerText').hide();
          $('#addtopurchase').prop("disabled",false);
        }
        if (countCheckedCheckboxes == 0) {
          $('.new_prce').hide();
          $('#product_price').val('00.00');
          $('.smallerText').show();
          $('#addtopurchase').prop("disabled",true);
        }
      });


      $(document).ready(function($){
		 
        $("#addtopurchase").click(function(){
        $("#submitbtnselect").val("submit")
        });

        $("#nothanks").click(function(){
        $("#submitbtnselect").val("NoThanks")
        });

     // hide messages 
     $("#error").hide();

     // on submit...
     $('#ajax-form').submit(function(e){
         e.preventDefault();
         $(".onsubmithide").fadeOut();
         //$("#submitbtn").html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

         $.ajax({
             type:"POST",
             url: "/ajax/color.php",
             dataType: 'json',
             data: $(this).serialize(),
             success: function(data){
               var SubmitStatus = data[0];
               if (SubmitStatus == "Success"){
              var DataMSG = data[1];
               var Redirect = data[2];
               $("#purchasedupsell").fadeIn();
              
               setTimeout(function(){
               window.location.href = Redirect;
               }, 2000);
               }else if(SubmitStatus == "NoThanks"){
                var Redirect = data[1];
                $("#purchasedupsell").html("You have choosen to skip this offer, redirecting you...");
                $("#purchasedupsell").fadeIn();

              setTimeout(function(){
               window.location.href = Redirect;
               }, 2000);
               }else{
              var DataMSG = data[1];
              alert(DataMSG);
               $("#error").html(DataMSG);
               $("#error").fadeIn();
               }

             },
             error:function(data){
               var SubmitStatus = data[0];
               if (SubmitStatus == "Success"){
              var DataMSG = data[1];
               var Redirect = data[2];
               $("#purchasedupsell").fadeIn();
               alert(SubmitStatus);
               alert(DataMSG);

             }
            }
         });
     });  
     return false;
 });
    </script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';

?>