<?php
require_once __DIR__ . '/../config.php'; 

class Database {
    private static $pdo = null;

    public static function getConnection() {
        global $mysqlClient;
        if (self::$pdo === null) {
            self::$pdo = $mysqlClient;
        }
        return self::$pdo;
    }
}
?>
