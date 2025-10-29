<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Solo aceptar post
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'metodo_invalido']);
    exit;
}


require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../config/RepoUSer.php";

// Vienen de user
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Vienen de usuario
$nombre = trim($_POST["nombre"] ?? "");
$apellidos = trim($_POST["apellidos"] ?? "");
$fechaNacimiento = trim($_POST["fechaNacimiento"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$pais = trim($_POST["pais"] ?? "");
$provincia = trim($_POST["provincia"] ?? "");
$ciudad = trim($_POST["localidad"] ?? "");
$direccion = trim($_POST["direccion"] ?? "");
$fotoBase64 = $_POST['fotoAlumnoBase64'] ?? null;
$fotoBlob =  null;


//para los errores
$errores = []; // para meterlos en el array los errores y luego repasarlos

if ($fotoBase64 && strpos($fotoBase64, 'base64,') !== false) {
    $fotoBlob = base64_decode(explode('base64,', $fotoBase64)[1]);
}

if(empty($email))
{
    $errores[] = "email_vacio";
}
if(empty($password))
{
    $errores[] = "password_vacio";
}
if(empty($nombre))
{
    $errores[] = "nombre_vacio";
}
if(empty($apellidos))
{
    $errores[] = "apellidos_vacio";
}

// No sabia que esto tan comodo existía para validar, gracias ia <3
if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) // esto se encarga de validar lo que le pases en el primer parametro bajo el estandar del segundo.
{
    $errores[] = "email_invalido";
}

// Si hay errores que vuelva al form
if(!empty($errores))
{
    echo json_encode(['success' => false, 'errors' => $errores]);  // ✅
    exit;
}


//hacer el registro
try{

    //pillar la conexion
    $pdo = Database::getInstance()->getConnection();
    $repoUser = new RepoUSer($pdo); // Hay que pasarle la conexion si no cagamos

    if($repoUser->emailExists($email))
    {
        echo json_encode(['success' => false, 'error' => 'email_existe']);  // ✅
        exit;
    }

    //Parte del cv
    $cvBlob = null;

    if(isset($_FILES["subirCV"]) && $_FILES["subirCV"]["error"] === UPLOAD_ERR_OK) // esto le envia a $files["taltal"]["error"] un 0, pa que sepa que todo bien
    {
        $tiposPermitidos = ["application/pdf", "application/docx"];
        $tipoCV = $_FILES["subirCV"]["type"];

        // Comprueba si lo que le pases esta en el array que le pases
        if(in_array($tipoCV, $tiposPermitidos)) // para chequear si el tipo del cv coincide con los permitidos
        {
            $cvBlob = file_get_contents($_FILES["subirCV"]["tmp_name"]);
            
        }
        else
        {
            echo json_encode(['success' => false, 'error' => 'cv_formato_invalido']);  // ✅
            exit;
        }
    }

    $userData = [
                    "email" => $email,
                    "password" => $password
    ];

    $alumnoData = [
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "fechaNacimiento" => $fechaNacimiento,
                    "telefono" => $telefono,
                    "pais" => $pais,
                    "provincia" => $provincia,
                    "ciudad" => $ciudad,
                    "direccion" => $direccion,
                    "cv" => $cvBlob,
                    "foto" => $fotoBlob,
    ];


    // mete el alumno en la base
    $userID = $repoUser->createAlumno($userData, $alumnoData);

    // Registro exitoso
        echo json_encode([
            'success' => true,
            'message' => 'Registro exitoso',
            'user_id' => $userID
        ]);
        exit;
        
    } catch (Exception $e) {
        // Error al crear alumno
        error_log("Error en registro alumno: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'registro_fallido',
            'message' => $e->getMessage()
        ]);
        exit;
    }

