<?php
class Database
{
    public static function start() //start functie om de database te starten
    {
        $dbServername = "127.0.0.1";
        $dbUsername = "root";
        $dbPassword = "mysql";
        $dbDatabase = "speelhuys";

        // PHP 8 gooit een exception bij een mislukte verbinding, dus vangen we die
        // op om daarna alsnog het wachtwoord te kunnen proberen.
        try {
            $conn = new mysqli($dbServername, $dbUsername, "", $dbDatabase);
        } catch (mysqli_sql_exception $e) {
            $conn = null;
        }

        if ($conn === null || $conn->connect_error) {
            try {
                $conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbDatabase);
            } catch (mysqli_sql_exception $e) {
                die("Connection failed: " . $e->getMessage());
            }

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        }

        return $conn;
    }
}
