<?php
include "../classes/database.php";
include "../classes/sessie.php";
include "../classes/gebruiker.php";
include "../classes/brand.php";

if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php?message=Geen merk ID opgegeven.");
    exit;
}

if (!isset($_COOKIE["speelhuys-session"])) {
    header("Location: ../index.php?message=Geen cookie.");
}

$id = $_GET["id"];

$conn = Database::start();
$session = Sessie::findSession();
$user = User::findById($session->session_user_id);
$brand = Brand::findById($id);

if ($session == null) {
    header("Location: ../index.php?message=Geen actieve sessie.");
    exit;
}

if ($user->rol != "admin"){    
    header("Location: admin.php?message=Geen toestemming.");
    exit;
}

if ($brand == null) {
    header("Location: admin.php?message=Merk niet gevonden.");
    exit;
}

// Verwijder na bevestiging
if (isset($_POST["ja"])) {
    $brand->delete();
    header("Location: admin.php?message=Merk succesvol verwijderd.");
    exit;
}

if (isset($_POST["nee"])) {
    header("Location: admin.php?message=Verwijderen geannuleerd.");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set verwijderen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5" style="max-width: 400px;">
        <div class="card text-bg-dark mb-3">
            <div class="card-body">
                <h3 class="card-title">Verwijderen?</h3>
                <p class="card-text">
                <form method="post">
                    <button class="btn btn-danger" type="submit" name="ja">Ja</button>
                    <button class="btn btn-secondary" type="submit" name="nee">Nee</button>
                </form>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>