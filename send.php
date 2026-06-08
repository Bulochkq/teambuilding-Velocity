<?php
ini_set('display_errors', 0);
error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meno = htmlspecialchars(trim($_POST["meno"]));
    $firma = htmlspecialchars(trim($_POST["firma"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $telefon = htmlspecialchars(trim($_POST["telefon"]));
    $pocet = htmlspecialchars(trim($_POST["pocet"]));
    $termin = htmlspecialchars(trim($_POST["termin"]));
    $poznamka = htmlspecialchars(trim($_POST["poznamka"]));

    $email = str_replace(array("\r", "\n"), '', $email);
    $firma = str_replace(array("\r", "\n"), '', $firma);

    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || isset($_POST['ajax']);

    if (empty($meno) || empty($email) || empty($telefon)) {
        if ($isAjax) {
            http_response_code(400);
            echo "error_missing_fields";
        } else {
            header("Location: index.html?status=error#kontakt");
        }
        exit;
    }

    $to = "ustymenko@velocity.sk";
    $subject = "Nová žiadosť o teambuilding - " . $firma;
    
    $message = "Dobrý deň,\n\nmáte novú žiadosť o nezáväzný návrh cyklo teambuildingu z webu teambuilding.velocity.sk:\n\n";
    $message .= "Meno: " . $meno . "\n";
    $message .= "Firma: " . $firma . "\n";
    $message .= "E-mail: " . $email . "\n";
    $message .= "Telefón: " . $telefon . "\n";
    $message .= "Počet ľudí: " . $pocet . "\n";
    $message .= "Preferovaný termín: " . $termin . "\n";
    $message .= "Poznámka / Predstava:\n" . $poznamka . "\n\n";
    
    $headers = "From: " . $to . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (@mail($to, $subject, $message, $headers)) {
        if ($isAjax) {
            echo "success";
        } else {
            header("Location: index.html?status=success#kontakt");
        }
    } else {
        if ($isAjax) {
            http_response_code(500);
            echo "error";
        } else {
            header("Location: index.html?status=error#kontakt");
        }
    }
    exit;
} else {
    header("Location: index.html");
    exit;
}
?>