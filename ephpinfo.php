<?php

// Please specify your Mail Server - Example: mail.example.com.
//ini_set("SMTP","smtp.office365.com");

// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
//ini_set("smtp_port","587");

// Please specify the return address to use
//ini_set('sendmail_from', 'ehsan.haq@aol.com');


$to      = 'ehsan1973@hotmail.com';
$subject = 'Sohail Please check mail header';
$message = 'if this is enough - mail sent from from p02Web Server -- header has enough informaiton - and karmora.com is not blacklisted anywhere';
$headers = 'From: postmaster@karmora.com' . "\r\n" .
    'Reply-To: postmaster@karmora.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers, "-fnoreply@karmora.com");
?>
