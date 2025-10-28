<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /public/index.php?page=register-empresa&error=metodo_invalido');
    exit;
}

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../config/RepoUser.php";

// Datos de USER
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$password_confirm = $_POST["password_confirm"] ?? "";

$nombre = trim($_POST["nombre"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$pais = trim($_POST["pais"] ?? "");
$provincia = trim($_POST["provincia"] ?? "");
$ciudad = trim($_POST["ciudad"] ?? "");
$direccion = trim($_POST["direccion"] ?? "");

$errores = [];

if(empty($email)) $errores[] = "email_vacio";
if(empty($password)) $errores[] = "password_vacio";
if(empty($password_confirm)) $errores[] = "password_confirm_vacio";

if(empty($nombre)) $errores[] = "nombre_vacio";
if(empty($telefono)) $errores[] = "telefono_vacio";
if(empty($pais)) $errores[] = "pais_vacio";
if(empty($provincia)) $errores[] = "provincia_vacia";
if(empty($ciudad)) $errores[] = "ciudad_vacia";
if(empty($direccion)) $errores[] = "direccion_vacia";


if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "email_invalido";
}

if(!empty($password) && !empty($password_confirm) && $password !== $password_confirm) {
    $errores[] = "passwords_no_coinciden";
}

if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    $errores[] = "logo_obligatorio";
}

if(!empty($errores)) {
    $errorMsg = implode(",", $errores);
    header("Location: /public/index.php?page=register-empresa&error=" . $errorMsg);
    exit;
}



try {
    $pdo = Database::getInstance()->getConnection();
    $repoUser = new RepoUser($pdo);
    
    if ($repoUser->emailExists($email)) {
        header('Location: /public/index.php?page=register-empresa&error=email_existe');
        exit;
    }
    
    // Procesar logo
    $logoBlob = null;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        // validar tipo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        $tipoLogo = $_FILES['logo']['type'];
        
        if (in_array($tipoLogo, $tiposPermitidos)) {
            $logoBlob = file_get_contents($_FILES['logo']['tmp_name']);
        } else {
            header('Location: /public/index.php?page=register-empresa&error=logo_formato_invalido');
            exit;
        }
    }
    
    // Preparar para createEmpresa
    $userData = [
        'email' => $email,
        'password' => $password // Se hasheará en createUser()
    ];
    
    $empresaData = [
        'nombre' => $nombre,
        'telefono' => $telefono,
        'pais' => $pais,
        'provincia' => $provincia,
        'ciudad' => $ciudad,
        'direccion' => $direccion,
        'logo' => $logoBlob,
        'aprobada' => 0 // Por defecto no aprobada (requiere aprobación admin)
    ];
    
    // Crear empresa en la base de datos
    $userId = $repoUser->createEmpresa($userData, $empresaData);
    
    // Registro exitoso
    header('Location: /public/index.php?page=login&success=registro_empresa_exitoso');
    exit;
    
} catch (Exception $e) {
    // Error al crear empresa
    error_log("Error en registro empresa: " . $e->getMessage());
    header('Location: /public/index.php?page=register-empresa&error=registro_fallido&mensaje=' . urlencode($e->getMessage()));
    exit;
}