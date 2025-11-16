<?php
// Cargar el autoload de Composer
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// --- 1. Credenciales de la Base de Datos (del docker-compose.yml) ---
// **¡Asegúrate que estos valores coincidan exactamente con tu docker-compose.yml!**
const DB_HOST = 'db';
const DB_NAME = 'ntryjob';
const DB_USER = 'admin';
const DB_PASS = 'admin123';

$datos_alumnos = [];

try {
    // --- 2. Conexión usando PDO ---
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- 3. Consulta de Datos JOIN ---
    // Seleccionamos todos los campos solicitados de ambas tablas, 
    // uniendo por el campo 'ciclo_id' que es la clave foránea.
    $sql = "
        SELECT 
            A.nombre AS alumno_nombre, 
            A.apellidos, 
            A.telefono, 
            A.fecha_nacimiento, 
            A.pais, 
            A.provincia, 
            A.ciudad, 
            A.direccion, 
            A.codigo_postal,
            A.fecha_inicio AS alumno_fecha_inicio,
            A.fecha_fin AS alumno_fecha_fin,
            C.nombre_ciclo,
            C.fecha_inicio AS ciclo_fecha_inicio, 
            C.fecha_fin AS ciclo_fecha_fin
        FROM 
            alumnos A
        INNER JOIN 
            alumno_ciclos C ON A.ciclo_id = C.ciclo_id
        ORDER BY 
            A.apellidos, A.nombre
    ";
    
    $stmt = $pdo->query($sql);
    $datos_alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("<h1>ERROR de Conexión o Consulta</h1><p>Verifica tu base de datos y la sintaxis SQL: " . $e->getMessage() . "</p>");
}

// Verifica si se encontraron datos
if (empty($datos_alumnos)) {
    die("<h1>Aviso</h1><p>No se encontraron alumnos para generar el PDF. Verifica tus tablas.</p>");
}


// --- 4. Generación del Contenido HTML ---
// Se crea una lista detallada de alumnos, no una tabla simple.

$html = '
<html>
<head>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1 { color: #2C3E50; border-bottom: 2px solid #3498DB; padding-bottom: 5px; }
        .alumno { 
            border: 1px solid #BDC3C7; 
            margin-bottom: 15px; 
            padding: 15px; 
            border-radius: 5px;
        }
        .alumno h2 { 
            color: #3498DB; 
            margin-top: 0; 
            font-size: 1.2em;
        }
        .info-grupo { margin-bottom: 10px; }
        .info-grupo strong { display: inline-block; width: 150px; }
    </style>
</head>
<body>
    <h1>Reporte Detallado de Alumnos y Ciclos</h1>
    ';

foreach ($datos_alumnos as $alumno) {
    $html .= '
    <div class="alumno">
        <h2>' . htmlspecialchars($alumno['apellidos']) . ', ' . htmlspecialchars($alumno['alumno_nombre']) . '</h2>
        
        <h3>Datos Personales</h3>
        <div class="info-grupo"><strong>Teléfono:</strong> ' . htmlspecialchars($alumno['telefono']) . '</div>
        <div class="info-grupo"><strong>Fecha Nacimiento:</strong> ' . htmlspecialchars($alumno['fecha_nacimiento']) . '</div>
        <div class="info-grupo"><strong>Dirección:</strong> ' . htmlspecialchars($alumno['direccion']) . ', ' . htmlspecialchars($alumno['codigo_postal']) . '</div>
        <div class="info-grupo"><strong>Ubicación:</strong> ' . htmlspecialchars($alumno['ciudad']) . ' (' . htmlspecialchars($alumno['provincia']) . '), ' . htmlspecialchars($alumno['pais']) . '</div>

        <h3>Información del Ciclo</h3>
        <div class="info-grupo"><strong>Ciclo:</strong> <b>' . htmlspecialchars($alumno['nombre_ciclo']) . '</b></div>
        <div class="info-grupo"><strong>Inicio Alumno:</strong> ' . htmlspecialchars($alumno['alumno_fecha_inicio']) . '</div>
        <div class="info-grupo"><strong>Fin Alumno:</strong> ' . htmlspecialchars($alumno['alumno_fecha_fin']) . '</div>
        <div class="info-grupo"><strong>Inicio Ciclo:</strong> ' . htmlspecialchars($alumno['ciclo_fecha_inicio']) . '</div>
        <div class="info-grupo"><strong>Fin Ciclo:</strong> ' . htmlspecialchars($alumno['ciclo_fecha_fin']) . '</div>
    </div>
    ';
}

$html .= '
</body>
</html>';


// --- 5. Configuración y Creación del PDF con dompdf ---

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); 

$dompdf = new Dompdf($options);

// Carga el HTML en dompdf
$dompdf->loadHtml($html);

// Configura el tamaño y orientación del papel
$dompdf->setPaper('A4', 'portrait');

// Renderiza (genera) el PDF
$dompdf->render();

// --- 6. Envío del PDF al Navegador ---
$dompdf->stream('reporte_alumnos_ciclos.pdf', ['Attachment' => 0]); 
exit(0);