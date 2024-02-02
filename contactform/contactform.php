<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        error_reporting( E_ALL );

        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $lname = trim($_POST["lname"]);
        $type = trim($_POST["type"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($type) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }
        
        // Build the email content.
        $email_content = "First Name: $name\n\n";
        $email_content .= "Last Name: $lname\n\n";
        $email_content .= "Type: $type\n\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message: $message\n\n";
        $from ="test@peacheshealthcare.com";
        $to = "asquaredigitalsolutions@gmail.com";
        $subject ="$type from $name";
        $message1 =$email_content;
        $headers ="From:" . $from;
       
        // Send the email.
        if (mail($to,$subject,$message1, $headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "OK";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
