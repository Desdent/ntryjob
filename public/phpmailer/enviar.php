<?php
header('Content-Type: application/json');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$datos;

require __DIR__ . '/../../vendor/autoload.php';

$method = $_SERVER["REQUEST_METHOD"];

switch($method)
{
    case "POST":

                $data = json_decode(file_get_contents("php://input"), true);
                // Los datos que se envían
                $datos = [
                "nombre" => $data["nombre"] ?? "Invitado",
                "mensaje" => $data["mensaje"] ?? "Mensaje por defecto",
                "footer" => "¡Enhorabuena",
            ];

            echo json_encode([
                'success' => true,
                'message' => 'Correo enviado correctamente'
            ]);

        break;

    default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
}

// Cargar la plantilla html
$template = file_get_contents(__DIR__ . "/../assets/plantillaMail.html");

// $imagenBase64 = base64_encode(file_get_contents(__DIR__ . '/imagenes/pestel.png'));
// $imagenSrc = 'data:image/png;base64,' . $imagenBase64;




// Reemplazar los marcadores de la plantilla
foreach($datos as $clave => $valor) {
    $template = str_replace("{{" . $clave . "}}", $valor, $template);
}

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP (MailHog)
    $mail->isSMTP();
    $mail->Host = getenv('MAIL_HOST') ?: 'mailhog';
    $mail->Port = getenv('MAIL_PORT') ?: 1025;
    $mail->SMTPAuth = false;
    $mail->SMTPDebug = 2;
    
    // Remitente y destinatario
    $mail->setFrom('nomegusta@comocazalape.rra', 'ntryjob');
    $mail->addAddress($_POST['destinatario'] ?? 'test@ejemplo.com');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Correo con plantilla';
    $mail->Body    = $template;

    $mail->send();
    echo "✅ Correo enviado correctamente. Ver MailHog en <a href='http://localhost:8025'>localhost:8025</a>";
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}