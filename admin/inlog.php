<?php
include '../classes/database.php';
include '../classes/sessie.php';
include '../classes/gebruiker.php';

$conn = Database::start();

$sessie = Sessie::findSession();

if ($sessie) {
    header("Location: admin.php?message=Al ingelogd.");
}

$melding = isset($_GET["message"]) ? $_GET["message"] : "";

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
        $melding = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Speel<span>huys</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../productpagina.php">Producten</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-wrap">
        <div class="login-card">
            <div class="text-center mb-4">
                <i class="bi bi-box-arrow-in-right login-icon"></i>
                <h1 class="mt-2">Inloggen</h1>
                <p class="mb-0">Log in om het assortiment te beheren.</p>
            </div>

            <?php if ($melding != "") { ?>
                <div class="login-alert d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <div><?= htmlspecialchars($melding) ?></div>
                </div>
            <?php } ?>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-teal w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Inloggen
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                <a href="../index.php" class="text-accent">
                    <i class="bi bi-arrow-left"></i> Terug naar de winkel
                </a>
            </p>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 Speelhuys - Door Joop en Ans</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
