<?php
session_start();

// Cargar Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar Database
require_once __DIR__ . '/../config/Database.php';

// Cargar RepoUser ← ESTO ES IMPORTANTE
require_once __DIR__ . '/../config/RepoUser.php';

// Inicializar Plates
$templates = new League\Plates\Engine(__DIR__ . '/../templates');

// Obtener parámetros de la URL
$page = $_GET['page'] ?? 'home';


if(isset($_POST["iniciar-sesion"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Obtener conexión
    $database = Database::getInstance();
    $pdo = $database->getConnection();
    
    // Crear repositorio
    $repoUser = new RepoUser($pdo);
    
    // Verificar login
    $verificado = $repoUser->verificarLogin($email, $password);
    
    if($verificado) {
        // Login correcto - guardar sesión
        // $_SESSION['user_id'] = $verificado['id'];
        // $_SESSION['user_name'] = $verificado['nombre'];
        // $_SESSION['user_rol'] = $verificado['ROL_ID'];

        // echo "exito";
        
        // Redirigir
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        // Login incorrecto - guardar error
        $_SESSION['error_login'] = "Email o contraseña incorrectos";
        header('Location: index.php?page=login');
        exit;
    }
}


// Router
switch($page) {
    case 'home':
        echo $templates->render('home');
        break;
        
    case 'login':
        echo $templates->render('auth/login');
        break;
        
    case 'register':
        echo $templates->render('auth/register');  // Página de selección
        break;
        
    case 'register-alumno':
        echo $templates->render('auth/register-alumno');  // Formulario alumno
        break;
        
    case 'register-empresa':
        echo $templates->render('auth/register-empresa');  // Formulario empresa (pendiente)
        break;
        
    default:
        echo $templates->render('home');
        break;
}
