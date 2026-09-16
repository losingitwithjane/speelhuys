<?php
include "classes/database.php";
include "classes/set.php";
include "classes/brand.php";
include "classes/theme.php";

$conn = Database::start();

// Haal alle merken, sets en thema's op voor de filters
$brands = Brand::findAll();
$themes = Theme::findAll();
$sets = Set::findAll();

$totalSetsInDatabase = Set::countAll();
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$perPage = 3;

// Filter op merk
if (isset($_GET['brand_id']) && $_GET['brand_id'] != '') {
    $brandId = $_GET['brand_id'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($set->brandId == $brandId) {
            $gefilterdeSets[] = $set;
        }
    }
    $sets = $gefilterdeSets;
}

// Filter op thema
if (isset($_GET['set_theme']) && $_GET['set_theme'] != '') {
    $themeId = $_GET['set_theme'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($set->themeId == $themeId) {
            $gefilterdeSets[] = $set;
        }
    }
    $sets = $gefilterdeSets;
}

// Filter op prijs
if (isset($_GET['price']) && $_GET['price'] != '') {
    $price = $_GET['price'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($price == '0-25' && $set->price < 25)
            $gefilterdeSets[] = $set;
        elseif ($price == '25-50' && $set->price >= 25 && $set->price < 50)
            $gefilterdeSets[] = $set;
        elseif ($price == '50-100' && $set->price >= 50 && $set->price < 100)
            $gefilterdeSets[] = $set;
    }
    $sets = $gefilterdeSets;
}

// Filter op leeftijd
if (isset($_GET['age']) && $_GET['age'] != '') {
    $age = $_GET['age'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($set->age >= $age) {
            $gefilterdeSets[] = $set;
        }
    }
    $sets = $gefilterdeSets;
}

// Filter op aantal stukken
if (isset($_GET['pieces']) && $_GET['pieces'] != '') {
    $pieces = $_GET['pieces'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($pieces == '2-20' && $set->pieces >= 2 && $set->pieces <= 20)
            $gefilterdeSets[] = $set;
        elseif ($pieces == '20-80' && $set->pieces > 20 && $set->pieces <= 80)
            $gefilterdeSets[] = $set;
        elseif ($pieces == '80-151' && $set->pieces > 80 && $set->pieces <= 151)
            $gefilterdeSets[] = $set;
        elseif ($pieces == '151-300' && $set->pieces > 151 && $set->pieces <= 300)
            $gefilterdeSets[] = $set;
        elseif ($pieces == '300+' && $set->pieces > 300)
            $gefilterdeSets[] = $set;
    }
    $sets = $gefilterdeSets;
}

// dit is dus de filter voor paginering

$totalFilteredSets = count($sets);
$totalPages = max(1, (int) ceil($totalFilteredSets / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;
$sets = array_slice($sets, $offset, $perPage);

$filterParams = $_GET;
unset($filterParams['page']);
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="productpagina.php">Producten</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <?php if (isset($_COOKIE["speelhuys-session"])) { ?>
                        <li class="nav-item"><a class="nav-link" href="admin/admin.php">Admin pagina</a></li>
                    <?php } ?>
                </ul>
                <div class="ms-3">
                    <?php if (!isset($_COOKIE["speelhuys-session"])) { ?>
                        <a href="admin/inlog.php" class="btn btn-login">Inloggen</a>
                    <?php } ?>
                </div>
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
                        <option value="0-25" <?= (isset($_GET['price']) && $_GET['price'] == '0-25') ? 'selected' : '' ?>>
                            €0 - €25</option>
                        <option value="25-50" <?= (isset($_GET['price']) && $_GET['price'] == '25-50') ? 'selected' : '' ?>>€25 - €50</option>
                        <option value="50-100" <?= (isset($_GET['price']) && $_GET['price'] == '50-100') ? 'selected' : '' ?>>€50 - €100</option>
                    </select>
                </div>


                <!-- Leeftijd Filter -->
                <div class="col">
                    <label for="age" class="form-label">Leeftijd</label>
                    <select name="age" id="age" class="form-select">
                        <option value="">Alle Leeftijden</option>
                        <option value="1" <?= (isset($_GET['age']) && $_GET['age'] == '1') ? 'selected' : '' ?>>1+ jaar
                        </option>
                        <option value="2" <?= (isset($_GET['age']) && $_GET['age'] == '2') ? 'selected' : '' ?>>2+ jaar
                        </option>
                        <option value="3" <?= (isset($_GET['age']) && $_GET['age'] == '3') ? 'selected' : '' ?>>3+ jaar
                        </option>
                        <option value="4" <?= (isset($_GET['age']) && $_GET['age'] == '4') ? 'selected' : '' ?>>4+ jaar
                        </option>
                        <option value="6" <?= (isset($_GET['age']) && $_GET['age'] == '6') ? 'selected' : '' ?>>6+ jaar
                        </option>
                        <option value="7" <?= (isset($_GET['age']) && $_GET['age'] == '7') ? 'selected' : '' ?>>7+ jaar
                        </option>
                        <option value="8" <?= (isset($_GET['age']) && $_GET['age'] == '8') ? 'selected' : '' ?>>8+ jaar
                        </option>
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
                <?php foreach ($sets as $set): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card product-card">
                            <img src="upload/sets/<?= htmlspecialchars($set->image) ?>" class="card-img-top"
                                style="height:200px; object-fit:contain; padding:10px;"
                                alt="<?= htmlspecialchars($set->name) ?>">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($set->name) ?></h5>
                                <p class="text-muted small">
                                    <?php foreach ($brands as $brand)
                                        if ($brand->id == $set->brandId)
                                            echo htmlspecialchars($brand->name); ?>
                                </p>
                                <p><?= htmlspecialchars(substr($set->description, 0, 80)) ?>...</p>
                                <a href="detail.php?id=<?= $set->id ?>" class="btn btn-teal-outline btn-sm mt-auto">Detail</a>
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

    <?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link"
                       href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

        </ul>
    </nav>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>