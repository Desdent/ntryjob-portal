<?php

class RepoUser {

    private $pdo;

    // Constructor
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

     // Verificar login
    public function verificarLogin($email, $password) {
        $usuario = $this->findByEmail($email);
        $resultado = false;
        
        if ($usuario && password_verify($password, $usuario['password'])) // con este metodo compara el hash que ha cogido de la base de datos del usuario con la contraseña que se le ha pasado por parametro
        {
            $resultado = $usuario;
        }
        
        return $resultado;
    }

}