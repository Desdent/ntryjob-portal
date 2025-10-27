<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <div class="divMarcoRegistro">
            <div class="divContentRegistro">
                <div id="divFormRegistro">
                    <h3 class="fontDivContent">
                        Crea tu cuenta
                    </h3>
                    <form action="index.php?page=register" method="post" id="form-registro">
                        <div class="columnas-registro">
                            <div class="columna-izq">
                                <span class="campos-registro">
                                    <label for="nombre" class="fontDivContent">Nombre: </label><br>
                                    <input type="text" name="nombre" id="nombre" required><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="email" class="fontDivContent">Email: </label><br>
                                    <input type="email" name="email" id="emailRegistro" required><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="pais" class="fontDivContent">País: </label><br>
                                    <input type="text" name="pais" id="pais"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="telefono" class="fontDivContent">Teléfono: </label><br>
                                    <input type="tel" name="telefono" id="telefono"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="codigoPostal" class="fontDivContent">Código Postal: </label><br>
                                    <input type="text" name="codigoPostal" id="codigoPostal" class="input-pequeno"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="ultimoCiclo" class="fontDivContent">Último ciclo cursado: </label><br>
                                    <input type="text" name="ultimoCiclo" id="ultimoCiclo"><br>
                                    <small class="fontDivContent nota-pequena">* Podrás añadir más estudios al completar el registro</small>
                                </span>

                                <span class="campos-registro">
                                    <label for="subirCV" class="fontDivContent">Subir CV: </label><br>
                                    <input type="file" name="subirCV" id="subirCV" accept=".pdf,.doc,.docx"><br>
                                </span>
                            </div>

                            <div class="columna-der">
                                <span class="campos-registro">
                                    <label for="apellidos" class="fontDivContent">Apellidos: </label><br>
                                    <input type="text" name="apellidos" id="apellidos" required><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="contrasena" class="fontDivContent">Contraseña: </label><br>
                                    <input type="password" name="contrasena" id="contrasenaRegistro" required><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="provincia" class="fontDivContent">Provincia: </label><br>
                                    <input type="text" name="provincia" id="provincia"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="localidad" class="fontDivContent">Localidad: </label><br>
                                    <input type="text" name="localidad" id="localidad"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="direccion" class="fontDivContent">Dirección: </label><br>
                                    <input type="text" name="direccion" id="direccion" class="input-largo"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="fechaInicio" class="fontDivContent">Fecha de inicio: </label><br>
                                    <input type="date" name="fechaInicio" id="fechaInicio"><br>
                                </span>

                                <span class="campos-registro">
                                    <label for="fechaFinalizacion" class="fontDivContent">Fecha de finalización: </label><br>
                                    <input type="date" name="fechaFinalizacion" id="fechaFinalizacion"><br>
                                </span>
                            </div>
                        </div>

                        <span class="campos-registro centro">
                            <button type="submit" name="registrarse" id="botonRegistrarseForm">Registrarse</button>
                        </span>
                    </form>

                    <span class="campos-registro centro">
                        <p class="fontDivContent">¿Ya tienes cuenta? <a href="index.php?page=login" id="link-login">Inicia sesión aquí</a></p>
                    </span>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 NTRYJOB - Tu espacio de búsqueda tranquilo</p>
    </footer>

</body>
</html>
