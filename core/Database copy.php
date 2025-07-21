<?php
class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            try {
                $host = 'localhost';
                $dbname = 'smkw2994_absensi';
                $username = 'root';
                $password = '';

                self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
