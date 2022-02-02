<script type="text/javascript">
var fs = require('fs');
const options = {
  method: "POST",
  url: "https://api.talkjs.com/v1/t2X08S4H/conversations/files",
  // port: 443,
  headers: {
      'Authorization': 'Bearer sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL',
      "Content-Type": "multipart/form-data"
  },
  formData : {
      "image" : fs.createReadStream("/assets/mail/delivery-images/57729-60.jpg")
  }
};

request(options, function (err, res, body) {
  if(err) console.log(err);
  console.log(body);
});
</script>
