-- Base de datos NTRYJOB

-- Tabla ROL
CREATE TABLE IF NOT EXISTS ROL (
    ID_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(45) NOT NULL
);

-- Tabla USER
CREATE TABLE IF NOT EXISTS USER (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(45) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ROL_ID INT NOT NULL,
    FOREIGN KEY (ROL_ID) REFERENCES ROL(ID_rol)
);

-- Tabla EMPRESA
CREATE TABLE IF NOT EXISTS EMPRESA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL,
    telefono VARCHAR(20),
    pais VARCHAR(45),
    provincia VARCHAR(45),
    ciudad VARCHAR(45),
    direccion VARCHAR(80),
    logo LONGBLOB,
    USER_id INT NOT NULL,
    aprobada TINYINT DEFAULT 0,
    FOREIGN KEY (USER_id) REFERENCES USER(id)
);

-- Tabla FAMILIA
CREATE TABLE IF NOT EXISTS FAMILIA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL
);

-- Tabla CICLO
CREATE TABLE IF NOT EXISTS CICLO (
    id_ciclo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL,
    FAMILIA_id INT NOT NULL,
    nivel ENUM('Grado Medio', 'Grado Superior'),
    FOREIGN KEY (FAMILIA_id) REFERENCES FAMILIA(id)
);

-- Tabla ALUMNO
CREATE TABLE IF NOT EXISTS ALUMNO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(45) NOT NULL,
    apellido VARCHAR(45) NOT NULL,
    fechaNacimiento DATE,
    telefono VARCHAR(20),
    pais VARCHAR(45),
    provincia VARCHAR(45),
    ciudad VARCHAR(45),
    direccion VARCHAR(80),
    cv LONGBLOB,
    foto LONGBLOB,
    USER_id INT NOT NULL,
    FOREIGN KEY (USER_id) REFERENCES USER(id)
);

-- Tabla CICLO_ALUMNO
CREATE TABLE IF NOT EXISTS CICLO_ALUMNO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    CICLO_id_ciclo INT NOT NULL,
    ALUMNO_id INT NOT NULL,
    fechaInicio DATE,
    fechaFin DATE,
    FOREIGN KEY (CICLO_id_ciclo) REFERENCES CICLO(id_ciclo),
    FOREIGN KEY (ALUMNO_id) REFERENCES ALUMNO(id)
);

-- Tabla OFERTA
CREATE TABLE IF NOT EXISTS OFERTA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fechaInicio DATE NOT NULL,
    fechaFin DATE NOT NULL,
    EMPRESA_id INT NOT NULL,
    FOREIGN KEY (EMPRESA_id) REFERENCES EMPRESA(id)
);

-- Tabla OFERTA_CICLO
CREATE TABLE IF NOT EXISTS OFERTA_CICLO (
    id INT AUTO_INCREMENT PRIMARY KEY,
    OFERTA_id INT NOT NULL,
    CICLO_id_ciclo INT NOT NULL,
    required TINYINT DEFAULT 1,
    FOREIGN KEY (OFERTA_id) REFERENCES OFERTA(id),
    FOREIGN KEY (CICLO_id_ciclo) REFERENCES CICLO(id_ciclo)
);

-- Tabla SOLICITUD
CREATE TABLE IF NOT EXISTS SOLICITUD (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fechaSolicitud DATE NOT NULL,
    ALUMNO_id INT NOT NULL,
    OFERTA_id INT NOT NULL,
    estado ENUM('Pendiente', 'Aceptada', 'Rechazada') DEFAULT 'Pendiente',
    FOREIGN KEY (ALUMNO_id) REFERENCES ALUMNO(id),
    FOREIGN KEY (OFERTA_id) REFERENCES OFERTA(id)
);

-- Tabla PASS_OLVIDADA
CREATE TABLE IF NOT EXISTS PASS_OLVIDADA (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(45) NOT NULL UNIQUE,
    pass_antigua VARCHAR(45),
    USER_id INT NOT NULL,
    FOREIGN KEY (USER_id) REFERENCES USER(id)
);

-- Datos iniciales
INSERT INTO ROL (nombre_rol) VALUES ('Admin'), ('Empresa'), ('Alumno');

-- Admin: admin@ntryjob.com / admin123
INSERT INTO USER (email, password, ROL_ID) VALUES 
('admin@ntryjob.com', '$2y$10$99jc/eAl5eHilR5Zk.GjrO1lY6m0rK.01jiInu1UnNxnD8GRI5xeq', 1);

-- Familias
INSERT INTO FAMILIA (nombre) VALUES 
('Informática y Comunicaciones'),
('Administración y Gestión');

-- Ciclos
INSERT INTO CICLO (nombre, FAMILIA_id, nivel) VALUES 
('Desarrollo de Aplicaciones Web', 1, 'Grado Superior'),
('Desarrollo de Aplicaciones Multiplataforma', 1, 'Grado Superior');
