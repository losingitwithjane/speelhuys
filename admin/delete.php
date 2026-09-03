<?php
include "/../classes/database.php";
include "/../classes/sessie.php";
include "/../classes/gebruiker.php";
include "/../classes/set.php";

if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php?message=Geen set ID opgegeven.");
    exit;
}

$id = $_GET["id"];

$conn = Database::start();
$session = Sessie::findSession();
$user = User::findById($session->session_user_id);
$set = Set::findById($id);

if ($session == null) {
    header("Location: inlog.php?message=Geen actieve sessie.");
    exit;
}

if ($user->rol != "Admin"){    
    header("Location: ../productpagina.php?message=Geen toestemming.");
    exit;
}

if ($set == null) {
    header("Location: ../productpagina.php?message=Set niet gevonden.");
    exit;
}

// Verwijder na bevestiging
if (isset($_POST["ja"])) {
    $set->delete();
    header("Location: ../productpagina.php?message=Set succesvol verwijderd.");
    exit;
}

if (isset($_POST["nee"])) {
    header("Location: ../productpagina.php?message=Verwijderen geannuleerd.");
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
<div class="container mt-4">
    <h2>Weet je het zeker?</h2>
    <form method="POST">
        <button class="btn btn-danger" type="submit" name="ja">Ja</button>
        <button class="btn btn-secondary" type="submit" name="nee">Nee</button>
    </form>
</div>
</body>
</html>