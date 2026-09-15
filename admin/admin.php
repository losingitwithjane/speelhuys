<?php
include "../classes/database.php";
include "../classes/gebruiker.php";
include "../classes/sessie.php";
include "../classes/set.php";
include "../classes/merk.php";
include "../classes/theme.php";

$conn = Database::start();

$session = Sessie::findSession();

if ($session == null) {
    header("Location: inlog.php?message=Log eerst in.");
    exit;
}

$user = User::findById($session->session_user_id);

if ($user == null) {
    header("Location: inlog.php?message=Gebruiker niet gevonden.");
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
                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin.php">Beheer</a></li>
                </ul>
                <div class="ms-3">
                    <span class="badge badge-soft">
                        <i class="bi bi-person-circle"></i>
                        <?= htmlspecialchars($user->gebruikersnaam) ?> &middot; <?= htmlspecialchars($user->rol) ?>
                    </span>
                </div>
            </div>
        </div>
    </nav>

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
                <div class="col-md-4">
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
