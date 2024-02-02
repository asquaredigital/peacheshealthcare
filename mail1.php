<?php
error_reporting( E_ALL );
$from = "test@peacheshealthcare.com";
$to = "mailhostingserver@gmail.com";
$subject = "PHP Mail Test script";
$message = "This is a test to check the PHP Mail functionality and crons are working or not";
$headers = "From:" . $from;
mail($to,$subject,$message, $headers);
echo "Test email sent";
?>