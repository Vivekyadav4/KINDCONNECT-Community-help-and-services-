<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Sends an email using PHPMailer configuration.
 *
 * @param string $to Recipient email address.
 * @param string $subject Email subject.
 * @param string $body Email body (HTML content).
 * @return bool True on success, false on failure.
 */
function send_mail(string $to, string $subject, string $body): bool {
    $mail = new PHPMailer(true);

    try {
        // Server settings (Your Mailtrap/SMTP Config)
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io'; // <-- Check your Host
        $mail->SMTPAuth   = true;
        $mail->Username   = '22c57546c514bb';        // <-- Check your Username
        $mail->Password   = '****075d';             // <-- Check your Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 2525;

        // Recipients
        $mail->setFrom('no-reply@kindconnect.com', 'KindConnect');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error instead of echo (since this is an API call)
        error_log("Message could not be sent to $to. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}