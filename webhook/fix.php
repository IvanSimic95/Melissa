<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/vars.php';

$sql = "SELECT * FROM orders WHERE first_name = ''";
$sqlResoult = $conn->query($sql);

	if($sqlResoult->num_rows == 0) {
	   echo "No Orders";
	} else {
		echo "Processing Orders: ".$sqlResoult->num_rows."<br><br>";
		while($row = $sqlResoult->fetch_assoc()) {
            $orderDate = $row["order_date"];
			$orderName = $row["user_name"];
			$ex = explode(" ",$orderName);
			$fName = $ex["0"];
			$orderID = $row["order_id"];
			$orderEmail = $row["order_email"];
			$orderAge = $row["user_age"];
			$orderPrio = $row["order_priority"];
			$orderProduct = $row["order_product"];
			$orderSex = $row["pick_sex"];
			$userSex = $row["user_sex"];
			$date1 = $orderDate;
			$date2 =  date("Y-m-d H:i:s");
			$start = new \DateTime($date1);
			$end = new \DateTime($date2);
			$interval = new \DateInterval('PT1H');
			$periods = new \DatePeriod($start, $interval, $end);
			$hours = iterator_count($periods);
            echo $orderID."<br>";
        }

    }
?>