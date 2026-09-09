<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog overzicht</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <a href="index.php" class="btn btn-danger btn-lg btn-outline-warning">
                Ga terug
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row text-center">

            <?php
            include "classes/database.php";
            include "classes/set.php";

            $sets = Set::findAll();
            ?>

            <?php foreach ($sets as $set) { //aparte card voor iedere set met hun eigen informatie?>
                <div class="col-md-4 mb-4">

                    <div class="card h-100 mx-auto" style="width: 18rem;">

                        <div class="embed-responsive embed-responsive-1by1">
                            <img src="Upload/sets/<?= $set->image ?>" class="card-img-top embed-responsive-item"
                                style="object-fit: fill;" alt="">
                        </div>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title"><?= $set->name ?></h5>

                            <p class="card-text text-truncate-custom">
                                <?= $set->description ?>
                            </p>

                            <a href="detail.php?id=<?= $set->id ?>" class="btn btn-primary mt-auto">
                                Detail
                            </a>

                        </div>
                    </div>

                </div>
            <?php } ?>

        </div>
    </div>

</body>

</html>