<?php

class User
{
    public int $id;
    public string $voornaam;
    public string $achternaam;
    public string $email;
    public string $gebruikersnaam;
    public string $wachtwoord;
    public string $rol;

    public static function gebruikerEnWachtwoord(string $gebruikersnaam, string $wachtwoord)
    {
        include 'database.php'; 
        $gebruikersnaam = mysqli_real_escape_string($conn, $gebruikersnaam);
        $wachtwoord = mysqli_real_escape_string($conn, $wachtwoord);

        $query = "SELECT * FROM users WHERE username = '$gebruikersnaam' AND password = '$wachtwoord'";
        $resultaat = $conn->query($query);

        $users = [];

        if ($resultaat->num_rows > 0) {
            while ($row = $resultaat->fetch_assoc()) {
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

    
    public static function Find(int $id)
    {
        include 'database.php'; 

        $id = mysqli_real_escape_string($conn, $id);
        $query = "SELECT * FROM users WHERE id = '$id'"; 
        $result = $conn->query($query);

        $user = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user = new User();
            $user->id = $row["id"];
            $user->voornaam = $row["firstname"];
            $user->achternaam = $row["lastname"];
            $user->email = $row["email"];
            $user->gebruikersnaam = $row["username"];
            $user->wachtwoord = $row["password"];
            $user->rol = $row["role"];
        }

        $conn->close();
        return $user;
    }
}

?>
