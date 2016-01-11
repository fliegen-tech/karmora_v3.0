<?php 
//phpinfo();
//echo date('Y-m-d H:i:s'); 
//echo ini_get('date.timezone');
//exit;

// Create connection
$host = $_SERVER['HTTP_HOST'];

static $conn;
/*
if ($host == 'test.karmora.com' || $host == 'localhost') {
    $db_host = 'localhost';
    $db_name = 'karmora_v2_1';
    $db_user = 'karmoralive';
    $db_pwd = '8sEdTG8tuPwqUrSV';
//	$baseUrl = 'http://localhost/irfan/DPLKarmora/';
}
 * 
 */
if ($host == 'www.karmora.com')
{
    $db_host = '192.168.100.10';
    $db_name = 'karmora_v2_2';
    $db_user = 'karmoralive';
    $db_pwd = 'Sohail@123';
//	$baseUrl = 'https://www.karmora.com/';
}
$conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);

// Check connection
if (!$conn) {
    echo "Failed to connect to MySQL: " . mysql_error();
}

function krmRoundNumber($number) {
	$number = round($number, 2);
	return $number;
}
