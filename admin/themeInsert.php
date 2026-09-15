<?php

include '../classes/database.php';
include '../classes/theme.php';


if (isset($_POST["name"])) {

    $theme = new Theme();

    $theme->name = $_POST["name"];

    $theme->insert();

    echo "<div class='alert alert-success' role='alert'>Thema toegevoegd.</div>";
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
    <link rel="stylesheet" href="../style.css">
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
        <h1>Thema toevoegen</h1>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">Naam</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Thema toevoegen</button>

        </form>
    </div>
                

    <script type="text/javascript" src="https://code.jquery.com/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.jqte').jqte();
    </script>

</body>

</html>