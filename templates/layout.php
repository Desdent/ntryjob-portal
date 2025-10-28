<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->e($title)?> - NTRYJOB</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-logo">
                    <a href="index.php">
                        <img src="/assets/imagenes/ntryjob-removebg-preview.png" alt="NTRYJOB">
                    </a>
                </div>
                <ul class="navbar-menu">
                    <li><a href="index.php?page=home">Inicio</a></li>
                    <li><a href="index.php?page=empleos">Buscar Empleo</a></li>
                    <li><a href="index.php?page=empresas">Buscar Empresas</a></li>
                    <li><a href="index.php?page=login">Acceso Empresas</a></li>
                </ul>
                <div class="navbar-actions">
                    <a href="index.php?page=login" class="btn-primary">Acceso Usuarios</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main>
        <?=$this->section('content')?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 ntryjob. Tu espacio de búsqueda tranquila.</p>
        <p>Aviso Legal | Política de Privacidad</p>
        <div class="footer-social">
            <a href="#">IG</a>
            <a href="#">LI</a>
            <a href="#">TW</a>
        </div>
    </footer>
</body>
</html>
