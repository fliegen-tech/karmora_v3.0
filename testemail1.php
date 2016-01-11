<?php
$to = "aftab@etx-touchpoint.com";
$subject = "My subject";
$txt = "Hello world testing message!";
$headers = "From: aftab@etx-touchpoint.com" . "\r\n" ;
"CC: aftab@etx-touchpoint.com";

mail($to,$subject,$txt,$headers);
?>
