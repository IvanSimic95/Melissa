<?php 
header('Content-type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php';
$title = "Soulmate Drawing | Melissa Psychic";
$description = "I will draw your SOULMATE with 100% accuracy";
$menu_order="men_2_0"; 
$bgproduct = "soulmate48";

$t_product_name = "SOULMATE";
$t_product_image = '/assets/img/14mob1.png';
$t_product_image_pc = '/assets/img/14dk.jpg';
$t_product_form_name = "soulmate";
$t_product_hover_text = "I will connect with your higher soul, discover accurate and comprehensive information about your destiny, and explore the blockages you may have in your love life, career, health, or relationships with others. I will use your energies and frequencies so I can identify your strength, weaknesses and offer you guidance and clarity for a better and happier life.";
$t_product_sales = "8700";
$t_product_title = "I Will Use My Psychic Abilities To Draw Your Soulmate";
$t_about_title =  "<center><div style='color:#ff00f3;'> <b>PSYCHIC PORTRAIT OF YOUR SOULMATE</b></div></center>";
$t_about_content = "
<b> <div style='font-size:130%'><p> My name is <b>Melissa</b>, a powerful Certified Psychic Artist who can help you easily find your Soulmate.</p>
<p> I am a strong empath and have high sensitivity to the emotional vibrations of my clients. I have extraordinary intuition and foresight when it comes to accessing and understanding the emotions and feelings of my clients on a deeper and more meaningful level.  </p>
<p>I have worked in important fields, and throughout my career I collaborated with the government, the law enforcement and many other institutions that needed my help to identify certain individuals. My services are appreciated by thousands of people from all over the world and I am grateful for every “thank you” message received after a Reading or a Soulmate Drawing.</p>

<br><b> <p> My soulmate drawings have 100% accuracy, as I am using a unique combination of psychic techniques, involving empathic projection, clairsentience and clairvoyance. My knowledge in psychic art and spiritual healing allows me to see essential parts of your future, such as when you will be ready to fully let true love into your life and how you can instantly heal any type of blockages you may have. </p> </b> 
<br><br> <p> Thus, I will tell you exactly when you will meet your soulmate and many important traits and characteristics about their personality and physical appearance. All I need from you is your name and your date of birth, and I will take care of everything else. </p>
<br><b> <p> First, I will enter into a deep meditative trance state, where I am shown the facial features and life details of who is meant for you in this lifetime. With the help of automatic drawing, I then create a beautiful portrait and an in-depth description of their personality. The final step is my connection with your aura frequencies, where I will find out exactly when you and your other half reunite in this lifetime. </p> </b> 
<br><p> Finding your Soulmate will help you blossom beautifully, as your love will become more delicate and your joy will take over all the sadness you have felt in the past. You will be ready to pursue your dreams and ideals, with feelings of love and protection embracing your heart. </p>
<br><p> <b> BONUS: I Will Tell You Exactly When Your Paths Cross </b> </p> <br>
<p> Finding your soulmate is important because it will bring significant changes in your life and guide you to reach a higher level of emotional and spiritual development. This person will not only be your romantic partner, but also your guide in the complex process of self-discovery and self-knowledge. </p>
<br> </b>
<center> <p> <h2> <div style='color:#a700f5;'> GUARANTEED 100% ACCURACY OR MONEY BACK: </div> </h2> </p> </b> </center> </div> 
 <p> <div style='color:#ff00f3;'><center><b> <h4>-  IF I DON'T SEE ANY SOULMATE FOR YOU IN MY VISION, YOUR ORDER WILL BE REFUNDED; <br>  <br>- IF MY PREDICTIONS DON’T COME TRUE WITHIN THE TIME FRAME I PROVIDE, YOU WILL RECEIVE A FULL REFUND, NO QUESTIONS ASKED. </h4> </b></center> </div></p>  
<br>
<div style='color:#a700f5;'><div style='font-size:120%'><center>  <b>MAXIMUM DISCRETION: DIGITAL DELIVERY ONLY! </p> </center> </div>
<div style='color:#ff00f3;'> <p>All orders are delivered to the provided email address and also can be accessed from the user dashboard. Nothing will be shipped to your home address! </b></div>
<br>
<p><center><img src='/assets/img/mel2.jpg'> </center></p>
<br>
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