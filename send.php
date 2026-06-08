<?php
ini_set('display_errors', 0);
error_reporting(0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meno = mb_substr(htmlspecialchars(trim($_POST["meno"])), 0, 100);
    $firma = mb_substr(htmlspecialchars(trim($_POST["firma"])), 0, 100);
    $email = mb_substr(htmlspecialchars(trim($_POST["email"])), 0, 100);
    $telefon = mb_substr(htmlspecialchars(trim($_POST["telefon"])), 0, 30);
    $pocet = mb_substr(htmlspecialchars(trim($_POST["pocet"])), 0, 50);
    $termin = mb_substr(htmlspecialchars(trim($_POST["termin"])), 0, 50);
    $poznamka = mb_substr(htmlspecialchars(trim($_POST["poznamka"])), 0, 2000);

    $email = str_replace(array("\r", "\n"), '', $email);
    $firma = str_replace(array("\r", "\n"), '', $firma);

    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || isset($_POST['ajax']);

    $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
    $isPhoneValid = preg_match('/^[\s()+-]*([0-9][\s()+-]*){7,20}$/', $telefon);

    if (empty($meno) || empty($email) || empty($telefon) || !$isEmailValid || !$isPhoneValid) {
        if ($isAjax) {
            http_response_code(400);
            echo "error_invalid_input";
        } else {
            header("Location: index.html?status=error#kontakt");
        }
        exit;
    }

    $to = "ustymenko@velocity.sk";
    $subject = "Nová žiadosť o teambuilding - " . $firma;
    
    $message = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nová žiadosť o teambuilding</title>
    <style>
        body { font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; background-color: #F8F9FA; color: #111111; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #E9ECEF; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .header { background-color: #111111; padding: 30px; text-align: center; border-bottom: 3px solid #8E8E8E; }
        .header h2 { color: #ffffff; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .content { padding: 40px 30px; }
        .intro { font-size: 16px; line-height: 1.6; color: #555555; margin-top: 0; margin-bottom: 30px; }
        .table-wrapper { border: 1px solid #E9ECEF; border-radius: 12px; overflow: hidden; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td { padding: 14px 18px; font-size: 14px; line-height: 1.5; border-bottom: 1px solid #E9ECEF; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; }
        tr:last-child td { border-bottom: none; }
        td.label { font-weight: bold; color: #8E8E8E; width: 150px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        td.value { color: #111111; font-weight: 500; }
        .note-box { background-color: #F8F9FA; border-left: 4px solid #111111; padding: 15px 20px; border-radius: 0 8px 8px 0; margin-top: 5px; font-style: italic; color: #333333; line-height: 1.6; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; }
        .footer { background-color: #F8F9FA; padding: 20px; text-align: center; font-size: 11px; color: #8E8E8E; border-top: 1px solid #E9ECEF; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nová žiadosť o teambuilding</h2>
        </div>
        <div class="content">
            <p class="intro">Dobrý deň,<br>z webu <strong>teambuilding.velocity.sk</strong> bol odoslaný nový nezáväzný dopyt:</p>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <td class="label">Meno</td>
                        <td class="value">' . $meno . '</td>
                    </tr>
                    <tr>
                        <td class="label">Firma</td>
                        <td class="value">' . $firma . '</td>
                    </tr>
                    <tr>
                        <td class="label">E-mail</td>
                        <td class="value"><a href="mailto:' . $email . '" style="color: #111111; text-decoration: underline;">' . $email . '</a></td>
                    </tr>
                    <tr>
                        <td class="label">Telefón</td>
                        <td class="value"><a href="tel:' . $telefon . '" style="color: #111111; text-decoration: none;">' . $telefon . '</a></td>
                    </tr>
                    <tr>
                        <td class="label">Počet ľudí</td>
                        <td class="value">' . $pocet . '</td>
                    </tr>
                    <tr>
                        <td class="label">Termín</td>
                        <td class="value">' . $termin . '</td>
                    </tr>
                </table>
            </div>

            <div class="note-section" style="margin-top: 25px;">
                <div class="note-title" style="font-weight: bold; color: #8E8E8E; font-size: 11px; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px;">Poznámka / Predstava:</div>
                <div class="note-box">' . nl2br($poznamka) . '</div>
            </div>
        </div>
        <div class="footer">
            &copy; 2026 VELOCITY TEAMBUILDING
        </div>
    </div>
</body>
</html>';
    
    $headers = "From: " . $to . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

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