<?php
session_start();
include "Database.php"; 
$conn = Database::start();
if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php");
    exit;
}

$id = (int)$_GET["id"];

// Controleer of gebruiker ingelogd is
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login_page.php");
    exit;
}

// Haal gebruiker info op
$user_id = (int)$_SESSION["user_id"];
$result = mysqli_query($conn, "SELECT user_username, user_role FROM users WHERE user_id = $user_id");
if (!$result || mysqli_num_rows($result) === 0) {
    echo "Gebruiker niet gevonden.";
    exit;
}
$user = mysqli_fetch_assoc($result);

// Alleen 'joop' en 'ans' mogen verwijderen
if (!in_array($user['user_username'], ['joop', 'ans'])) {
    echo "Je hebt geen toestemming om sets te verwijderen.";
    exit;
}

// Controleer of set bestaat
$check = mysqli_query($conn, "SELECT * FROM sets WHERE set_id = $id");
if (mysqli_num_rows($check) === 0) {
    header("Location: ../productpagina.php?error=1");
    exit;
}

// Verwijder na bevestiging
if (isset($_POST["ja"])) {
    mysqli_query($conn, "DELETE FROM sets WHERE set_id = $id");
    header("Location: ../productpagina.php?deleted=1");
    exit;
}

if (isset($_POST["nee"])) {
    header("Location: ../productpagina.php");
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