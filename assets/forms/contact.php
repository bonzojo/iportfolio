<?php

// Set the content type to JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Initialize response array
    $response = [];

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $response['error'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error'] = "Invalid email format.";
    } else {
        $to = "bonzojo@proton.me";
        $headers = "From: $name <$email>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $email_subject = "Contact Form: $subject";
        $email_message = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        if (mail($to, $email_subject, $email_message, $headers)) {
            $response['success'] = "Message sent successfully!";
        } else {
            $response['error'] = "Unable to send message. Please try again later.";
        }
    }

    // Output the response as JSON
    echo json_encode($response);
    exit; // Ensure no further output
}
?>