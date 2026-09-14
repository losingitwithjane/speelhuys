<html>

<head>
    <title>Inloggen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<?php
if (isset($_GET["message"])) {
    ?>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="mr-2" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        <div>
            <?= htmlspecialchars($_GET["message"]) ?>
        </div>
    </div>
    <?php
}
?>

    <div class="container text-center mt-5" style="max-width: 400px;">
        <div class="card text-bg-dark mb-3">
            <div class="card-body">
                <h3 class="card-title">Inloggen</h3>
                <p class="card-text">
                <form method="post">

                    <p>Gebruikersnaam</p>
                    <input type="text" name="username" required> <br><br>

                    <p>Wachtwoord</p>
                    <input type="password" name="password" required> <br><br>

                    <input type="submit" value="Inloggen" class="btn btn-warning btn-lg btn-outline-success">
                </form>
                </p>
            </div>
        </div>
    </div>
</body>

</html>


<?php
include '../classes/database.php';
include '../classes/sessie.php';
include '../classes/gebruiker.php';

$conn = Database::start();

if (isset($_POST["username"]) && $_POST["username"] != "" && isset($_POST["password"]) && $_POST["password"] != "") { //controleert of de gebruikersnaam en wachtwoord zijn ingevuld

    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = User::findByCredentials($username, $password); //geeft de gebruiker terug die overeenkomt met de gebruikersnaam en wachtwoord

    if ($user) {
        $key = md5(uniqid(rand(), true));

        $sessie = new Sessie(); //maakt een nieuwe sessie aan

        $sessie->session_user_id = $user->id;
        $sessie->session_key = $key;
        $sessie->session_start = date("Y-m-d H:i:s"); //slaat de starttijd van de sessie op
        $sessie->session_end = date("Y-m-d H:i:s", strtotime("+1 day")); //slaat de eindtijd van de sessie op

        $sessie->insert(); //voegt de sessie toe aan de database

        setcookie('speelhuys-session', $key, time() + 86400, '/'); //zet een cookie met de sessiesleutel

        header('Location: admin.php');
        exit;
    } else {
    ?>
        <div class="container text-center mt-5" style="max-width: 400px;">
            <div class="card text-bg-dark mb-3">
                <div class="card-body">
                    <p class="card-text">Ongeldige gebruikersnaam of wachtwoord</p>
                </div>
            </div>
        </div>
    <?php
    }
} 
?>

