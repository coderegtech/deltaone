<?php
// Deny direct access
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    http_response_code(403);
    exit("Access denied.");
}

class DBConnection
{
    private static $instance = null;
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "codereg";
    private static $defaultDB = "stock";
    private static $currentDB = null;

    private static function env()
    {
        static $done = false;
        if (!$done) {
            $done = true;
            self::$servername = getenv('DB_HOST') ?: self::$servername;
            self::$username = getenv('DB_USER') ?: self::$username;
            if (getenv('DB_PASS') !== false) {
                self::$password = getenv('DB_PASS');
            }
            self::$defaultDB = getenv('DB_NAME') ?: self::$defaultDB;
        }
    }

    private function __construct() {}
    private function __clone() {}


    public static function getCurrentDatabase()
    {
        return self::$currentDB ?? self::$defaultDB;
    }

    // Check if database exists before connecting
    private static function databaseExists($dbName)
    {
        $conn = new mysqli(self::$servername, self::$username, self::$password);
        if ($conn->connect_error) {
            throw new Exception("Pre-check connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->bind_param("s", $dbName);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        $conn->close();

        return $exists;
    }

    public static function setDatabase($dbName)
    {
        self::env();
        if (!self::databaseExists($dbName)) {
            throw new Exception("Database '$dbName' does not exist.");
        }

        if ($dbName !== self::$currentDB) {
            self::$currentDB = $dbName;
            self::$instance = null;
        }
    }

    public static function getConnection()
    {
        self::env(); // pick up DB_HOST/DB_USER/DB_PASS/DB_NAME (Docker) before the localhost defaults
        if (self::$currentDB === null) {
            self::$currentDB = self::$defaultDB;
        }

        if (self::$instance === null) {
            self::$instance = new mysqli(
                self::$servername,
                self::$username,
                self::$password,
                self::$currentDB
            );

            if (self::$instance->connect_error) {
                throw new Exception("Connection failed: " . self::$instance->connect_error);
            }
        }

        return self::$instance;
    }
}
