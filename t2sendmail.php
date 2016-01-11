<?php 
    $header .= "Reply-To: Some One <irfank@karmora.com>\r\n"; 
    $header .= "Return-Path: Some One <irfank@karmora.com.com>\r\n"; 
    $header .= "From: Karmora Cats Testing  <201501170543.t0H5hxw2028127@kstaging-web02.kstaging.d3.internal.cloudapp.net>\r\n"; 
    $header .= "Organization: Karmora LLC\r\n"; 
    $header .= "Content-Type: text/plain\r\n"; 
 
   mail("ghulamghousfarid@aol.com", "Test Message", "This is my message.", $header); 
//	mail("ehsan1973@hotmail.com", "Test Message", "This is my message.", $header);
?>
