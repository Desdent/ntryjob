<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

$email = $_GET['email'] ?? '';

if (empty($email)) {
    echo json_encode(['existe' => false]);
    exit;
}

try {
    $existe = User::emailExists($email);
    echo json_encode(['existe' => $existe]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}