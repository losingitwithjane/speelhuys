<?php
include "../classes/database.php";
include "../classes/sets.php";
include "../classes/gebruiker.php";
include "../classes/sessie.php";

if (!isset($_GET["id"])) { //checkt of de id mee is genomen
    header("Location: index.php?message=Geen id meegegeven.");
    exit;
}

$sessie = Sessie::vindActieveSessie();

if ($sessie == null) { //als er geen sessie is dan wordt je terug gestuurd
    header("location: index.php?message=Geen user.");
    exit;
}

$userId = $sessie->userId;
$user = User::findById($userId);

if ($user->admin != 1) { //checkt of je admin bent
    header("location: index.php?message=Geen admin.");
    exit;
}

$sets = Sets::findById($_GET["id"]); //pakt correcte blog via id

if ($sets == null) {
    header("Location: overzicht.php?message=Geen blog.");
    exit;
}


if (isset($_POST["titel"]) || isset($_POST["inhoud"]) || isset($_FILES["bestand"])) {
    $blog->titel = $_POST["titel"];
    $blog->inhoud = $_POST["inhoud"];

    if (!empty($_FILES["bestand"]["name"])) {
        $blog->afbeelding = $_FILES["bestand"]["name"];

        move_uploaded_file(
            $_FILES["bestand"]["tmp_name"],
            "../upload/" . $_FILES["bestand"]["name"]
        );
    }

    $blog->update();
    header("location: admin.php");
    exit;
} //update de oude informatie met de nieuwe
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog toevoegen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/jquery-te-1.4.0.css">
</head>

<body>
    <div
        style="background-image: url('../images/backgroundthing.jpg'); background-size: 100% 100%; background-repeat: no-repeat; width: 100vw; height: 100vh; position: fixed; top: 0; left: 0; z-index: -1;">
    </div>

    <div class="container-fluid px-5 mt-3">
        <div class="d-flex justify-content-between">
            <a href="admin.php" class="btn btn-primary btn-lg btn-outline-danger">
                Ga terug
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 bg-white p-4 rounded shadow">
                <h2>RichTextEditor</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    titel
                    <input type="text" name="titel" value="<?= $blog->titel ?>">
                    <br>
                    <br>
                    auteur
                    <input type="text" name="auteur" value="<?= $blog->auteur ?>">
                    <br>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea class="jqte" id="content" name="inhoud"><?= $blog->inhoud ?></textarea>
                    </div>
                    <label for="bestand">Bestand:</label>
                    <br>
                    <input type="file" id="bestand" name="bestand" />
                    <br>
                    <img id="preview" src="../upload/<?= $blog->afbeelding ?>" style="max-width: 300px; max-height: 300px; display: block;">
                    <br>
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn-lg btn-outline-danger">
                            Update blog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.jqte').jqte();
    </script>

</body>

</html>