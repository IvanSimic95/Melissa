<?php
$sql = "SELECT * FROM orders WHERE order_status = 'processing' OR order_status = 'shipped' OR order_status = 'paid' ORDER BY order_id DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows == 0) {
                        } else {
                        while ($row = $result->fetch_assoc()) {
                        $time = time_ago($row["order_date"]);
                        $product = ucwords($row["order_product"]);
                        switch ($product) {
                                case "Husband":
                                 $product = "Future Husband Drawing";
                                  break;
                              case "Pastlife":
                                  $product = "Past Life Drawing";
                                  break;
                              case "Baby":
                                  $product = "Future Baby Drawing";
                                  break;
                              case "Soulmate":
                                  $product = "Soulmate Drawing";
                                  break;
                              case "Twinflame":
                                      $product = "Twin Flame Drawing";
                                      break;
                              }
                        if($row["order_status"]=="shipped"){$status="completed";}else{$status = $row["order_status"];}
                        echo '<tr style="cursor: pointer;" id="' . $row["order_id"] . '" onclick="buttonClicked(this.id)">
                        <td>#' . $row["order_id"] . '</td>
                        <td>' . $time . '</td>
                        <td>' . $row["user_name"]. '</td>
                        <td>' . $row["order_email"]. '</td>
                        <td>' . $product. '</td>
                        <td><span class="sbadge sbadge-' . $status. '">' . $status. ' <i class="fas fa-check"></i><i class="fas fa-stream"></i><i class="fas fa-redo"></i><i class="fas fa-ban"></i></span></td>
                        <td>$' . $row["order_price"]. '</td>
                        <td>' . $row["order_priority"]. '</td>
                        </tr>
                        ';
                        }
                        $conn->close();
                                }
                                ?>
<style>
span.sbadge{
    border-radius: 0.25rem !important;
    padding: 0.5rem !important;
    text-transform: capitalize!important;
    font-weight:600!important;
    text-align: center;
  }
  
  span.sbadge-pending{
  color: #9d5228;
  background-color: #fde6d8;
  }
  span.sbadge-completed{
  color: #00864e;
  background-color: #ccf6e4;
  }
  span.sbadge-processing{
  color: #1c4f93;
  background-color: #d5e5fa;
  }
  span.sbadge-canceled{
  color: #7d899b;
  background-color: #e3e6ea;
  }
  
  
  span.sbadge .fas{
  display:none;
  }
  span.sbadge-completed .fa-check{
  display:inline-block;
  }
  span.sbadge-processing .fa-redo{
  display:inline-block;
  }
  span.sbadge-pending .fa-stream{
  display:inline-block;
  }
  span.sbadge-canceled .fa-ban{
  display:inline-block;
  }
</style>