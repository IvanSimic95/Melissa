<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Melbahja\Seo\MetaTags;

$metatags = new MetaTags();

$metatags
        ->title($title)
        ->description($description)
        ->meta('author', 'Melissa Psychic')
        ->image('https://melissa.test/assets/img/logo.png')
        ->mobile('https://melissa.test/assets/img/logo.png');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['logout'])){
  $_SESSION = array();
  session_destroy();
}



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php echo $metatags; ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<meta name="google-site-verification" content="08uItPxLqgddTP0orZfHcGBG_3QXJ8rzjGcRodl60dE" />
	<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/699dff544d.js" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="/assets/css/lazyload.css">
	<link rel="stylesheet" href="/assets/css/review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css">


  </head>
  <body id="<?php echo $menu_order; ?>">
    <header id="header">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<style>
	.collapse {
    display: none;
}
.collapse.in {
    display: block;
}
.logo{
   margin-left:15px;
   margin-top:15px;
   margin-bottom:10px;

   }
   #menu-content > li.collapsed.active > a,
   #menu-content > li.active > a{
   color:#fff!important;
   font-weight:bold!important;

   }
   #menu-content > li.active > a i{
   color:#fff!important;

   }
	.nav-side-menu {
  overflow: auto;
  font-size: 16px;
  font-weight: 400;
  background-color: #fff;
  position: fixed;
  top: 0px;
  width: 300px;
  height: 100%;
  color: #fff;
}
.menu-list {
  background-color: #4f5b69;
}

.nav-side-menu .brand {
  background-color: #23282e;
  line-height: 50px;
  display: block;
  text-align: center;
  font-size: 14px;
}
.nav-side-menu .toggle-btn {
  display: none;
}
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  /*
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active,
.nav-side-menu li .active a {
  border-left: 3px solid #fff;

   background: linear-gradient(90deg,#d130eb,#4a30eb 80%,#2b216c);
  color: #fff!important;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d130eb;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #fff;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  font-family: FontAwesome;
  content: "\f105";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
}
.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid ##4f5b69;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #fff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #432ccf;
     background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
.nav-side-menu li:hover a{
color:#fff!important;
	}
.collapsing{position:relative;height:0;overflow:hidden;-webkit-transition:height .35s ease;-o-transition:height .35s ease;transition:height .35s ease}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 16px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
.brand {
    display:none;
  }
    .brand-logo {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }

}

@media (min-width: 767px) {
  .nav-side-menu{
    display: none;
  }
    .brand {
    display:block;
  }
}
</style>











      <div class="topbar">
        <div class="container">
          <div class="sides">
            <div class="left">
              <a href="mailto:contact@melissa-psychic.com"><i class="fas fa-envelope"></i> contact@melissa-psychic.com</a>
            </div>
            <div class="right">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
	  <div id="mobile-menu" class="nav-side-menu">
    <a href="/index.php" class="logo">
                <img src="/assets/img/logo.png" alt="Melissa">
              </a>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content collapse out">
                <li class="men_1_0"><a href="/index.php"><i class="fa fa-home fa-lg"></i> Home </a></li>

                <li  data-toggle="collapse" data-target="#products" class="collapsed men_2_0">
                  <a href="#/"><i class="fa fa-shopping-cart fa-lg"></i> Services <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <li class="men_2_1"> <a href="/soulmate-drawing.php">Soulmate Drawing</a> </li>
					<li class="men_2_2"> <a href="/twin-drawing.php">Twin Flame Drawing</a> </li>
					<li class="men_2_3"> <a href="/wife-husband-drawing.php">Future Husband/Wife Drawing</a> </li>
					<li class="men_2_4"> <a href="/baby-drawing.php">Future Baby Drawing</a> </li>
                 </ul>

                 <li class="men_3_0"> <a href="/about.php"><i class="fa fa-star fa-lg"></i>About Melissa</a> </li>
                 <li class="men_4_0"> <a href="/blog/"><i class="fa fa-book-reader fa-lg"></i> Blog</a> </li>
                 <li class="men_5_0"> <a href="/contact.php"><i class="fa fa-envelope-open-text fa-lg"></i> Contact</a> </li>

                 <?php
                 if(isset($_SESSION['email'])){
                 ?>
                 <li class="men_6_0"> <a href="/dashboard.php"><i class="fas fa-user-shield"></i> <?php echo $_SESSION['email']; ?></a> </li>
                 <li class="men_7_0"> <a href="/index.php?logout=yes"><i class="fas fa-sign-out-alt"></i> Logout</a> </li>

                 <?php
                 }else{
                 ?>
                  <li class="men_6_0"> <a href="/dashboard.php"><i class="fas fa-user-shield"></i> Dashboard</a> </li>
               <?php } ?>
            </ul>
     </div>
</div>
      <div class="brand">
        <div class="container">
          <div class="sides">
            <div class="left">
              <a href="/index.php" class="logo">
                <img src="/assets/img/logo.png" alt="Melissa">
              </a>
            </div>
            <div class="right">
              <div class="level_1">
                <div class="top_menu">
                  <div class="bars" style="display:none">
                    <i class="fas fa-bars"></i>
                  </div>
                  <?php
                  if(isset($_SESSION['email'])){
                  ?>
                  <a class="btn" href="/dashboard.php"><i class="fas fa-user-shield"></i> <?php echo $_SESSION['email']; ?></a>
                  <a class="btn" href="/index.php?logout=yes"><i class="fas fa-sign-out-alt"></i> Logout</a>
                  <?php
                  }else{
                  ?>
                  <a class="btn" href="/dashboard.php"><i class="fas fa-user-shield"></i> Dashboard</a>
                <?php } ?>

                </div>
              </div>
              <div class="level_2">

                <nav id="main_menu">
                  <ul>
                    <li class="men_1_0"> <a href="/index.php">Home</a> </li>
                    <li class="men_2_0"> <a href="/services.php">Services</a>
                      <ul class="submenu">
                        <li class="men_2_1"> <a href="/soulmate-drawing.php">Soulmate Drawing</a> </li>
                        <li class="men_2_2"> <a href="/twin-drawing.php">Twin Flame Drawing</a> </li>
                        <li class="men_2_3"> <a href="/wife-husband-drawing.php">Future Husband/Wife Drawing</a> </li>
                        <li class="men_2_4"> <a href="/baby-drawing.php">Future Baby Drawing</a> </li>
                      </ul>
                    </li>
                    <li class="men_3_0"> <a href="/about.php">About Melissa</a> </li>
                    <li class="men_4_0"> <a href="/blog/">Blog</a> </li>
                    <li class="men_5_0"> <a href="/contact.php">Contact</a> </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main>
