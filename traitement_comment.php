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
    $sql = "INSERT INTO commentaire (nom,email,date,commentaire,) 
    VALUES (:nom, :email, NOW(), :commentaire, :valid)";

    $params = [
        'nom' => $nom,
        'email' => $email,
        'commentaire' => $commentaire,
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    

    //preparation de l'email à envoyer
    $body = "
    <p>Bonjour $nom, merci d'avoir déposé un commentaire sur <a href=\"https://beaute-laurent.fr\">beaute-laurent.fr</a></p>
    <p> Vous avez déposé ce commentaire :</p>
    <i>\" $commentaire \" </i>";
    
    sendMail($email, $body);
    
    //enregistre l'envoi de mail dans les logs
    $date = date("Y-m-d H:i:s");
    $log = "Envoi d'email pour dépôt de commentaire le $date - Envoyé à $nom à l'adresse $email - Commentaire : $commentaire \n";
    file_put_contents("logEmail.txt", mb_convert_encoding($log, "utf-8"), FILE_APPEND);
}

