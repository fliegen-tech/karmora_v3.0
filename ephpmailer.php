<?php
require '/etc/php-tcpdf/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'karmora-com.mail.protection.outlook.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'irfank@karmora.com';                 // SMTP username
$mail->Password = 'Irfan1122';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->From = 'irfank@karmora.com';
$mail->FromName = 'Karmora LLC';
$mail->addAddress('ehsan1973@hotmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('ghulamghousfarid@aol.com');               // Name is optional
$mail->addReplyTo('irfank@karmora.com', 'Information');
$mail->addCC('ghulamghousfarid@aol.com');
$mail->addBCC('ehaq73@gmail.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Testmail from Karmora LLC';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
