<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/head.php';
include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/navbar.php';
?>
<div class="container-fluid px-4">
    <div class="row justify-content-start" style="">
        <div class="col-xl-8 col-md-8">
            <div class="card mb-4">
              
                
              
                    <div class="col-md-12" id="talkjs-container" style="height:800px;">
               
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
   Talk.ready.then(function() {
     var admin = new Talk.User({
         id: "administrator",
         name: "Melissa",
         email: "contact@melissa-psychic.com",
         photoUrl: "/assets/img/avatars/admin.png",
         role: "admin"
     });
     window.talkSession = new Talk.Session({
         appId: "t2X08S4H",
         me: admin
     });
     var inbox = window.talkSession.createInbox();
     inbox.mount(document.getElementById('talkjs-container'));
   })

</script>
<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/partials/footer.php';