<?php
// set parameters and execute
$cookie_id = $_GET['cookie_id'];
$user_age = $_GET['form_year'];
$user_name = $_GET['form_name'];
$order_product = $_GET['product'];
$order_priority = $_GET['priority'];
$order_date = date('Y-m-d H:i:s');

?>
<?php if($user_name ) {
  ?>

<?php
	$domain = $_SERVER['SERVER_NAME'];
	if($domain == "melissa.test"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "melissap_melissa";
}else{
    $servername = "localhost";
    $username = "melissap_melissapsychic";
    $password = ";w[#i&[zcrm?";
    $dbname = "melissap_melissa";
}

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }



    $sql = "INSERT INTO orders (order_id, cookie_id, user_age, user_name, order_status, order_date, order_email, order_product, order_priority, order_price, buygoods_order_id, pick_sex)
                          VALUES (NULL, '$cookie_id', '$user_age', '$user_name', 'pending', '$order_date', '', '$order_product', '$order_priority', '', '', 'male')";


    if ($conn->query($sql) === TRUE) {
      //echo "New record created successfully";
    } else {
      //echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>



<?php $title = "Order | Melissa Psychic"; ?>
<?php $description = "Order"; ?>
<?php $menu_order="men_0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>

<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Order
  </div>
</div>


<div class="general_section">
  <div class="container">
      <h1>You will be redirected to the Payment Processor. Please dont close this page</h1>
  </div>
</div>
<script>
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
var prio = getUrlParameter('priority');
var product = getUrlParameter('product');

 window.location.href = "https://www.buygoods.com/secure/checkout.html?account_id=6274&product_codename=" + product + prio + "&redirect=aHR0cHM6Ly9tZWxpc3NhLXBzeWNoaWMuY29tL3N1Y2Nlc3MucGhw";
</script>


<?php
}else{
  header('Location: /');
}

 ?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php'; ?>
