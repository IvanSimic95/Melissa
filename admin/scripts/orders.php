<?php
$sql = "SELECT * FROM orders WHERE order_status = 'processing' OR order_status = 'shipped'  ORDER BY order_id DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows == 0) {
                        } else {
                        while ($row = $result->fetch_assoc()) {
                        $time = time_ago($row["order_date"]);
                        echo '<tr style="cursor: pointer;" id="' . $row["order_id"] . '" onclick="buttonClicked(this.id)">
                        <td>#' . $row["order_id"] . '</td>
                        <td>' . $time . '</td>
                        <td>' . $row["user_name"]. '</td>
                        <td>' . $row["order_email"]. '</td>
                        <td>' . $row["order_product"]. '</td>
                        <td>' . $row["order_status"]. '</td>
                        <td>$' . $row["order_price"]. '</td>
                        <td>' . $row["order_priority"]. '</td>
                        </tr>
                        ';
                        }
                        $conn->close();
                                }
                                ?>