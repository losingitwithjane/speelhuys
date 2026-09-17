<?php
include   "../classes/database.php";
include   "../classes/sessie.php";
include  "../classes/gebruiker.php";
include  "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php");
    exit;
}

if (!isset($_COOKIE["speelhuys-session"])) {
    header("Location: ../index.php?message=Geen cookie.");
}

$id = $_GET["id"];

$conn = Database::start();
$session = Sessie::findSession();

if ($session == null) {
    header("Location: inlog.php?message=Geen actieve sessie.");
    exit;
}

$userId = $session->session_user_id;

$user = User::findById($userId);
$set = Set::findById($id);
$themes = Theme::findAll();
$brands = Brand::findAll();
$currentTheme = Theme::findById($set->themeId);
$currentBrand = Brand::findById($set->brandId);

if ($set == null) {
    header("Location: ../productpagina.php?message=Set niet gevonden.");
    exit;
}

if ($user->rol != "medewerker" && $user->rol != "admin") {
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
    header("Location: admin.php?message=Set succesvol aangepast.");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set aanpassen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-te-1.4.0.css">
    <link rel="styleshee" href="../style.css">
</head>
<body>
<div class="container mt-4">
    <h2>Set aanpassen</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Naam</label>
        <input class="form-control" type="text" name="set_name" value="<?= $set->name ?>" required>

        <div class="mb-3">
            <label for="description" class="form-label">Beschrijving</label>
            <textarea class="jqte" name="set_description" id="set_description" rows="5" required><?= $set->description ?></textarea>
        </div>


        <div class="mb-3">
            <label for="brandId" class="form-label">Merk</label>
            <select class="form-select" name="set_brand_id" id="brandId" required>
                <option value=""><?= htmlspecialchars($currentBrand->name) ?></option>
                <?php foreach ($brands as $brand): ?>
                    <option value="<?= htmlspecialchars($brand->id) ?>"><?= htmlspecialchars($brand->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="themeId" class="form-label">Thema</label>
            <select class="form-select" name="set_theme_id" id="themeId" required>
                <option value=""><?= htmlspecialchars($currentTheme->name) ?></option>
                <?php foreach ($themes as $theme): ?>
                    <option value="<?= htmlspecialchars($theme->id) ?>"><?= htmlspecialchars($theme->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

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

    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.jqte').jqte();
    </script>

</body>
</html>