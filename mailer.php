
text/x-generic mailer.php ( PHP script, UTF-8 Unicode text, with CRLF line terminators )
<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';


function sendMail($sender, $body)
{
    $config = require __DIR__ . '/../config.php';
    $mail = new PHPMailer(true);  // Exceptions activées

    $mail_password = $config['mailPassword'];

    //Server settings
    $mail->SMTPDebug = 0;                      
    $mail->isSMTP();                                            
    $mail->SMTPAuth   = true;                                   
    $mail->Username = "beaute.laurent.dev@gmail.com";
    $mail->Password = $mail_password;
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
    $mail->Port       = 587;                                    

    $mail->CharSet = "UTF-8";

    //Recipients
    $mail->setFrom('beaute.laurent.dev@gmail.com');
    $mail->addAddress($sender);     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Message de Portfolio';
    $mail->Body    = $body;

    $mail->send();  // si ça plante, exception remonte
}


