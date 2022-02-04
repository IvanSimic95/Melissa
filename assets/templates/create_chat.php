<?php
if($createChat=="1"){
$signature = hash_hmac('sha256', strval($order_id), 'sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL');
?>
 <div id="talkjs-container-<?php echo $order_id; ?>" style="width: 90%; margin: 30px; height: 500px; position:fixed;bottom:0;right:0;z-index:999;display:none !important">
     <i>Loading chat...</i>
 </div>

<script>
    (function(t,a,l,k,j,s){
    s=a.createElement('script');s.async=1;s.src="https://cdn.talkjs.com/talk.js";a.head.appendChild(s)
    ;k=t.Promise;t.Talk={v:3,ready:{then:function(f){if(k)return new k(function(r,e){l.push([f,r,e])});l
    .push([f])},catch:function(){return k&&new k()},c:l}};})(window,document,[]);
</script>


<script>  
    Talk.ready.then(function() {
      var other = new Talk.User({
          id: "<?php echo $order_id; ?>",
          name: "<?php echo $first_name; ?>",
          email: "<?php echo $order_email; ?>",
          photoUrl: "https://avatars.dicebear.com/api/adventurer/<?php echo $order_email; ?>.svg?skinColor=variant02",
          role: "customer",
          custom: {
          email: "<?php echo $order_email; ?>",
          lastOrder: "<?php echo $order_id; ?>"
          }
      });
      var me = new Talk.User("administrator");
      window.talkSession = new Talk.Session({
          appId: "t2X08S4H",
          me: other,
          signature: "<?php echo $signature; ?>"
      });
      var conversation = talkSession.getOrCreateConversation("<?php echo $order_id; ?>");
          conversation.setAttributes({
          subject: "<?php echo "Order #" . $order_id . " | " .ucwords($order_product)." Drawing"; ?>",
          custom: { 
          category: "<?php echo $order_product; ?>", 
          status: "Paid"
          }
      });

      conversation.setParticipant(other);
      conversation.setParticipant(me);

        var chatbox = window.talkSession.createChatbox(conversation);
        chatbox.mount(document.getElementById("talkjs-container-<?php echo $order_id; ?>"));
    })

</script>
<?php
}
?>