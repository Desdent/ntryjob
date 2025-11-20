<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Obtener y validar el ID de la postulación
$postulacionId = $_GET['postulacion_id'] ?? null;
if (!$postulacionId || !is_numeric($postulacionId)) {
    http_response_code(400);
    die("ID de postulación no válido o faltante.");
}

// Configurar Dompdf (opcional pero recomendado)
$options = new Options();
// Configuración para permitir imágenes y CSS remoto si fuera necesario más adelante
$options->set('isRemoteEnabled', true);
// Usar un font que soporte caracteres especiales/tildes
$options->set('defaultFont', 'sans-serif'); 

$dompdf = new Dompdf($options);

// Generar el contenido 
$html = '
<html>
<head>
    <style>
        /* CSS básico para el PDF */
        body { font-family: sans-serif; margin: 50px; }
        h1 { color: #2563eb; border-bottom: 2px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Ficha</h1>
    <p>Este es el contenido de la Ficha para la postulación ID: ' . htmlspecialchars($postulacionId) . '</p>
    
    </body>
</html>';

$dompdf->loadHtml($html);

// el tamaño y orientación del papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar el HTML a PDF
$dompdf->render();

// Enviar el PDF al navegador (Stream)
$nombreArchivo = "Ficha_Postulacion_{$postulacionId}.pdf";

// El primer parámetro es el nombre del archivo, el segundo es si se fuerza la descarga (Attachment => true) 
// o se muestra en el navegador (Attachment => false).
$dompdf->stream($nombreArchivo, ["Attachment" => false]); 

exit;
?>