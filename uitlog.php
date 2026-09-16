<?php
include "classes/database.php";
include "classes/sessie.php";

$sessie = Sessie::findSession();

if ($sessie != null) {
    $sessie->delete(); // haalt de sessie uit de database
}

setcookie('speelhuys-session', '', time() - 3600, '/'); // laat de cookie verlopen

header("Location: index.php");
exit;
