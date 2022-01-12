<link rel="stylesheet" href="/assets/css/faq.css">



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

$variant = rand(1,3);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query('set character_set_client=utf8');
$conn->query('set character_set_connection=utf8');
$conn->query('set character_set_results=utf8');
$conn->query('set character_set_server=utf8');
$conn->set_charset('utf8mb4');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM faq ORDER BY id DESC";

$result = $conn->query($sql);

$count = $result->num_rows;

if($result->num_rows != 0) {
echo '<ul class="faq">';
while($row = $result->fetch_assoc()) {

echo '
<div class="my-divider">
<li class="q"><i class="fas fa-chevron-right"></i><span class="faq-question">'.$row["question"].'</span></li>
<li class="a">'.$row["answer"].'</li>
</div>';
}

echo '</ul>';




} else {
    echo "No FAQ";
}
  $conn->close();
?>
<script>
// Accordian
var action="click";
var speed="500";

$(document).ready(function() {
    // Question handler
    $('li.q').on(action, function() {
        // Get next element
		$(this).toggleClass("remove-radius");
        $(this).next().slideToggle(speed).siblings('li.a').slideUp();
		$(this).find("i").toggleClass("rotate");
    });
});
</script>
