
<?php
    // Check for empty fields
		if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])	||
				   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
				   {
					echo "No arguments Provided!";
					return false;
				   }

				   require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
				   $pass1 = "Adasu8oazst";
				   $pass2 = "ete21435";
				   $pass = $pass1.$pass2;
// Create the Transport
$transport = (new Swift_SmtpTransport('ssl://smtp.gmail.com', 465))
  ->setUsername('contact@melissa-psychic.com')
  ->setPassword($pass)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

$name = $_POST['name'];
$email_address = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$email_subject = "Order #".$subject.":  ".$name;
$email_body = "You have received a new message from your melissa-psychic.com contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nSubject: $subject\n\nMessage:\n$message";

// Create a message
$message = (new Swift_Message($email_subject))
  ->setFrom(['contact@melissa-psychic.com' => 'Melissa'])
  ->setTo(['contact@melissa-psychic.com'])
  ->setReplyTo([$email_address])
  ->setBody($email_body)
  ;

// Send the message
$result = $mailer->send($message);
echo $result;
?>