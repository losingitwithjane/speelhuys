<?php
class User
{
    public $id;
    public $voornaam;
    public $achternaam;
    public $email;
    public $gebruikersnaam;
    public $wachtwoord;
    public $rol;

    public static function findAll()
    {
        $conn = Database::start();

        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        $users = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User();

                $user->id = $row["id"];
                $user->voornaam = $row["firstname"];
                $user->achternaam = $row["lastname"];
                $user->email = $row["email"];
                $user->gebruikersnaam = $row["username"];
                $user->wachtwoord = $row["password"];
                $user->rol = $row["role"];

                $users[] = $user;
            }
        }
        $conn->close();
        return $users;
    }

    public static function findById($id)
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM users WHERE id = " . $id;
        $result = $conn->query($sql);

        $user = null;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User();

                $user->id = $row["id"];
                $user->voornaam = $row["firstname"];
                $user->achternaam = $row["lastname"];
                $user->email = $row["email"];
                $user->gebruikersnaam = $row["username"];
                $user->wachtwoord = $row["password"];
                $user->rol = $row["role"];
            }
        }
        $conn->close();
        return $user;
    }

    public static function findByCredentials($gebruikersnaam, $wachtwoord)
    {
        $conn = Database::start();

        $gebruikersnaam = mysqli_real_escape_string($conn, $gebruikersnaam);
        $wachtwoord = mysqli_real_escape_string($conn, $wachtwoord);

        $sql = "SELECT * FROM users WHERE user_username = '$gebruikersnaam' AND user_password = '$wachtwoord'";
        $result = $conn->query($sql);

        $user = null;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User();

                $user->id = $row["id"];
                $user->voornaam = $row["firstname"];
                $user->achternaam = $row["lastname"];
                $user->email = $row["email"];
                $user->gebruikersnaam = $row["username"];
                $user->wachtwoord = $row["password"];
                $user->rol = $row["role"];
            }
        }
        $conn->close();
        return $user;
    }

    public function update()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $voornaam = mysqli_real_escape_string($conn, $this->voornaam);
        $achternaam = mysqli_real_escape_string($conn, $this->achternaam);
        $email = mysqli_real_escape_string($conn, $this->email);
        $gebruikersnaam = mysqli_real_escape_string($conn, $this->gebruikersnaam);
        $wachtwoord = mysqli_real_escape_string($conn, $this->wachtwoord);
        $rol = mysqli_real_escape_string($conn, $this->rol);

        $sql = "
            UPDATE
                users
            SET
                firstname = '$voornaam',
                lastname = '$achternaam',
                email = '$email',
                username = '$gebruikersnaam',
                password = '$wachtwoord',
                role = '$rol'
            WHERE
                id = $id
        ";
        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function insert()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);
        $voornaam = mysqli_real_escape_string($conn, $this->voornaam);
        $achternaam = mysqli_real_escape_string($conn, $this->achternaam);
        $email = mysqli_real_escape_string($conn, $this->email);
        $gebruikersnaam = mysqli_real_escape_string($conn, $this->gebruikersnaam);
        $wachtwoord = mysqli_real_escape_string($conn, $this->wachtwoord);
        $rol = mysqli_real_escape_string($conn, $this->rol);

        $sql = "INSERT INTO users
        (id,
        firstname,
        lastname,
        email,
        username,
        password,
        role)
        VALUES
        ('$id',
        '$voornaam',
        '$achternaam',
        '$email',
        '$gebruikersnaam',
        '$wachtwoord',
        '$rol')";

        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }

    public function delete()
    {
        $conn = Database::start();

        $id = mysqli_real_escape_string($conn, $this->id);

        $sql = "
            DELETE FROM
                users
            WHERE
                id = $id
        ";
        $result = $conn->query($sql);
        if (!$result) {
            die("error" . $conn->error);
        }
        $conn->close();
    }
}
?>