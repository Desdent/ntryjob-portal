<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/RepoUser.php';


$email = $_GET["email"] ?? "";



if(empty($email)) {
    echo json_encode(['error' => 'Email no proporcionado']);
    exit;
}

try {

    //Obtener conexión a BD
    $pdo = Database::getInstance()->getConnection();
    
    //Crear instancia de RepoUser pasándole la conexión
    $repoUser = new RepoUser($pdo);

    $existe = $repoUser->emailExists($email);

    // Devolver respuesta JSON
    echo json_encode(['existe' => $existe]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}