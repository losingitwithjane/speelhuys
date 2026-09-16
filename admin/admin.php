<?php
include "../classes/database.php";
include "../classes/gebruiker.php";
include "../classes/sessie.php";
include "../classes/set.php";
include "../classes/brand.php";
include "../classes/theme.php";

$conn = Database::start();

$session = Sessie::findSession();

if ($session == null) {
    header("Location: inlog.php?message=Log in.");
    exit;
}

$user = User::findById($session->session_user_id);

if ($user == null) {
    header("Location: ../index.php?message=Gebruiker niet gevonden.");
    exit;
}

if ($user->rol != "admin" && $user->rol != "employee") {
    header("Location: ../index.php?message=Geen toestemming voor het beheer.");
    exit;
}

$isAdmin = ($user->rol == "admin");

$melding = isset($_GET["message"]) ? $_GET["message"] : "";

$brands = Brand::findAll();
$themes = Theme::findAll();
$sets = Set::findAll();

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

if (isset($_GET['stock']) && $_GET['stock'] != '') {
    $stock = $_GET['stock'];
    $gefilterdeSets = [];
    foreach ($sets as $set) {
        if ($stock == 'op' && $set->stock > 0) $gefilterdeSets[] = $set;
        elseif ($stock == 'uit' && $set->stock == 0) $gefilterdeSets[] = $set;
    }
    $sets = $gefilterdeSets;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheer - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php $actievePagina = "werkplek"; $navPrefix = "../"; include "../nav.php"; ?>

    <div class="container mt-4">
        <?php if ($melding != "") { ?>
            <div class="login-alert d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <div><?= htmlspecialchars($melding) ?></div>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="beheer-titel mb-0">Assortiment beheren</h1>
            <?php if ($isAdmin) { ?>
            <div class="d-flex gap-2">
                <a href="setInsert.php" class="btn btn-teal">
                    <i class="bi bi-plus-lg"></i> Maak set
                </a>
                <a href="brandInsert.php" class="btn btn-teal">
                    <i class="bi bi-plus-lg"></i> Maak merk
                </a>
                <a href="themeInsert.php" class="btn btn-teal">
                    <i class="bi bi-plus-lg"></i> Maak thema
                </a>
            </div>

            <?php } ?>
        </div>

        <div class="card filter-card p-4">
            <form method="GET" class="row g-3">

            <div class="col">
                <label class="form-label d-block">Merk</label>
                <div class="dropdown">
                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="brandDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Alle Merken
                    </button>

                    <ul class="dropdown-menu w-100" aria-labelledby="brandDropdown">
                        <li>
                            <a class="dropdown-item" href="?brand_id=">Alle Merken</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        
                        <?php foreach ($brands as $brand) { ?>
                            <li class="px-3 py-1 d-flex justify-content-between align-items-center dropdown-item-container">
                                <a class="text-decoration-none text-dark flex-grow-1 py-1" href="?brand_id=<?= $brand->id ?>">
                                    <?= htmlspecialchars($brand->name) ?>
                                </a>
                                <a href="brandDelete.php?id=<?= $brand->id ?>" class="btn btn-verwijder btn-sm ms-auto">
                                    <i class="bi bi-trash"></i> Verwijder
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col">
                <label class="form-label d-block">Thema</label>
                <div class="dropdown">
                    <button class="btn btn-outline-success dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center" type="button" id="brandDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Alle Theme's
                    </button>

                    <ul class="dropdown-menu w-100" aria-labelledby="brandDropdown">
                        <li>
                            <a class="dropdown-item" href="?brand_id=">Alle Theme's</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        
                        <?php foreach ($themes as $theme) { ?>
                            <li class="px-3 py-1 d-flex justify-content-between align-items-center dropdown-item-container">
                                <a class="text-decoration-none text-dark flex-grow-1 py-1" href="?brand_id=<?= $theme->id ?>">
                                    <?= htmlspecialchars($theme->name) ?>
                                </a>
                                <a href="themeDelete.php?id=<?= $theme->id ?>" class="btn btn-verwijder btn-sm ms-auto">
                                    <i class="bi bi-trash"></i> Verwijder
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

                <div class="col">
                    <label for="stock" class="form-label">Voorraad</label>
                    <select name="stock" id="stock" class="form-select">
                        <option value="">Alles</option>
                        <option value="op" <?= (isset($_GET['stock']) && $_GET['stock'] == 'op') ? 'selected' : '' ?>>Op voorraad</option>
                        <option value="uit" <?= (isset($_GET['stock']) && $_GET['stock'] == 'uit') ? 'selected' : '' ?>>Uitverkocht</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-teal w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <?php if (count($sets) > 0): ?>
                <?php foreach ($sets as $set): ?>
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
                                <p class="mt-2">
                                    <span class="badge badge-teal"><?= $set->age ?>+ jaar</span>
                                    <span class="badge badge-soft"><?= $set->pieces ?> stukjes</span>
                                </p>
                                <h5 class="prijs">&euro;<?= number_format($set->price, 2) ?></h5>
                                <?php $badge = $set->stock > 0 ? 'badge-teal' : 'badge-muted'; ?>
                                <span class="badge <?= $badge ?>"><?= $set->stock > 0 ? 'Op voorraad (' . $set->stock . ')' : 'Uitverkocht' ?></span>

                                <div class="beheer-acties d-flex gap-2 mt-3 pt-3">
                                    <a href="../detail.php?id=<?= $set->id ?>" class="btn btn-teal-outline btn-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="setEdit.php?id=<?= $set->id ?>" class="btn btn-teal btn-sm">
                                        <i class="bi bi-pencil"></i> Aanpassen
                                    </a>
                                    <?php if ($isAdmin) { ?>
                                        <a href="setDelete.php?id=<?= $set->id ?>" class="btn btn-verwijder btn-sm ms-auto">
                                            <i class="bi bi-trash"></i> Verwijder
                                        </a>
                                    <?php } ?>
                                </div>
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

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 Speelhuys - Door Joop en Ans</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>