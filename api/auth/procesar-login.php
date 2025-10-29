<?php

session_start();

ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'metodo_invalido']);
    exit;
}

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../config/RepoUser.php";

// Datos de user
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$errores = [];

// validaciones
if (empty($email)) $errores[] = "email_vacio";
if (empty($password)) $errores[] = "password_vacio";

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "email_invalido";
}

// si hay errores envia al navegador un mensaje con success: false y los errores que se han metido
if (!empty($errores)) {
    echo json_encode(['success' => false, 'errors' => $errores]);
    exit;
}

try {
    $pdo = Database::getInstance()->getConnection();
    $repoUser = new RepoUser($pdo);
    
    $usuario = $repoUser->loginValido($email, $password);
    
    // si hay usuario se crea el token y se guardan en sesion sus datos
    if ($usuario) {
        $token = hash('sha256', $usuario['email'] . $usuario['password'] . time()); // ia
        

        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['rol'] = $usuario['ROL_ID'];
        $_SESSION['token'] = $token;
        
        echo json_encode([
            'success' => true,
            'user_id' => $usuario['id'],
            'email' => $usuario['email'],
            'rol' => $usuario['ROL_ID'],
            'token' => $token
        ]);
        exit;
        
    } else {
        echo json_encode([
            'success' => false, 
            'error' => 'credenciales_incorrectas'
        ]);
        exit;
    }
    
} catch (Exception $e) {
    error_log("Error en login: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'error_servidor',
        'message' => $e->getMessage()
    ]);
    exit;
}
