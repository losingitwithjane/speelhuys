<?php

include '../classes/database.php';
include '../classes/set.php';
include "../classes/sessie.php";

$conn = Database::start();
$session = Sessie::findSession();

if ($session == null) {
    header("Location: ../index.php?message=Geen sessie.");
}

if (!isset($_COOKIE["speelhuys-session"])) {
    header("Location: ../index.php?message=Geen cookie.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST["name"]) &&
        isset($_POST["description"]) &&
        isset($_POST["brandId"]) &&
        isset($_POST["themeId"]) &&
        isset($_FILES["image"]) &&
        isset($_POST["price"]) &&
        isset($_POST["age"]) &&
        isset($_POST["pieces"]) &&
        isset($_POST["stock"])
    ) {

        $name = $_POST["name"];
        $description = $_POST["description"];
        $brandId = $_POST["brandId"];
        $themeId = $_POST["themeId"];

        $image = $_FILES["image"]["name"];

        $price = $_POST["price"];
        $age = $_POST["age"];
        $pieces = $_POST["pieces"];
        $stock = $_POST["stock"];

        $target = "../Upload/";
        $target_file = $target . basename($_FILES["image"]["name"]);

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        $set = new Set();

        $set->name = $name;
        $set->description = $description;
        $set->brandId = $brandId;
        $set->themeId = $themeId;
        $set->image = $image;
        $set->price = $price;
        $set->age = $age;
        $set->pieces = $pieces;
        $set->stock = $stock;

        $set->insert();

        echo "<div class='alert alert-success' role='alert'>Set toegevoegd.</div>";

    } else {

        echo "<div class='alert alert-danger' role='alert'>Kan set niet toevoegen. Vul eerst alle velden in.</div>";

    }
}

?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigatie -->
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
                    <li class="nav-item"><a class="nav-link active" href="../contact.php">Contact</a></li>
                </ul>
                <div class="ms-3">
                    <a href="inlog.php" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Set toevoegen</h1>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">Naam</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Beschrijving</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="brandId" class="form-label">Merk</label>
                 <select class="form-control" name="brandId" id="brandId">
                    <option value="1">LEGO</option>
                    <option value="2">Kapla</option>
                    <option value="3">Duplo</option>
                    <option value="4">RoboTime</option>
                    <option value="5">SmartMax</option>
                    <option value="6">Brio</option>
                    <option value="7">Playmobil</option>
                    <option value="8">MegaBloks</option>
                    <option value="9">MegaConstrux</option>
                    <option value="10">Geomag</option>
                    <option value="11">KNEX</option>
                    <option value="12">GraviTax</option>
                    <option value="13">Clementoni</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="themeId" class="form-label">Thema</label>
                <select class="form-control" name="themeId" id="themeId">
                    <option value="1">Lego City</option>
                    <option value="2">Lego Marvel</option>
                    <option value="3">Lego Architecture</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Afbeelding</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prijs</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price">
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Leeftijd</label>
                <input type="number" class="form-control" name="age" id="age">
            </div>

            <div class="mb-3">
                <label for="pieces" class="form-label">Aantal steentjes</label>
                <input type="number" class="form-control" name="pieces" id="pieces">
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Voorraad</label>
                <input type="number" class="form-control" name="stock" id="stock">
            </div>

            <button type="submit" class="btn btn-primary">Set toevoegen</button>

        </form>

<!--laad de rich text editor en bootstrap-->
    <script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.jqte').jqte();
    </script>

</body>

</html>