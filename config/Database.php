<?php

class Database {

    private static $host = "localhost";
    private static $dbname = "aunt_joy";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

    public static function connect() {

        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname,
                    self::$username,
                    self::$password
                );

                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Database Connection Failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
