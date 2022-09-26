<?php 
header('Content-type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php';
$title = "Spirit Guide Weekly | Melissa Psychic";
$description = "I will draw your Higher Self with 100% accuracy";
$menu_order="men_2_0"; 
$bgproduct = "spiritguide12";

$price1 = "3.80";
$price2 = "39.99";
$price3 = "49.99";

$discount1 = "19.99";
$discount2 = "399.99";
$discount3 = "499.99";

$t_product_name = "SPIRITGUIDE";
$t_product_image = '/assets/img/da105.jpg';
$t_product_image_pc = '/assets/img/da105.jpg';
$t_product_form_name = "spiritguide";
$t_product_hover_text = "I will connect with your higher soul, discover accurate and comprehensive information about your destiny, and explore the blockages you may have in your love life, career, health, or relationships with others. I will use your energies and frequencies so I can identify your strength, weaknesses and offer you guidance and clarity for a better and happier life.";
$t_product_sales = "8700";
$t_product_title = "SPIRIT GUIDE WEEKLY READING";
$t_about_title =  "<center><div style='color:#ff00f3;'> <b> SPIRIT GUIDE WEEKLY READING</b></div></center>";
$t_about_content = "
<div style='font-size:120%'><p> <b> Wonder what your spirit guides want to tell you?  </b> </p>
<br>
<p>In this reading I will connect with your spirit guide and tell you <b>EXACTLY</b> what message(s) he have for you. </p>
<p> The information you will receive from your Spirit Guide will help you to improve particular aspects of your life </p>
<br><br>

<div style='color:#a700f5;'><div style='font-size:100%'><center>  <b>MAXIMUM DISCRETION: DIGITAL DELIVERY ONLY! </p> </center>

<p>All orders are delivered to the provided email address and also can be accessed from the user dashboard. Nothing will be shipped to your home address! </b></div>
<br>
<p>The order will be delivered to email and user dashboard. </p> 
";


$PRurl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"],'?');

$productMETA = <<<EOT
    <!-- Meta Catalog Tags --> 
    <meta property="og:url" content="$PRurl" />
    <meta property="og:type" content="website" />

    <meta property="product:brand" content="Melissa Psychic">
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="$price1">
    <meta property="product:price:currency" content="USD">
    <meta property="product:retailer_item_id" content="$t_product_form_name">


EOT;


include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/product-template-spirit.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';