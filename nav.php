<?php
// Gedeelde navigatie voor alle paginas.
// Zet $actievePagina ("home", "producten", "contact" of "werkplek") voor het includen van dit bestand.
// Zet $navPrefix op "../" als de pagina in een submap staat (bijvoorbeeld admin/).

include_once __DIR__ . "/classes/database.php";
include_once __DIR__ . "/classes/sessie.php";
include_once __DIR__ . "/classes/gebruiker.php";

$navSessie = Sessie::findSession();
$navUser = $navSessie != null ? User::findById($navSessie->session_user_id) : null;
$navMedewerker = $navUser != null && ($navUser->rol == "admin" || $navUser->rol == "employee");

if (!isset($actievePagina)) {
    $actievePagina = "";
}
if (!isset($navPrefix)) {
    $navPrefix = "";
}
?>
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
        <a class="navbar-brand" href="<?= $navPrefix ?>index.php">Speel<span>huys</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $actievePagina == "home" ? "active" : "" ?>" href="<?= $navPrefix ?>index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $actievePagina == "producten" ? "active" : "" ?>" href="<?= $navPrefix ?>productpagina.php">Producten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $actievePagina == "contact" ? "active" : "" ?>" href="<?= $navPrefix ?>contact.php">Contact</a>
                </li>
            </ul>
            <div class="ms-3">
                <?php if ($navUser == null) { ?>
                    <a href="<?= $navPrefix ?>admin/inlog.php" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                <?php } else { ?>
                    <div class="dropdown">
                        <button class="btn btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($navUser->voornaam) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-header">
                                    <?= htmlspecialchars($navUser->gebruikersnaam) ?> &middot; <?= htmlspecialchars($navUser->rol) ?>
                                </span>
                            </li>
                            <?php if ($navMedewerker) { ?>
                                <li>
                                    <a class="dropdown-item <?= $actievePagina == "werkplek" ? "active" : "" ?>" href="<?= $navPrefix ?>admin/admin.php">
                                        <i class="bi bi-clipboard-check"></i> Werkplek
                                    </a>
                                </li>
                            <?php } ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= $navPrefix ?>uitlog.php">
                                    <i class="bi bi-box-arrow-right"></i> Uitloggen
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
