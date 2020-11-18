<?php

require_once './lib/PHPMailer/Exception.php';
require_once './lib/PHPMailer/PHPMailer.php';
require_once './lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// print_r(send_email('futupas@gmail.com', 'Alex Pascal', 'Mail test', false, 'Hello world'));

/**
 * send email
 *
 * @param  String $to
 * @param  String $from_name
 * @param  String $subject
 * @param  Boolean $is_html
 * @param  String $body
 * @param  String $alt_body
 * @return Object ok (Boolean), message
 */
function send_email($to, $from_name, $subject, $is_html, $body, $alt_body = NULL) {
    if (is_null($alt_body)) $alt_body = $body;

    $mail = new PHPMailer(true);
    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->Host       = getenv('mail_server');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('mail_login');
        $mail->Password   = getenv('mail_password');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        $mail->setFrom(getenv('mail_login'), $from_name);
        $mail->addAddress($to);
    
        // Content
        $mail->isHTML($is_html);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $alt_body;
    
        $mail->send();
        return (object)(array('ok' => true));
    } catch (Exception $e) {
        return (object)(array('ok' => false, 'message' => $mail->ErrorInfo));
    }
}

?>