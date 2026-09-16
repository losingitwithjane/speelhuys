<?php

include "../classes/database.php";
include "../classes/brand.php";
include "../classes/sessie.php";

$conn = Database::start();
$session = Sessie::findSession();

if ($session == null) {
    header("Location: ../index.php?message=Geen sessie.");
    exit;
}

if (!isset($_COOKIE["speelhuys-session"])) {
    header("Location: ../index.php?message=Geen cookie.");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["name"]) && isset($_FILES["logo"])) {

        $name = $_POST["name"];
        $logo = $_FILES["logo"]["name"];

        $target = "../Upload/logos/";
        $target_file = $target . basename($logo);

        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {

            $brand = new Brand();
            $brand->name = $name;
            $brand->logo = $logo;
            $brand->insert();

            header("Location: admin.php?message=Merk toegevoegd.");
            exit;

        } else {
            $message = "<div class='alert alert-danger' role='alert'>Afbeelding kon niet worden geüpload.</div>";
        }

    } else {
        $message = "<div class='alert alert-danger' role='alert'>Kan merk niet toevoegen. Vul eerst alle velden in.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merk toevoegen - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<?php $actievePagina = "werkplek"; $navPrefix = "../"; include "../nav.php"; ?>

<div class="container mt-5">

    <h1>Merk toevoegen</h1>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" name="logo" id="logo" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Merk toevoegen</button>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>