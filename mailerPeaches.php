<?php

require '../vendor/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Script accessed directly without form submission
    $response = array('message' => 'Invalid request.');
    echo json_encode($response);
    exit;
}

$config = require '../vendor/config.php';

$awsKey = $config['aws']['key'];
$awsSecret = $config['aws']['secret'];
$awsRegion = $config['aws']['region'];

$sesClient = new SesClient([
    'version' => 'latest',
    'region' => $awsRegion,
    'credentials' => [
        'key' => $awsKey,
        'secret' => $awsSecret,
    ],
]);

// Get form data
$u_name = $_POST['name'];
$lname = $_POST['lname'];
$type = $_POST['type'];
$u_email = $_POST['email'];
$msg = $_POST['message1']; 

// Set up email headers
$headers = "From: contact@peacheshealthcare.com" . "\r\n" .
           "Reply-To: $u_email" . "\r\n" ;

// Set up email content
$subject = 'Enquiry Form the Website';
$message = "Name: $u_name\nLastname: $lname\nType: $type\nEmail: $u_email\nMessage: $msg";
$senderEmail = 'asquaremailer@gmail.com';
$recipientEmail = 'admin@peacheshealthcare.com';
//$recipientEmail = 'elavarasan5193@gmail.com';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $result = $sesClient->sendEmail([
        'Destination' => [
            'ToAddresses' => [$recipientEmail],
        ],
        'Message' => [
            'Body' => [
                'Text' => [
                    'Charset' => 'UTF-8',
                    'Data' => $message,
                ],
            ],
            'Subject' => [
                'Charset' => 'UTF-8',
                'Data' => $subject,
            ],
        ],
        'Source' => $senderEmail,
        'ReplyToAddresses' => [$u_email], // Specify Reply-To header
    ]);

    // Prepare JSON response
    $response = ["message" => "Email sent successfully"]; // Corrected key to lowercase
    echo json_encode($response);
} catch (AwsException $e) {
    // Prepare JSON error response
    $response = ['message' => 'Failed to send email.', 'error' => $e->getAwsErrorMessage()];
    echo json_encode($response);
}

?>
