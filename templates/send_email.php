<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './libs/PHPMailer/src/Exception.php';
require './libs/PHPMailer/src/PHPMailer.php';
require './libs/PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
function envoie_mail($from_name,$from_email,$subject,$message){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = 'ssl';
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;     
    $mail->Username   = 'martialhuret@gmail.com'; //SMTP username
    $mail->Password   = 'dcpmastnzqxtwxyg'; //trouver grâce à https://myaccount.google.com/apppasswords  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    $mail->Port       = 465;
    $mail->setFrom($from_email, $from_name);
    $mail->addAddress('martialhuret@gmail.com','testpinf');
    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');
    if (!$mail->Send()) {
        return false;
    }
    else {
        return true;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $message = trim(htmlspecialchars($_POST['message']));
    
    // Sujet de l'e-mail
    $subject = "Nouveau message de $name";

    // Corps de l'e-mail
    $body = "Vous avez reçu un nouveau message de $name ($email):\n\n" . htmlentities($message);

    // En-têtes de l'e-mail
    $headers = "From: $email";

    if (envoie_mail($name,$email,$subject,$body)) {
        // Rediriger l'utilisateur vers la page d'accueil avec un message de succès
        header('Location: index.php?view=contact&success=true');
        exit(); // Terminer le script après la redirection
    }
    else {
        // Rediriger l'utilisateur vers la page d'accueil avec un message d'erreur
        header('Location: index.php?view=contact&success=false');
        exit(); // Terminer le script après la redirection
    }
}
?>
