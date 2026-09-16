<?php


class Sessie
{
    public $session_user_id;
    public $session_key;
    public $session_start;
    public $session_end;

    // function om de sessie te inserten in de database
    public function insert()
    {
        $conn = Database::start();

        $session_user_id = mysqli_real_escape_string($conn, $this->session_user_id);
        $session_key = mysqli_real_escape_string($conn, $this->session_key);
        $session_start = mysqli_real_escape_string($conn, $this->session_start);
        $session_end = mysqli_real_escape_string($conn, $this->session_end);

        $sql = "INSERT INTO sessions (
            session_user_id,
            session_key,
            session_start,
            session_end
        ) VALUES (
            '$session_user_id',
            '$session_key',
            '$session_start',
            '$session_end'
        )";

        $conn->query($sql);
        $conn->close();
    }

    // functie om de sessie te vinden in de database
    public static function findSession()
    {
        $conn = Database::start();

        if (!isset($_COOKIE['speelhuys-session'])) {
            $conn->close();
            return null;
        }

        $session_key = mysqli_real_escape_string($conn, $_COOKIE['speelhuys-session']);
        $sql = "SELECT * FROM `sessions` WHERE session_key = '$session_key'";
        $result = $conn->query($sql);

        $session = null;
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $session = new Sessie();
            $session->session_user_id = $row['session_user_id'];
            $session->session_key = $row['session_key'];
            $session->session_start = $row['session_start'];
            $session->session_end = $row['session_end'];
        }

        $conn->close();
        return $session;
    }

    // functie om de sessie uit de database te verwijderen
    public function delete()
    {
        $conn = Database::start();

        $session_key = mysqli_real_escape_string($conn, $this->session_key);
        $sql = "DELETE FROM `sessions` WHERE session_key = '$session_key'";

        $conn->query($sql);
        $conn->close();
    }
}
