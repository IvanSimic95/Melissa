<?php 
header('Content-type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php';
$title = "Soulmate Drawing | Melissa Psychic";
$description = "I will draw your SOULMATE with 100% accuracy";
$menu_order="men_2_0"; 

$t_product_name = "SOULMATE";
$t_product_image = '/assets/img/mobonly.jpg';
$t_product_image_pc = '/assets/img/ptdsk.png';
$t_product_form_name = "soulmate";
$t_product_hover_text = "I will connect with your higher soul, discover accurate and comprehensive information about your destiny, and explore the blockages you may have in your love life, career, health, or relationships with others. I will use your energies and frequencies so I can identify your strength, weaknesses and offer you guidance and clarity for a better and happier life.";
$t_product_sales = "8700";
$t_product_title = "I will use my Psychic Abilities to draw your Soulmate with 100% accuracy";
$t_about_title =  "<center><div style='color:#ff00f3;'> <b>I WILL USE MY PSYCHIC ABILITIES TO DRAW YOUR SOULMATE  WITH 100% ACCURACY</b></div></center>";
$t_about_content = "
<div style='color:#a700f5;'> <p> I am <b>Melissa</b>, the most renowned psychic artist in the world, and I guarantee that I will find your true soulmate in this lifetime and reunite both of you, as well as make sure that you two will live a life full of joy and fulfillment on all plans. </p>
<br>
<p> My soulmate drawings have nearly 100% accuracy, as I am using a unique combination of psychic techniques, involving empathic projection, clairsentience and clairvoyance. My knowledge in psychic art and spiritual healing allows me to see essential parts of your future, such as when you will be ready to fully let true love into your life and how you can instantly heal any type of blockages you may have. </p>
<p> Thus, I will tell you exactly when you will meet your soulmate and many important traits and characteristics about their personality and physical appearance. All I need from you is your name and your date of birth, and I will take care of everything else. </p>
<p> First, I will enter into a deep meditative trance state, where I am shown the facial features and life details of who is meant for you in this lifetime. With the help of automatic drawing, I then create a beautiful portrait and an in-depth description of their personality. The final step is my connection with your aura frequencies, where I will find out exactly when you and your other half reunite in this lifetime. </p>
<p> Finding your soulmate will help you blossom beautifully, as your love will become more delicate and your joy will take over all the sadness you have felt in the past. You will be ready to pursue your dreams and ideals, with feelings of love and protection embracing your heart. </p>
<p><b> Due to my excellent feedback from stars and celebritries, thousands of people came to me for help with finding their soulmate, and I did my best to help everyone, as each of us deserve to be fulfilled and know what true love feels like. If you choose to work with me, I will be alongside you and guide you throughout the whole process, making sure that you receive exactly what you wish for. </p>
<br> </div>
<center> <p> <h2> <div style='color:#ff00f3;'> GUARANTEED 100% ACCURACY OR MONEY BACK </div> </h2> </p> </b> </center> 
<center> <img src='/assets/img/26down.png'> </center>
";


$PRurl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"],'?');

$productMETA = <<<EOT
    <!-- Meta Catalog Tags --> 
    <meta property="og:url" content="$PRurl" />
    <meta property="og:type" content="website" />

    <meta property="product:brand" content="Melissa Psychic">
    <meta property="product:availability" content="in stock">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="29.99">
    <meta property="product:price:currency" content="USD">
    <meta property="product:retailer_item_id" content="$t_product_form_name">


EOT;


include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/product_template.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';