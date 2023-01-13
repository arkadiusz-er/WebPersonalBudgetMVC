<?php

namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
# require_once "vendor/PHPMailer/src/PHPMailer.php";
/*
 * Mail
 */
class Mail {
    /*
     * Send a message
     * 
     * @param string $to    Recipient
     * @param string $subject   Subject
     * @param string $text  Text-only content of the message
     * @param string $html  HTML content of the message
     * 
     * @return void
     */
    public static function send($to, $subject, $text, $html) {
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com'; # Gmail SMTP host
        $mail->Port = 465; # Gmail SMTP port
        # $mail->Port = 25;
        $mail->SMTPAuth = true; # Enable SMTP authentication / Autoryzacja SMTP
        $mail->Username = Config::MAILS_USERNAME; # Gmail username (e-mail) / Nazwa użytkownika
        $mail->Password = Config::MAILS_PASSWORD; # Gmail password / Hasło użytkownika
        # $mail->SMTPSecure = 'ssl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  

        #$mail->From = ''; # REM: Gmail put Your e-mail here
        $mail->FromName = 'Admin Personal Budget'; # Sender name
        $mail->AddAddress($to, 'Name'); # # Recipient (e-mail address + name) / Odbiorca (adres e-mail i nazwa)

        $mail->IsHTML(true); # Email @ HTML

        $mail->Subject = $subject; # 'E-mail subject / Tytuł wiadomości';
        $mail->Body = $html; # 'HTML e-mail body / Treść wiadomości w HTML';
        $mail->AltBody = $text; # 'Plaint text e-mail body / Treść wiadomości jako tekst';

        if(!$mail->Send()) {
            echo 'Some error... / Jakiś błąd...';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

        echo 'Message has been sent (OK) / Wiadomość wysłana (OK)';
    }
}