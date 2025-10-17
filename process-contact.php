<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// SES Configuration
$sender = 'info@medrides.ca';
$recipient = 'info@medrides.ca';
$usernameSmtp = 'AKIA6OBHS6YKQSERZ3X6'; 
$passwordSmtp = 'BF5TD4+G8irhhrx1eBTx3uv1f1msMonWy8WITNmSMMiI';
$host = 'email-smtp.us-east-1.amazonaws.com';
$port = 587;

if ($_POST && isset($_POST['input-text-name']) && isset($_POST['input-email']) && isset($_POST['input-textarea'])) {

// Debug: Log what we actually received
    error_log("DEBUG - Name: " . $_POST['input-text-name']);
    error_log("DEBUG - Email: " . $_POST['input-email']); 
    error_log("DEBUG - Message: " . $_POST['input-textarea']);
    
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $usernameSmtp;
        $mail->Password = $passwordSmtp;
        $mail->SMTPSecure = 'tls';
$name = htmlspecialchars($_POST['input-text-name']);
$email = htmlspecialchars($_POST['input-email']);
$message = htmlspecialchars($_POST['input-textarea']);       
$mail->Port = $port;

        $mail->setFrom($sender, 'MedRides Contact');
        $mail->addAddress($recipient);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Contact Form - MedRides';
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No form data received']);
}
?>
