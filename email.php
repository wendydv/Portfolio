<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['submit'])) { 
 
    $email_to = "wdiazvaldes@gmail.com";
    $email_subject = "Website contact";
    $email_subject_reply = "Thank you for contacting me!";
    
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['lastname']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
    $first_name = $_POST['name'];
    $last_name = $_POST['lastname']; 
    $email_from = $_POST['email']; 
    $telephone = $_POST['phone']; 
    $comments = $_POST['message'];
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br/>';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br/>';
  }
 
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br/>';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "<h3>Message sent it from Wendy Personal Portfolio contact form.</h3>";
 
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
    $email_message .= "<h3>Details below:</h3>
	<p>First Name: {$first_name}</p>
	<p>Lat Name: {$last_name}</p>
	<p>Email: {$email_from}</p>
	<p>Telephone: {$telephone}</p>
	<p>Comments: {$comments}</p>";
	
   $email_message_reply = "<p>Dear {$first_name} {$last_name},</p>
	<p>I have received your message and I will be in touch with you as soon as posible.</p>
	<p>Thank you for contacting me.</p>
	<p>Sincerely,</p>
	<p>Wendy Diaz Valdes</p>";

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
	
    $mail->isSMTP(); 
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 0;
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
   // $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port =  587;
    $mail->SMTPAuth   = true; 
    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
       )
    );
    $mail->Username   = 'info@wdiazvaldes.com';                     
    $mail->Password   = 't*uWE2W~FHMf';                               
	 

    //Recipients
    $mail->setFrom('info@wdiazvaldes.com', 'Wendy Diaz Valdes');

    // Content
    $mail->isHTML(true);         

	$users = [
	  ['email' => $email_from, 'name' => $first_name],
	  ['email' => $email_to, 'name' => 'Wendy Diaz Valdes']
	];

	foreach ($users as $user) {
		if($user['email'] == "wdiazvaldes@gmail.com"){
		  $mail->addAddress($user['email'], $user['name']);
		  $mail->Subject = $email_subject;
		  $mail->Body = $email_message;
		  $mail->AltBody = $email_message;

		}else{
			 $mail->addAddress($user['email'], $user['name']);
			 $mail->Subject = $email_subject_reply;
			 $mail->Body = $email_message_reply;
			 $mail->AltBody = $email_message_reply;
		}

      if($mail->send()){
	//	echo 'Message has been sent';
    	 header("Location:thank_you.html");
	  }
	  $mail->clearAddresses();
	}

	$mail->smtpClose();
	
	 } catch (Exception $e) {
	   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
	
	header("Location:thank_you.html");
 }
?>