<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PhpMailSender
{
    const SMTP_DEBUG_LEVEL = 0;
    const HOST = ROSETTA_EMAIL_SMTP;
    const USERNAME = ROSETTA_EMAIL;
    const PASSWORD = ROSETTA_EMAIL_PASSWORD;
    const SMTP_SECURE = 'tls';
    const PORT = 465;

    public static function send($to, $subject, $message)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = self::SMTP_DEBUG_LEVEL;                                 // Enable verbose debug output
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = self::HOST; //'smtp.yandex.ru';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = self::USERNAME;                 // SMTP username
            $mail->Password = self::PASSWORD;                           // SMTP password
            $mail->SMTPSecure = self::SMTP_SECURE;                            // Enable TLS encryption, `ssl` also accepted
            // $mail->Port = 587;                                    // TCP port to connect to
            $mail->Port = self::PORT;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom(ROSETTA_EMAIL, 'Служба уведомлений');
            $mail->addAddress($to);     // Add a recipient
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        exit;
    }
}