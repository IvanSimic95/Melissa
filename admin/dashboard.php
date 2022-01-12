<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/head.php';
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/navbar.php';
?>

<div class="container-fluid px-4">


<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/scripts/charts.php'; ?>
    <div class="row justify-content-center" style="margin-top:20px;">
        <div class="col-xl-9 col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Orders
                </div>
                <div class="card-body">
                    <table id="datatables" class="table table-striped table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                        include $_SERVER['DOCUMENT_ROOT'].'/admin/scripts/orders.php';
                        ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Time</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Priority</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-footer small text-muted"><i class="fa fa-clock" style="margin-right:5px;"></i>Updated
                    <?php echo time_ago(date('F jS, Y, H:i:s')); ?> </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-comment"></i>
                    Orders Chat
                </div>
                <div class="card-body">
                  
                    <div id="talkjs-container" style="margin: 0px; height: 100%; width:100%;">
                        <i>Click on chat ID in table to load it.</i>
                    </div>
                </div>
                <div class="card-footer small text-muted"><i class="fa fa-clock" style="margin-right:5px;"></i>Updated
                    <?php echo time_ago(date('F jS, Y, H:i:s')); ?> </div>
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
<script>
                    function buttonClicked(conversationId) {
                        var me = new Talk.User(654321252);
                        var other = conversationId;
                        window.talkSession = new Talk.Session({
                            appId: "tMXnCHK2",
                            me: me,
                            other: other
                        });
                        var conversation = window.talkSession.getOrCreateConversation(conversationId);
                        const chatbox = talkSession.createChatbox();

                        chatbox.select(conversation);
                        chatbox.mount(document.getElementById('talkjs-container'));
                        conversation.setParticipant(me);
                    };
                    </script>
<script>
$(document).ready(function() {
    $('#datatables').DataTable( {
        "ordering": false,
        "pagingType": "full_numbers",
        "order": [[ 0, "desc" ]]
    } );
} );
</script>

<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/footer.php';