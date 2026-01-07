<?php
class Database {
    public static $db    = 'fietsenmaker';
    public static $host  = 'localhost';
    public static $user  = 'root';
    public static $pass  = '';
    public static $table = 'fietsen';

    public static function pdo(): PDO {
        static $pdo = null;
        if ($pdo === null) {
            // Gebruik config constants als ze bestaan, anders fallback naar class defaults
            $host = defined('SERVERNAME') ? SERVERNAME : self::$host;
            $db   = defined('DATABASE')   ? DATABASE   : self::$db;
            $user = defined('USERNAME')   ? USERNAME   : self::$user;
            $pass = defined('PASSWORD')   ? PASSWORD   : self::$pass;

            $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return $pdo;
    }
}