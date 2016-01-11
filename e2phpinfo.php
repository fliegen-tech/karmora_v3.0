<?php
require 'class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPAuth = true;
$mail->Host = 'smtp.office365.com'; // "ssl://smtp.gmail.com" didn't worked
$mail->Port = 578;
$mail->SMTPSecure = 'ssl';
// or try these settings (worked on XAMPP and WAMP):
// $mail->Port = 587;
// $mail->SMTPSecure = 'tls';
 
 
$mail->Username = "your_gmail_user_name@gmail.com";
$mail->Password = "your_gmail_password";
 
$mail->IsHTML(true); // if you are going to send HTML formatted emails
$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
 
$mail->From = "ehsanulhaq@cats.com.pk";
$mail->FromName = "Ehsan ul Haq";
 
$mail->addAddress("ehsan1973@hotmail.com","Ehsan Hotmail");
$mail->addAddress("ehsan@cats.com.pk","Ehsan CatsBPO");
 
//$mail->addCC("user.3@ymail.com","User 3");
//$mail->addBCC("user.4@in.com","User 4");
 
$mail->Subject = "Testing PHPMailer with localhost";
$mail->Body = "Hi,<br /><br />This system is working perfectly.";
 
if(!$mail->Send())
    echo "Message was not sent <br />PHPMailer Error: " . $mail->ErrorInfo;
else
    echo "Message has been sent";
?>
