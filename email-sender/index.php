<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAIL_USER'];                     //SMTP username
    $mail->Password   = $_ENV['MAIL_PASS'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['MAIL_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV['MAIL_USER'], 'Formularz Kontaktowy');
    $mail->addAddress($_ENV['MAIL_USER'], 'Kontakt');     //Add a recipient
    $mail->addReplyTo($_ENV['MAIL_USER'], 'no-reply');

    //Attachments
    $mail->addAttachment(path: 'assets/header.png', name:"zrzut_ekranu.png");         //Add attachments
    //Embedded Images
    $mail->addEmbeddedImage(path: 'assets/article_header.png', cid: "naglowek.png");         //Add attachments

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'mail from client';

    $htmlContent = file_get_contents('email.html');

    $mail->Body    = $htmlContent;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}