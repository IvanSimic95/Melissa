<?php
$ch = curl_init();
$authorization = "Bearer sk_test_dmh9xKYFEPiN2BxC0Z9GuAlrdEe6kRKL";
curl_setopt($ch, CURLOPT_URL, 'https://api.talkjs.com/v1/t2X08S4H/files');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
$target = '/home/melissapsychic/public_html/assets/mail/delivery-images/64088-52.jpg';
$cfile = curl_file_create($target);
$imgdata = array('file' => $cfile);
curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
$headers = array();
$headers[] = 'Content-Type: multipart/form-data';
$headers[] = 'Authorization: ' . $authorization;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
echo $result ;
 ?>
