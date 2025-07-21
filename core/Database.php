<?php
class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            try {
                $config = require __DIR__ . '/config.php';

                $host     = $config['db_host'];
                $dbname   = $config['db_name'];
                $username = $config['db_user'];
                $password = $config['db_password'];

                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
