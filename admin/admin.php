<?php
include "../classes/database.php";
include "../classes/gebruiker.php";
include "../classes/sessie.php";
include "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

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
$brands = Brand::findAll();
$theme = Theme::findAll();
$user = User::findById($userId); //zoekt de user via userid

if ($user->rol == "employee") { //checkt of je admin bent
    echo "employee";
}
else if ($user->rol == "admin") {
    echo "admin";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="index.php">Speel<span>huys</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../productpagina.php">Producten</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin/admin.php">Admin pagina</a></li>
                    <li class="nav-item"><a class="nav-link" href="brandInsert.php">Merk Toevoegen</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Filters -->
    <div class="container mt-4">
        <div class="card filter-card p-4">
            <form method="GET" class="row g-3">
                <!-- Merk Filter -->
                <div class="col-md-2">
                    <label for="brand_id" class="form-label">Merk</label>
                    <select name="brand_id" id="brand_id" class="form-select">
                        <option value="">Alle Merken</option>
                        <?php foreach ($brands as $brand):
                            $sel = isset($_GET['brand_id']) && $_GET['brand_id'] == $brand->id ? 'selected' : '';
                        ?>
                            <option value="<?= $brand->id ?>" <?= $sel ?>><?= htmlspecialchars($brand->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Thema Filter -->
                <div class="col">
                    <label for="set_theme" class="form-label">Thema</label>
                    <select name="set_theme" id="set_theme" class="form-select">
                        <option value="">Alle Thema's</option>
                        <?php foreach ($themes as $theme):
                            $sel = isset($_GET['set_theme']) && $_GET['set_theme'] == $theme->id ? 'selected' : '';
                        ?>
                            <option value="<?= $theme->id ?>" <?= $sel ?>><?= htmlspecialchars($theme->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Prijs Filter -->
                <div class="col">
                    <label for="price" class="form-label">Prijs</label>
                    <select name="price" id="price" class="form-select">
                        <option value="">Alle Prijzen</option>
                        <option value="0-25" <?= (isset($_GET['price']) && $_GET['price'] == '0-25') ? 'selected' : '' ?>>€0 - €25</option>
                        <option value="25-50" <?= (isset($_GET['price']) && $_GET['price'] == '25-50') ? 'selected' : '' ?>>€25 - €50</option>
                        <option value="50-100" <?= (isset($_GET['price']) && $_GET['price'] == '50-100') ? 'selected' : '' ?>>€50 - €100</option>
                    </select>
                </div>


                <!-- Leeftijd Filter -->
                <div class="col">   
                    <label for="age" class="form-label">Leeftijd</label>
                    <select name="age" id="age" class="form-select">
                        <option value="">Alle Leeftijden</option>
                        <option value="1" <?= (isset($_GET['age']) && $_GET['age'] == '1') ? 'selected' : '' ?>>1+ jaar</option>
                        <option value="2" <?= (isset($_GET['age']) && $_GET['age'] == '2') ? 'selected' : '' ?>>2+ jaar</option>
                        <option value="3" <?= (isset($_GET['age']) && $_GET['age'] == '3') ? 'selected' : '' ?>>3+ jaar</option>
                        <option value="4" <?= (isset($_GET['age']) && $_GET['age'] == '4') ? 'selected' : '' ?>>4+ jaar</option>
                        <option value="6" <?= (isset($_GET['age']) && $_GET['age'] == '6') ? 'selected' : '' ?>>6+ jaar</option>
                        <option value="7" <?= (isset($_GET['age']) && $_GET['age'] == '7') ? 'selected' : '' ?>>7+ jaar</option>
                        <option value="8" <?= (isset($_GET['age']) && $_GET['age'] == '8') ? 'selected' : '' ?>>8+ jaar</option>
                    </select>
                </div>


                <!-- Stukken Filter -->
                <div class="col">
                    <label for="pieces" class="form-label">Stukken</label>
                    <select name="pieces" id="pieces" class="form-select">
                        <option value="">Alle Aantallen</option>
                        <option value="2-20" <?= (isset($_GET['pieces']) && $_GET['pieces'] == '2-20') ? 'selected' : '' ?>>2 - 20 stukken</option>
                        <option value="20-80" <?= (isset($_GET['pieces']) && $_GET['pieces'] == '20-80') ? 'selected' : '' ?>>20 - 80 stukken</option>
                        <option value="80-151" <?= (isset($_GET['pieces']) && $_GET['pieces'] == '80-151') ? 'selected' : '' ?>>80 - 151 stukken</option>
                        <option value="151-300" <?= (isset($_GET['pieces']) && $_GET['pieces'] == '151-300') ? 'selected' : '' ?>>151 - 300 stukken</option>
                        <option value="300+" <?= (isset($_GET['pieces']) && $_GET['pieces'] == '300+') ? 'selected' : '' ?>>300+ stukken</option>
                    </select>
                </div>


                <!-- Filter Button -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-teal w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Producten -->
    <div class="container mt-3">
        <div class="row">
            <?php if (count($sets) > 0): ?>
                <?php foreach ($sets as $set):?>
                    <div class="col-md-4 mb-3">
                        <div class="card product-card">
                            <img src="../upload/sets/<?= htmlspecialchars($set->image) ?>"
                                 class="card-img-top"
                                 style="height:200px; object-fit:contain; padding:10px;"
                                 alt="<?= htmlspecialchars($set->name) ?>">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($set->name) ?></h5>
                                <p class="text-muted small"><?php foreach ($brands as $brand) if ($brand->id == $set->brandId) echo htmlspecialchars($brand->name); ?></p>
                                <p><?= htmlspecialchars(substr($set->description, 0, 80)) ?>...</p>
                                <a href="detail.php?id=<?= $set->id ?>" class="btn btn-teal-outline btn-sm mt-auto">Detail</a>
                                <a href="setEdit.php?id=<?= $set->id ?>" class="btn btn-outline-info btn-sm mt-auto">Edit</a>
                                <a href="setDelete.php?id=<?= $set->id ?>" class="btn btn-outline-danger btn-sm mt-auto">Verwijder</a>
                                <p class="mt-2">
                                    <span class="badge badge-teal"><?= $set->age ?>+ jaar</span>
                                    <span class="badge badge-soft"><?= $set->pieces ?> stukjes</span>
                                </p>
                                <h5 class="prijs">€<?= number_format($set->price, 2) ?></h5>
                                <?php $badge = $set->stock > 0 ? 'badge-teal' : 'badge-muted'; ?>
                                <span class="badge <?= $badge ?>"><?= $set->stock > 0 ? 'Op voorraad' : 'Uitverkocht' ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">    
                    <p class="text-center">Geen sets gevonden met de geselecteerde filters.</p>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>