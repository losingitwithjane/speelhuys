<?php
$conn = Database::start();
include "Database.php"; 

if (!isset($_GET["id"])) {
    header("Location: ../productpagina.php");
    exit;
}

$id = (int)$_GET["id"];

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login_page.php");
    exit;
}

$user_id = (int)$_SESSION["user_id"];
$result = mysqli_query($conn, "SELECT user_role FROM users WHERE user_id = $user_id");
if (!$result || mysqli_num_rows($result) === 0) {
    echo "Gebruiker niet gevonden.";
    exit;
}
$user = mysqli_fetch_assoc($result);

if (!in_array($user['user_role'], ['admin', 'employee'])) {
    echo "Je hebt geen toestemming om sets aan te passen.";
    exit;
}

$set_sql = mysqli_query($conn, "SELECT * FROM sets WHERE set_id = $id");
if (mysqli_num_rows($set_sql) === 0) {
    header("Location: ../productpagina.");
    exit;
}
$set = mysqli_fetch_assoc($set_sql);
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["set_name"])) {
    $set_name        = mysqli_real_escape_string($conn, $_POST["set_name"]);
    $set_description = mysqli_real_escape_string($conn, $_POST["set_description"]);
    $set_brand_id    = (int)$_POST["set_brand_id"];
    $set_theme_id    = (int)$_POST["set_theme_id"];
    $set_price       = (float)$_POST["set_price"];
    $set_age         = (int)$_POST["set_age"];
    $set_pieces      = (int)$_POST["set_pieces"];
    $set_stock       = (int)$_POST["set_stock"];

    $image_path = $set["set_image"];
    if (!empty($_FILES["bestand"]["name"])) {
        $image_name = basename($_FILES["bestand"]["name"]);
        $target     = "../imagine/" . $image_name;
        if (move_uploaded_file($_FILES["bestand"]["tmp_name"], $target)) {
            $image_path = "imagine/" . $image_name;
        }
    }

    $update = "
        UPDATE sets
        SET set_name = '$set_name',
            set_description = '$set_description',
            set_brand_id = $set_brand_id,
            set_theme_id = $set_theme_id,
            set_image = '$image_path',
            set_price = $set_price,
            set_age = $set_age,
            set_pieces = $set_pieces,
            set_stock = $set_stock
        WHERE set_id = $id
    ";

    if (mysqli_query($conn, $update)) {
        $message = "Set succesvol bijgewerkt!";
        $set_sql = mysqli_query($conn, "SELECT * FROM sets WHERE set_id = $id");
        $set = mysqli_fetch_assoc($set_sql);
    } else {
        $message = "Fout bij bijwerken: " . mysqli_error($conn);
    }
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
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Naam</label>
        <input class="form-control" type="text" name="set_name" value="<?= $set['set_name'] ?>" required>

        <label>Beschrijving</label>
        <textarea class="form-control" name="set_description" rows="4" required><?= $set['set_description'] ?></textarea>

        <label>Brand ID</label>
        <input class="form-control" type="number" name="set_brand_id" value="<?= $set['set_brand_id'] ?>">

        <label>Thema ID</label>
        <input class="form-control" type="number" name="set_theme_id" value="<?= $set['set_theme_id'] ?>">

        <label>Afbeelding</label>
        <input class="form-control" type="file" name="bestand">

        <label>Prijs</label>
        <input class="form-control" type="text" name="set_price" value="<?= $set['set_price'] ?>">

        <label>Leeftijd</label>
        <input class="form-control" type="number" name="set_age" value="<?= $set['set_age'] ?>">

        <label>Stukken</label>
        <input class="form-control" type="number" name="set_pieces" value="<?= $set['set_pieces'] ?>">

        <label>Voorraad</label>
        <input class="form-control" type="number" name="set_stock" value="<?= $set['set_stock'] ?>">

        <button class="btn btn-primary mt-3" type="submit">Opslaan</button>
    </form>
</div>
</body>
</html>