<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

use SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom("contact@melissa-psychic.com", "Melissa Psychic");
$email->setSubject("The Timer’s Going Off on Your Order!");
$email->addTo(
    "email@isimic.com",
    "Ivan Simic",
    [
        "name" => "Ivan Simic",
        "email" => "email@isimic.com",
        "status" => "Pending Payment",
        "product" => "Soulmate Drawing",
        "orderid" => "123123",
        "partner" => "Female",
        "birthday" => "29.03.1995",
        "price" => "29.99",
        "restorelink" => "https://melissa-psychic.com",
        "msg" => "Look's like you forgot to finish your order... But don't worry, we kept it safe for you! Click the button below to finish your purchase & get closer to your soulmate."
    ]
);
$email->setTemplateId("d-864f0f07f9cd43a99ed7b43a9e82798a");
$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) { 
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}


?>