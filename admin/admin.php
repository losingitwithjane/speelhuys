<?php
include "/../classes/database.php";
include "/../classes/gebruiker.php";
include "/../classes/sessie.php";
include "/../classes/set.php";

if (!isset($_COOKIE["speelhuys-session"])) { //als er geen sessie cookie is stuurt het de gebruiker terug
    header("Location: ../index.php?message=Geen cookie.");
    exit;
}

if (isset($_GET["message"])) { //toont messages in een bootstrap balk
    ?>
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="mr-2" viewBox="0 0 16 16" fill="currentColor">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            <?= htmlspecialchars($_GET["message"]) ?>
        </div>
    </div>
    <?php
}

$conn = Database::start(); //start database

$session = Sessie::findSession(); //zoekt een sessie 

if ($session == null) { //checkt of sessie null is of niet
    header("location: ../index.php?message=Geen user.");
    exit;
}

$userId = $session->session_user_id; //pakt de user id en stopt het in userid

$sets = Set::findAll(); //vindt alle sets
$user = User::findById($userId); //zoekt de user via userid

if ($user->rol == "employee") { //checkt of je admin bent
    echo "employee";
}
else if ($user->rol == "admin") {
    echo "admin";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <a href="../index.php" class="btn btn-danger btn-lg btn-outline-warning">
                Ga terug
            </a>
            <a href="../insert.php" class="btn btn-warning btn-lg btn-outline-success">
                Insert
            </a>
        </div>
    </div>

    <div class="container mt-5">
        <form method="post">
            <div class="row text-center">
                <?php
                //elke nieuwe blog zal een eigen card krijgen met alle informatie, zal ook 3 knoppen hebben, voor detail, aanpassen en verwijderen
                foreach ($sets as $set) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 mx-auto" style="max-width: 18rem;">
                            <div class="embed-responsive embed-responsive-1by1">
                                <img src="../upload/<?= $set->image ?>" class="card-img-top embed-responsive-item" style="object-fit: cover;" alt="">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= $set->name ?></h5>
                                <div class="clamp-3">
                                    <?= $set->description ?>
                                </div>
                                <a href="detailAdmin.php?id=<?= $set->id ?>"
                                    class="btn btn-primary mt-auto btn-outline-warning">Detail</a>

                                <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                                    <a href="edit.php?id=<?= $set->id; ?>"
                                        class="btn btn-sm btn-outline-primary">Aanpassen</a>
                                    <a href="delete.php?id=<?= $set->id; ?>"
                                        class="btn btn-sm btn-outline-danger">Verwijder</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </form>
    </div>
</body>

</html>