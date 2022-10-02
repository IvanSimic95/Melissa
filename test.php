<?php

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
  ->setUsername('contact@melissa-psychic.com')
  ->setPassword('Dadada123!')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$name = "ivan";
$email_address = "ivan.simic2903@gmail.com";
$subject = "112233";
$message = "test message";

$email_subject = "Order #".$subject.":  ".$name;
$email_body = "You have received a new message from your soulmate-psychic.com contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nSubject: $subject\n\nMessage:\n$message";

// Create a message
$message = (new Swift_Message($email_subject))
  ->setFrom(['contact@melissa-psychic.com' => 'Ivan'])
  ->setTo(['contact@soulmate-psychic.com'])
  ->setReplyTo([$email_address])
  ->setBody($email_body)
  ;

// Send the message
$result = $mailer->send($message);
echo $result;
?>