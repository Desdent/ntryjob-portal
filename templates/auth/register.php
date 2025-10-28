<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Selección</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <script src="/public/js/auth/registro-alumno.js" defer></script>
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
                        <a href="#" id="btnAbrirModalAlumno" class="boton-seleccion">Registrarme como Alumno</a>
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

        <!-- Modal Registro Alumno -->
    <div id="modalRegistroAlumno" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registro de Alumno</h2>
                <span class="modal-close">&times;</span>
            </div>
            
            <form id="formRegistroAlumno" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Columna Izquierda -->
                    <div class="form-column">
                        <div class="form-group">
                            <label for="nombre">Nombre *</label>
                            <input type="text" id="nombre" name="nombre" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="pais">País *</label>
                            <input type="text" id="pais" name="pais" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono *</label>
                            <input type="tel" id="telefono" name="telefono" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="codigoPostal">Código Postal *</label>
                            <input type="text" id="codigoPostal" name="codigoPostal" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="ultimoCiclo">Último ciclo cursado *</label>
                            <input type="text" id="ultimoCiclo" name="ultimoCiclo" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="subirCV">Subir CV (PDF/DOCX) *</label>
                            <input type="file" id="subirCV" name="subirCV" accept=".pdf,.docx" required>
                            <span class="error-message"></span>
                        </div>
                    </div>

                    <!-- Columna Derecha -->
                    <div class="form-column">
                        <div class="form-group">
                            <label for="apellidos">Apellidos *</label>
                            <input type="text" id="apellidos" name="apellidos" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña *</label>
                            <input type="password" id="password" name="password" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="fechaNacimiento">Fecha de nacimiento *</label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="provincia">Provincia *</label>
                            <input type="text" id="provincia" name="provincia" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="localidad">Localidad *</label>
                            <input type="text" id="localidad" name="localidad" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección *</label>
                            <input type="text" id="direccion" name="direccion" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="fechaInicio">Fecha de inicio *</label>
                            <input type="date" id="fechaInicio" name="fechaInicio" required>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="fechaFinalizacion">Fecha de finalización</label>
                            <input type="date" id="fechaFinalizacion" name="fechaFinalizacion">
                            <span class="error-message"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" id="btnCancelarModal">Cancelar</button>
                    <button type="submit" class="btn-registrar">Registrarse</button>
                </div>
            </form>
        </div>
    </div>

    
    <footer>
        <p>&copy; 2025 NTRYJOB - Tu espacio de búsqueda tranquilo</p>
    </footer>

</body>
</html>
