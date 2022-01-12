<?php
session_start();

// set parameters and execute
$cookie_id = $_SESSION['user_cookie_id'];
$pick_sex = $_POST['pick_sex'];

if ($pick_sex) {
    ?>

<?php
$domain = $_SERVER['SERVER_NAME'];
    if ($domain == "melissa.test") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "melissap_melissa";
    } else {
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

    $sql = "UPDATE `orders` SET `pick_sex`='$pick_sex' WHERE cookie_id='$cookie_id'" ;


    if ($conn->query($sql) === true) {
        $sql = "SELECT * FROM orders WHERE cookie_id='$cookie_id'";

        $result = $conn->query($sql);

        if ($result->num_rows == 0 || $order_email == "") {
        } else {
            while ($row = $result->fetch_assoc()) {
                $order_id =  $row["order_id"];
                $user_name =  $row["user_name"];
                $order_email =  $row["order_email"];
                $order_product = 'Readings';
            }
        }
        // echo "Update successfully";
        session_unset();
        session_destroy();
    //unset($_COOKIE['user_cookie_id']);
    } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); ?>



<?php $title = "Readings | Melissa Psychic"; ?>
<?php $description = "Readings"; ?>
<?php $menu_order="men_0_0"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/session.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/header.php'; ?>

<div class="breadcrumbs">
  <div class="container">
    <a href="/index.php">Melissa</a> > Readings
  </div>
</div>


<div class="general_section upsale_page">
  <div class="container">
    <h1>You Unlocked a Secial Service!</h1>
    <h4>This is an explusive service which I'm only offering for a very few custommers. You can not get back to this
      page to buy later!</h4>
    <img src="/assets/img/psychic.jpg" alt="upsell">
    <form class="readings" action="/order2.php" method="get">
      <h2>Personal Psychic Reading</h2>
      <div class="form_box">
        <div class="radio_box">
          <div class="single_reading">
            <input type="checkbox" id="general" name="general" value="general" checked>
            <label class="inline" for="general">General Reading</label>
          </div>
          <div class="single_reading">
            <input type="checkbox" id="love" name="love" value="love">
            <label class="inline" for="love">Love Reading</label>
          </div>
          <div class="single_reading">
            <input type="checkbox" id="career" name="career" value="career">
            <label class="inline" for="career">Career Reading</label>
          </div>
          <div class="single_reading">
            <input type="checkbox" id="health" name="health" value="health">
            <label class="inline" for="health">Health Reading</label>
          </div>
          <input class="cookie" type="hidden" name="cookie_id"
            value="<?php echo $_SESSION['user_cookie_id']; ?>">


        </div>
      </div>

      <div class="meta_part">

        <div class="sides">
          <div class="price_box">
            <span class="new_prce">$19.99</span>
          </div>
          <input type="submit" name="form_submit" value="Add to my Purchase">

        </div>
      </div>
      <span>Woudn't it be great to just know the truth instead of cunsumming yourself with constant thoughts?</span>
      <a class="nothanks" href="/order-complete.php">No thanks</a>
    </form>
    <script>
      var $checkboxes = $('.single_reading input[type="checkbox"]');

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
  </div>
</div>
<?php
} else {
        header('Location: /');
    }

 ?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/templates/footer.php';
