
text/x-generic traitement_comment.php ( PHP script, UTF-8 Unicode text, with CRLF line terminators )
<?php

$config = require __DIR__ . '/../config.php';

require ("mailer.php");

$nom = $_POST["nom"];
$email = $_POST["email"];
$commentaire = $_POST["commentaire"];


$dsn = $config["dsn"];
$user = $config['user'];
$pass = $config["password"];
$pdo = new \PDO($dsn, $user, $pass);

addComment($nom, $email, $commentaire, $pdo);


// Ajouter un commentaire dans db
function addComment($nom, $email, $commentaire,  $pdo)
{
    file_put_contents("logPhp.txt",  "Début de l'enregistrement dans la BDD \n", FILE_APPEND);
    $sql = "INSERT INTO commentaire (nom,email,date,commentaire) 
    VALUES (:nom, :email, NOW(), :commentaire)";

    $params = [
        'nom' => $nom,
        'email' => $email,
        'commentaire' => $commentaire,
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    

    //preparation de l'email à envoyer
    $body = "
        <table width='100%' cellpadding='0' cellspacing='0' style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;'>
            <tr>
                <td>
                    <table width='600' cellpadding='0' cellspacing='0' align='center' style='background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                        <tr>
                            <td style='text-align: center; padding-bottom: 20px;'>
                                <h2 style='color: #333;'>Merci pour votre commentaire !</h2>
                            </td>
                        </tr>
                        <tr>
                            <td style='font-size: 16px; color: #555; line-height: 1.5;'>
                                <p>Bonjour <strong>$nom</strong>,</p>
                                <p>Merci d'avoir pris le temps de partager votre avis sur 
                                <a href='https://beaute-laurent.fr' style='color: #1a73e8; text-decoration: none;'>beaute-laurent.fr</a>.</p>
                                <p>J'ai bien reçu votre commentaire et je le prends en considération :</p>
                                <blockquote style='border-radius:10px;background-color: #f0f0f0; padding: 10px 15px; border-left: 4px solid #1a73e8; font-style: italic; color: #333;'>$commentaire</blockquote>
                                <p>Votre retour m'aide à améliorer mes services et à offrir une expérience toujours plus agréable pour tous les utilisateurs.</p>
                                <p style='margin-top: 30px; font-size: 14px; color: #999;'>Cordialement,<br>Beaute Laurent</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        ";
    
    $bodyToMe = "
        <table width='100%' cellpadding='0' cellspacing='0' style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;'>
            <tr>
                <td>
                    <table width='600' cellpadding='0' cellspacing='0' align='center' style='background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                        <tr>
                            <td style='text-align: center; padding-bottom: 20px;'>
                                <h2 style='color: #333;'>Nouveau commentaire reçu !</h2>
                            </td>
                        </tr>
                        <tr>
                            <td style='font-size: 16px; color: #555; line-height: 1.5;'>
                                <p>Bonjour Mon seigneur,</p>
                                <p>Tu as reçu un nouveau commentaire sur le portfolio de la part de <strong>$nom</strong> :</p>
                                <blockquote style='background-color: #f0f0f0; padding: 10px 15px; border-left: 4px solid #1a73e8; font-style: italic; color: #333;'>$commentaire</blockquote>
                                <p>Pour le consulter dans PhpMyAdmin, clique <a href='https://pendule.o2switch.net:2083/cpsess1488985906/3rdparty/phpMyAdmin/index.php?route=/sql&pos=0&db=buyu3307_portfolio&table=commentaire' style='color: #1a73e8; text-decoration: none;'>ici</a>.</p>
                                <p style='margin-top: 30px; font-size: 14px; color: #999;'>Cordialement,<br>Portfolio</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        ";
    
    try {
        sendMail($email, $body);
        file_put_contents("logEmailSend.txt", date("Y-m-d H:i:s") . " - Mail Envoyé à : " . $email . "\n" . "Le commentaire : `\n" . $commentaire , FILE_APPEND);
        sendMail("l.beaute@laposte.net", $bodyToMe);
    } catch (Exception $e) {
        file_put_contents("logError.txt", date("Y-m-d H:i:s") . " - Mail Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
}


