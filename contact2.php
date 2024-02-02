<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

// Get form data
$name = $_POST['name'];
$lname = $_POST['lname'];
$type = $_POST['type'];
$email = $_POST['email'];
$message1 = $_POST['message1'];
$subject = 'Enquiry Form the Website';

// Set up email content with HTML line breaks
$message = "Name:$name<br>LastName:$lname<br>Type:$type<br>Email:$email<br>Subject:$subject<br>Message:$message1";

ini_set('display_errors', 1);
error_reporting(E_ALL);
$from = "contact@peacheshealthcare.com";
$to = "admin@peacheshealthcare.com";
$subject = "Enquiry Form the Website";
$replyTo = $email;

$headers = "From: $from\r\n";
$headers .= "Reply-To: $replyTo\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";

if (mail($to, $subject, $message, $headers)) {
    // Email sent successfully
    $response = array('message' => 'Email sent successfully!');
    echo json_encode($response);
} else {
    // Failed to send email
    $response = array('message' => 'Failed to send email.');
    echo json_encode($response);
    echo "Error: " . error_get_last()['message'];
}
?>
