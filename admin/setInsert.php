<?php

include "../classes/database.php";
include "../classes/set.php";
include "../classes/sessie.php";
include "../classes/brand.php";
include "../classes/theme.php";

$conn = Database::start();
$session = Sessie::findSession();
$brands = Brand::findAll();
$themes = Theme::findAll();

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

    if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["brandId"]) && isset($_POST["themeId"]) && isset($_FILES["image"]) && isset($_POST["price"]) && isset($_POST["age"]) && isset($_POST["pieces"]) && isset($_POST["stock"])) {

        $name = $_POST["name"];
        $description = $_POST["description"];
        $brandId = $_POST["brandId"];
        $themeId = $_POST["themeId"];
        $image = $_FILES["image"]["name"];
        $price = $_POST["price"];
        $age = $_POST["age"];
        $pieces = $_POST["pieces"];
        $stock = $_POST["stock"];

        $target = "../Upload/sets/";
        $target_file = $target . basename($image);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

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

            header("Location: admin.php?message=Set toegevoegd.");
            exit;

        } else {
            $message = "<div class='alert alert-danger' role='alert'>Afbeelding kon niet worden geüpload.</div>";
        }

    } else {
        $message = "<div class='alert alert-danger' role='alert'>Kan set niet toevoegen. Vul eerst alle velden in.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set toevoegen - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/jquery-te-1.4.0.css">

</head>

<body>

<?php $actievePagina = "werkplek"; $navPrefix = "../"; include "../nav.php"; ?>

<div class="container mt-5">

    <h1>Set toevoegen</h1>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Beschrijving</label>
            <textarea class="jqte" name="description" id="description" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="brandId" class="form-label">Merk</label>
            <select class="form-select" name="brandId" id="brandId" required>
                <option value="">Kies een merk</option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= htmlspecialchars($brand->id) ?>"><?= htmlspecialchars($brand->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="themeId" class="form-label">Thema</label>
            <select class="form-select" name="themeId" id="themeId" required>
                <option value="">Kies een thema</option>
                <?php foreach ($themes as $theme): ?>
                    <option value="<?= htmlspecialchars($theme->id) ?>"><?= htmlspecialchars($theme->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Afbeelding</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prijs</label>
            <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Leeftijd</label>
            <input type="number" min="0" class="form-control" name="age" id="age" required>
        </div>

        <div class="mb-3">
            <label for="pieces" class="form-label">Aantal steentjes</label>
            <input type="number" min="0" class="form-control" name="pieces" id="pieces" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Voorraad</label>
            <input type="number" min="0" class="form-control" name="stock" id="stock" required>
        </div>

        <button type="submit" class="btn btn-primary">Set toevoegen</button>

    </form>

</div>

    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.jqte').jqte();
    </script>
</body>
</html>
