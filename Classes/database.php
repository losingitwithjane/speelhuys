<?php
class Database
{
    public static function start() //start functie om de database te starten
    {
        $dbServername = "127.0.0.1";
        $dbUsername = "root";
        $dbPassword = "mysql";
        $dbDatabase = "speelhuys";

        $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbDatabase);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}
?>