<?php

class AuthMiddleware
{
    public static function checkSession()
    {
        //si no hay sesion la crea
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //si no hay un user guardado en sesion redirige
        if (!isset($_SESSION['user_id'])) {
            header('Location: /public/index.php?page=login&error=sesion_requerida');
            exit;
        }

        return true;
    }

    public static function checkRole($rolesPermitidos)
    {
        self::checkSession();//Se chequea a si mismo si hay sesion activa

        if (!is_array($rolesPermitidos)) { // para cuando haya que pasarle mas de un rol permitido en la web o solo uno que tambien sirva
            $rolesPermitidos = [$rolesPermitidos];
        }

        if (!in_array($_SESSION['rol'], $rolesPermitidos)) {
            header('Location: /public/index.php?page=login&error=acceso_denegado');
            exit;
        }

        return true;
    }

    public static function getUserId()
    {
        self::checkSession();
        return $_SESSION['user_id'];
    }

    public static function getRol()
    {
        self::checkSession();
        return $_SESSION['rol'];
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();
        header('Location: /public/index.php?page=login');
        exit;
    }
}
