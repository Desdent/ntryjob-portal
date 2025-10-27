<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Selección</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <nav>
            <h1>NTRYJOB</h1>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.php?page=login">Login</a></li>
                <li><a href="index.php?page=register">Registro</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="divMarco">
            <div class="divContentSeleccion">
                <h2 class="fontDivContent titulo-seleccion">¿Qué tipo de cuenta quieres crear?</h2>
                
                <div class="opciones-registro">
                    <div class="opcion-card">
                        <h3 class="fontDivContent">Soy Alumno</h3>
                        <p class="fontDivContent">Busco oportunidades laborales y prácticas</p>
                        <a href="index.php?page=register-alumno" class="boton-seleccion">Registrarme como Alumno</a>
                    </div>

                    <div class="opcion-card">
                        <h3 class="fontDivContent">Soy Empresa</h3>
                        <p class="fontDivContent">Quiero publicar ofertas de empleo</p>
                        <a href="index.php?page=register-empresa" class="boton-seleccion">Registrarme como Empresa</a>
                    </div>
                </div>

                <span class="campos-registro centro">
                    <p class="fontDivContent">¿Ya tienes cuenta? <a href="index.php?page=login" id="link-login-sel">Inicia sesión aquí</a></p>
                </span>
            </div>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 NTRYJOB - Tu espacio de búsqueda tranquilo</p>
    </footer>

</body>
</html>
