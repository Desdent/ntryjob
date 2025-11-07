<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test AlumnoDAO::getAll()</h2>";

try {
    require_once 'config/Database.php';
    require_once 'dao/AlumnoDAO.php';
    require_once 'models/entities/AlumnoEntity.php';
    
    echo "✅ Archivos requeridos cargados<br>";
    
    $dao = new AlumnoDAO();
    echo "✅ AlumnoDAO instanciado<br>";
    
    $alumnos = $dao->getAll();
    echo "✅ getAll() ejecutado correctamente<br>";
    echo "✅ Número de alumnos: " . count($alumnos) . "<br>";
    
    foreach ($alumnos as $alumno) {
        echo "Alumno: " . $alumno->nombre . " " . $alumno->apellidos . " (" . $alumno->email . ")<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "<pre>Trace: " . $e->getTraceAsString() . "</pre>";
}
?>