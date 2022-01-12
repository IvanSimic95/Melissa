<?php $title = "Dashboard | Melissa Psychic"; ?>
<?php $description = "Dashboard"; ?>
<?php $menu_order="0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>

<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Dashboard
  </div>
</div>
<div class="container">

<div class="row">
      <div class="col-md-6 col-md-offset-3">
   <div class="white-wrapper">




<div class="login-form">
  <div class="gradient-top">
    <h1>Thank you for your order</h1>
    
  </div>

     <img class="checkmark" src="/assets/img/checkmark.svg">
     <h3>Your order is now complete & you will receive an email with your order details and dashboard.</h3>
</div>


   </div>
  </div>
</div>
</div>

<style>
  .white-wrapper {
margin-top:50px;
margin-bottom:150px;
}
  .login-form
  {
   text-align:center;
  }
  .checkmark{
    max-width:100px;
  }
.try-again{
  padding: 8px 20px!important;
  margin-top: 10px!important;
  margin-bottom: 10px!important;
  box-sizing: border-box!important;
  cursor: pointer!important;
  font-size: 140%!important;
  text-align: center!important;
  background: #fc00ff!important;
  color: #fff!important;
  font-weight: bold!important;
  transition: all 0.5s ease!important;
  width: 100%!important;
  height: 60px!important;
  background: linear-gradient( 90deg,#d130eb,#4a30eb 80%,#2b216c)!important;
  border-radius: 10px!important;
  line-height: 34px!important;
  text-align: center!important;
  color: #fff!important;
  box-shadow: 0 8px 15px rgb(0 0 0 / 30%)!important;

}
.profile-img-card {

    margin: 10px auto 10px;
    display: block;

}
.input-group-addon{
color:#fff;
background: linear-gradient( 90deg,#d130eb,#4a30eb 80%,#2b216c);
  }
.input-group-addon > i{
font-size:28px;
    }
.customer_email{
  width: 100%!important;
      padding: 8px 20px!important;
      box-sizing: border-box!important;
      border-radius: 8px!important;
      padding: 14px!important;
      border: 1px solid #cad1da!important;
      outline: none!important;
      height: auto!important;
      border-top-left-radius: 0!important;
      border-bottom-left-radius: 0!important;

}
.gradient-top{
background: linear-gradient( 90deg,#d130eb,#4a30eb 80%,#2b216c);
margin-top: -25px;
margin-left: -25px;
margin-right: -25px;
border-top-left-radius: 8px;
border-top-right-radius: 8px;
padding: 7px;
  }
h1 {
font-size: 26px;
    font-weight: bold;
margin-bottom:0!important;
    color: #fff!important;


    text-align: center;

	text-transform:uppercase;
}
h3{
margin-bottom:0px;
text-align: center;
}
.check_user input{
max-width:100%;
display:block;
  }
.check_user input[type='submit'] {
  padding: 8px 20px;
margin-top: 10px;
margin-bottom: 10px;
box-sizing: border-box;
cursor: pointer;
font-size: 140%;
text-align: center;
background: #fc00ff;
color: #fff;
font-weight: bold;
transition: all 0.5s ease;
width: 100%;
height: 60px;
background: linear-gradient(
90deg,#d130eb,#4a30eb 80%,#2b216c);
border-radius: 10px;
line-height: 34px;
text-align: center;
color: #fff;
box-shadow: 0 8px 15px rgb(0 0 0 / 30%);
}
.general_section > .container{
  padding-top: 50px;
      padding-bottom: 150px;
  }
  }
</style>









<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';
