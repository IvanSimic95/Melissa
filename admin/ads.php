<?php
session_start();
$email_address= !empty($_SESSION['email'])?$_SESSION['email']:'';
if(empty($email_address))
{
  header("location:index.php");
}

$todaysDate = date("Y-m-d");
$date = $todaysDate;

$startDate = "$date";
$endDate = "$date";

if(isset($_GET['sdate'])){
$startDate = $_GET['sdate'];
}

if(isset($_GET['edate'])){
$endDate = $_GET['edate'];
}

if(isset($_GET['c'])){
    $campaign = $_GET['c'];
    }
    
if(isset($_GET['cname'])){
$campaignName = $_GET['cname'];
}

if(isset($_GET['a'])){
$adset = $_GET['a'];
}


include_once $_SERVER['DOCUMENT_ROOT'].'/admin/partials/head.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/admin/partials/navbar.php';
?>
<script src="https://cdn.datatables.net/searchpanes/1.4.0/js/dataTables.searchPanes.min.js"></script>
<div class="container-fluid px-4">


    <div class="row justify-content-center" style="margin-top:20px;">
        <div class="col-xl-12 col-md-12">
        <a href="/admin/adsets.php?sdate=<?php echo $startDate; ?>&edate=<?php echo $endDate; ?>&c=<?php echo $campaign; ?>&cname=<?php echo $campaignName; ?>" style="width:100%;" class="btn btn-outline-secondary show-orders btn-block mb-3" type="submit">Back to Adsets!</a>
            <div class="card mb-4">
                <div class="card-header">
                   

                    <span style="float:left;">
                    <h4> <i class="fas fa-table me-1"></i>
                    Ads for <?php echo $campaignName; ?> (<?php echo $campaign; ?>) - Adset: <?php echo $adset; ?> </h4>
</span>


                    <span style="float:right;"> 
                    <form class="form-inline" action="" method="get">
<div class="input-group">
<input type="text" name="sdate" class="form-control" id="sdate" value="<?php echo $startDate; ?>">
<input type="text" name="edate" class="form-control" id="edate" placeholder="End Date" value="<?php echo $endDate; ?>">

<input type="hidden" name="c" class="form-control" id="c" value="<?php echo $campaign; ?>">
<input type="hidden" name="cname" class="form-control" id="c" value="<?php echo $campaignName; ?>">
<input type="hidden" name="a" class="form-control" id="a" value="<?php echo $adset; ?>">

  <button class="btn btn-outline-secondary show-orders" type="submit">Save!</button>
</div></form>
</span>



                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sales Count</th>
                                <th>Sales in $</th>
                            
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            
                        include_once $_SERVER['DOCUMENT_ROOT'].'/admin/scripts/ads.php';
                        ?>

                        </tbody>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                                <th>Sales Count</th>
                                <th>Sales in $</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer small text-muted"><i class="fa fa-clock" style="margin-right:5px;"></i>From: <?php echo $startDate; ?> - <?php echo $endDate; ?></div>
            </div>
        </div>

        
    </div>
</div>
</div>
</div>
<style>
.card {
    height: 100%;
}
</style>


<?php include_once $_SERVER['DOCUMENT_ROOT'].'/admin/partials/footer.php';