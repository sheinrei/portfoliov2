<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';


function sendMail($sender, $body)
{
    $config = require '/../config.php';
    $mail = new PHPMailer(true);
    $mail_password = $config['mailPassword'];
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username = "beaute.laurent.dev@gmail.com";
        $mail->Password = $mail_password;
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->CharSet = "UTF-8";

        //Recipients

        $mail->setFrom('beaute.laurent.dev@gmail.com');
        $mail->addAddress($sender);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Message de Portfolio';
        $mail->Body    = $body;
        $mail->send();


    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo} Error : {$e}";
    }
}


