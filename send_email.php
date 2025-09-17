<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Odbierz dane z formularza
    $user_name = $_POST["name"];
    $user_email = $_POST["email"];


    $raw_body = "$user_name chce się z tobą skontaktować - opisz na $user_email";


    $recipient = "wiacekjacek2@gmail.com"; // 👈 Zmień to na swój adres!

    $subject = "Wiadomość z formularza kontaktowego od: Jacka";

    // Treść e-maila
    $email_content = "$raw_body\n";

    // Nagłówki e-maila
    $email_headers = "From: jacek_135@yahoo.pl";

    echo "<script>console.log(" . json_encode($email_content) . ");</script>";

    // Wysyłka e-maila
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200); // OK
        echo "Wiadomość została wysłana pomyślnie!";
    } else {
        http_response_code(500); // Błąd serwera
        echo "Ups! Coś poszło nie tak i nie udało się wysłać Twojej wiadomości.";
    }
} else {
    http_response_code(403); // Zabronione
    echo "Dostęp zabroniony.";
}
?>