<?php
include __DIR__ . '/../classes/database.php';
include __DIR__ . '/../classes/sessie.php';
include __DIR__ . '/../classes/gebruiker.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$gebruiker = User::findByCredentials($username, $password);
if ($username !== '' && $password !== '') {
    if ($gebruiker === null) 
    {
        echo 'Error: Ongeldige inlog gegevens';
    } 
    else 
    {
        $key = md5(uniqid(rand(), true));
        $session = new Sessie();
        $session->session_user_id = $gebruiker->id;
        $session->session_key = $key;
        $session->session_start = date('Y-m-d H:i:s');
        $session->session_end = date('Y-m-d H:i:s', strtotime('+1 month'));
        $session->insert();
        setcookie('speelhuys-session', $key, strtotime('+1 month'), '/');
        header('Location: admin.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Speelhuys Inlog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="site-header">
        <div class="header-inner">
            <a class="brand-name" href="#">Speelhuys</a>
        </div>
    </nav>

    <main class="centerlogin">
        <h1 class="colortext">Speelhuys Inlog</h1>
        <form name="form1" method="post">
            <input type="text" name="username" placeholder="Username" value="" size="35" class="textbox" /><br>
            <input type="password" name="password" placeholder="Password" value="" size="35" class="textbox" /><br>
            <input type="submit" value="Inloggen" class="button" />
            <div class="button a"> <a href="index.php">Terug</a> </div>
        </form>
    </main>

    <footer class="footer mt-5 admin-footer">
        <div class="container">
            <div class="footer-content">

            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

<div class="errortext">