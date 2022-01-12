<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/head.php';
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/navbar.php';
?>

<div class="container-fluid px-4">



    <div class="row justify-content-center" style="margin-top:20px;">
        <div class="col-xl-8 col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                  Add New Blog Post
                </div>
                <div class="card-body">
              <?php  include $_SERVER['DOCUMENT_ROOT'].'/admin/scripts/tinymce.php'; ?>
                </div>
                <div class="card-footer small text-muted"></div>
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


<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/footer.php';