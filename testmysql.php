<?php

$con=mysqli_connect("192.168.100.10","karmoralive","Sohail@123","karmora_v2_2");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"select * from view_page");

while($row = mysqli_fetch_array($result)) {
    var_dump($row);
  echo "<br>";
}

mysqli_close($con);
?>
