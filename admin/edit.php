<?php
include   "/../classes/database.php";
include   "/../classes/sessie.php";
include  "/../classes/gebruiker.php";
include  "/../classes/set.php";

if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php");
    exit;
}

$id = $_GET["id"];

$conn = Database::start();
$session = Sessie::findSession();

if ($session == null) {
    header("Location: inlog.php?message=Geen actieve sessie.");
    exit;
}

$userId = $session->session_user_id;

$user = User::findById($userId ->session_user_id);
$set = Set::findById($id);

if ($set == null) {
    header("Location: ../productpagina.php?message=Set niet gevonden.");
    exit;
}

if ($user->rol != "Admin" || $user->rol != "Medewerker") {
    header("Location: ../productpagina.php?message=Geen toestemming.");
    exit;
}

if (isset($_POST["set_name"]) || isset($_POST["set_description"]) || isset($_POST["set_brand_id"]) || isset($_POST["set_theme_id"]) || isset($_POST["set_price"]) || isset($_POST["set_age"]) || isset($_POST["set_pieces"]) || isset($_POST["set_stock"])) {
    $set->name = $_POST["set_name"];
    $set->description = $_POST["set_description"];
    $set->brandId = $_POST["set_brand_id"];
    $set->themeId = $_POST["set_theme_id"];
    $set->price = $_POST["set_price"];
    $set->age = $_POST["set_age"];
    $set->pieces = $_POST["set_pieces"];
    $set->stock = $_POST["set_stock"];

    if (!empty($_FILES["bestand"]["name"])) {
        $set->image = $_FILES["bestand"]["name"];

        move_uploaded_file(
            $_FILES["bestand"]["tmp_name"],
            "/../upload/" . $_FILES["bestand"]["name"]
        );
    }

    $set->update();
    header("Location: ../productpagina.php?message=Set succesvol aangepast.");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set aanpassen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Set aanpassen</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Naam</label>
        <input class="form-control" type="text" name="set_name" value="<?= $set->name ?>" required>

        <label>Beschrijving</label>
        <textarea class="form-control" name="set_description" rows="4" required><?= $set->description ?></textarea>

        <label>Brand ID</label>
        <input class="form-control" type="number" name="set_brand_id" value="<?= $set->brandId ?>">

        <label>Thema ID</label>
        <input class="form-control" type="number" name="set_theme_id" value="<?= $set->themeId ?>">

        <label>Afbeelding</label>
        <input class="form-control" type="file" name="bestand">

        <label>Prijs</label>
        <input class="form-control" type="text" name="set_price" value="<?= $set->price ?>">

        <label>Leeftijd</label>
        <input class="form-control" type="number" name="set_age" value="<?= $set->age ?>">

        <label>Stukken</label>
        <input class="form-control" type="number" name="set_pieces" value="<?= $set->pieces ?>">

        <label>Voorraad</label>
        <input class="form-control" type="number" name="set_stock" value="<?= $set->stock ?>">

        <button class="btn btn-primary mt-3" type="submit">Opslaan</button>
    </form>
</div>
</body>
</html>