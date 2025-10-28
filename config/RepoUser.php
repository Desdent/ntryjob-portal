<?php

class RepoUser {

    private $pdo;

    /*
    *   Constructor
    */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function findByEmail($email)
    {
         $sql = "SELECT * FROM USER WHERE email = :email";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        
        return $stmt->fetch(); // Devuelve el usuario o false si no existe
    }

     /**
     *  Verificar login
     */
    public function verificarLogin($email, $password) {
        $usuario = $this->findByEmail($email);
        $resultado = false;
        
        if ($usuario && password_verify($password, $usuario['password'])) // con este metodo compara el hash que ha cogido de la base de datos del usuario con la contraseña que se le ha pasado por parametro
        {
            $resultado = $usuario;
        }
        
        return $resultado;
    }


    /**
     * Verificar si un email ya existe en la BD
     */
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM USER WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crear usuario en la tabla USER
     */
    public function createUser($email, $password, $rolId) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Para pasar a hash la contraseña
        
        $sql = "INSERT INTO USER (email, password, ROL_ID) VALUES (:email, :password, :rol)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $hashedPassword);
        $stmt->bindValue(":rol", $rolId);
        $stmt->execute();
        
        return $this->pdo->lastInsertId();
    }

    /**
     * Crear alumno completo (USER + ALUMNO)
     */
    public function createAlumno($userData, $alumnoData) {
        try {
            $this->pdo->beginTransaction();
            

            $userId = $this->createUser($userData['email'], $userData['password'], 3); 
            
        
            $sql = "INSERT INTO ALUMNO (nombre, apellido, fechaNacimiento, telefono, pais, provincia, ciudad, direccion, cv, foto, USER_id)
                    VALUES (:nombre, :apellido, :fechaNacimiento, :telefono, :pais, :provincia, :ciudad, :direccion, :cv, :foto, :userId)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":nombre", $alumnoData['nombre']);
            $stmt->bindValue(":apellido", $alumnoData['apellidos']);
            $stmt->bindValue(":fechaNacimiento", $alumnoData['fechaNacimiento']);
            $stmt->bindValue(":telefono", $alumnoData['telefono'] ?? null);
            $stmt->bindValue(":pais", $alumnoData['pais'] ?? null);
            $stmt->bindValue(":provincia", $alumnoData['provincia'] ?? null);
            $stmt->bindValue(":ciudad", $alumnoData['ciudad'] ?? null);
            $stmt->bindValue(":direccion", $alumnoData['direccion'] ?? null);
            $stmt->bindValue(":cv", $alumnoData['cv'] ?? null);
            $stmt->bindValue(":foto", $alumnoData['foto'] ?? null);
            $stmt->bindValue(":userId", $userId);
            $stmt->execute();
            
            $this->pdo->commit();
            return $userId;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

}