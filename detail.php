<?php
include "classes/database.php";
include "classes/set.php";

if (!isset($_GET["id"])) {
    header("Location: productpagina.php?message=Geen id meegegeven.");
    exit;
}

$conn = Database::start();
$set = Set::findById($_GET["id"]);

if ($set == null) {
    echo "Set niet gevonden";
    exit;
}

//laat de details van een blog zien met de auteur, id, titel, afbeelding en inhoud
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Blog</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid px-5 mt-3">
        <div class="d-flex justify-content-between">
            <a href="productpagina.php" class="btn btn-danger btn-lg btn-outline-warning">
                Ga terug
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 bg-white p-4 rounded shadow">

                <h2 class="mb-4">Set details</h2>

                <div class="text-center mb-4">
                    <img src="Upload/sets/<?= $set->image ?>" class="img-fluid img-thumbnail"
                        style="max-height: 400px;">
                </div>
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Name</th>
                        <td><?= $set->name ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?= $set->description ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

</body>

</html>