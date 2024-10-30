<?php
// Define variables and set them to empty values
$name = $email = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));

    // Check that data was sent to the mailer
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Set the recipient email address.
        // Update this to your desired email address.
        $recipient = "contact@johnoptic.io";
        
        // Set the email subject.
        $email_subject = "New contact from $name: $subject";
        
        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Message:\n$message\n";
        
        // Build the email headers.
        $email_headers = "From: $name <$email>";
        
        // Send the email.
        if (mail($recipient, $email_subject, $email_content, $email_headers)) {
            // Success response
            echo "Thank you for your message!";
        } else {
            // Error response
            echo "Oops! Something went wrong, and we couldn't send your message.";
        }
        
    } else {
        echo "Please complete the form and try again.";
    }

} else {
    echo "There was a problem with your submission, please try again.";
}
?>
