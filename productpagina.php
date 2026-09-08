<?php
include "classes/database.php";
include "classes/set.php";
include "classes/merk.php";
include "classes/theme.php";
$conn = Database::start();

// Haal alle merken , sets  en thema's op voor de filters
$brands = Brand::findAll();
$themes = Theme::findAll();
$sets = Set::findAll();

// sorteer op merk als er een brand_id is meegegeven
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

// sorteer op thema als er een set_theme is meegegeven
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

// Sorteer op aantal stukken
if (isset($_GET['sort_pieces']) && $_GET['sort_pieces'] != '') {
    usort($sets, function($a, $b) {
        if ($_GET['sort_pieces'] == 'asc') {
            return $a->pieces <=> $b->pieces;
        } else {
            return $b->pieces <=> $a->pieces;
        }
    });
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="home.php">Speel<span>huys</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="productpagina.php">Producten</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact_page.php">Contact</a></li>
                    
                </ul>
                <div class="ms-3">
                    <a href="admin/inlog.php" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Filters -->
    <div class="container mt-4">
        <div class="card p-4">
            <form method="GET" class="row g-3">
                <!-- merk Filter -->
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

                <!-- themas Filter -->
                <div class="col-md-4">
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

                <!-- stukjes Filter -->
                <div class="col-md-3">
                    <label for="sort_pieces" class="form-label">Aantal Stukken</label>
                    <select name="sort_pieces" id="sort_pieces" class="form-select">
                        <option value="">Geen sorteer</option>
                        <option value="asc" <?= (isset($_GET['sort_pieces']) && $_GET['sort_pieces'] == 'asc') ? 'selected' : '' ?>>Van klein naar groot</option>
                        <option value="desc" <?= (isset($_GET['sort_pieces']) && $_GET['sort_pieces'] == 'desc') ? 'selected' : '' ?>>Van groot naar klein</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                        <div class="card">
                            <img src="upload/sets/<?= htmlspecialchars($set->image) ?>" 
                                 class="card-img-top" 
                                 style="height:200px; object-fit:contain; padding:10px;"
                                 alt="<?= htmlspecialchars($set->name) ?>">
                            <div class="card-body">
                                <h5><?= htmlspecialchars($set->name) ?></h5>
                                <p class="text-muted small"><?php foreach ($brands as $brand) if ($brand->id == $set->brandId) echo htmlspecialchars($brand->name); ?></p>
                                <p><?= htmlspecialchars(substr($set->description, 0, 80)) ?>...</p>
                                 <a href="detailAdmin.php?id=<?= $set->id ?>"
                                    class="btn btn-primary mt-auto btn-outline-warning">Detail</a>
                                <p>
                                    <span class="badge bg-primary"><?= $set->age ?>+ jaar</span>
                                    <span class="badge bg-secondary"><?= $set->pieces ?> stukjes</span>
                                </p>
                                <h5 class="text-success">€<?= number_format($set->price, 2) ?></h5>
                                <?php $badge = $set->stock > 0 ? 'bg-success' : 'bg-danger'; ?>
                                <span class="badge <?= $badge ?>"><?= $set->stock > 0 ? 'Op voorraad' : 'Uitverkocht' ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><div class="alert alert-info">Geen producten gevonden. <a href="productpagina.php">Bekijk alle producten</a></div></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>