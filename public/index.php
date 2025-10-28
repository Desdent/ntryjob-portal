<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/RepoUser.php';

use League\Plates\Engine;

// Configurar Plates
$templates = new Engine(__DIR__ . '/../templates');

// Obtener página solicitada
$page = $_GET['page'] ?? 'home';

// Si es POST (envío de formulario login)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Conectar BD
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Crear repositorio
    $repoUser = new RepoUser($pdo);
    
    // Verificar login
    $verificado = $repoUser->verificarLogin($email, $password);
    
    if($verificado) {
        // Login correcto
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        // Login incorrecto
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
        echo $templates->render('auth/register'); // Página de selección
        break;
    
    case 'register-alumno':
        echo $templates->render('auth/register-alumno'); // Formulario alumno
        break;
    
    case 'register-empresa': 
        echo $templates->render('auth/register-empresa'); // Formulario empresa
        break;
    
    case 'dashboard':
        echo "Dashboard (pendiente de crear)";
        break;
    
    default:
        echo $templates->render('home');
        break;
}
?>
