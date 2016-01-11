<?php
$headers = 'From: irfank@karmora.com' . "\r\n";
//$mail =       mail('ghulamghousfarid@aol.com', 'My Subject', "this is test message");
//$mail =         imap_mail('aftab@etx-touchpoint.com', 'My Subject -- jjj', "this is test message -- imap_mail -- sendmail stop", $h$
$mail =       mail('aftab@etx-touchpoint.com', 'My Subject', "this is test message - sendmail I tithink");
if($mail) {
echo "all is well";
}
else {
echo "not OK";
}
exit;
$gdinfo = gd_info();
if($gdinfo['FreeType Support']) {echo 'FreeType Support Enabled';}
?>
