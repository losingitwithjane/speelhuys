<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
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
                    <li class="nav-item"><a class="nav-link" href="Contact_page.php">Contact</a></li>
                </ul>
                <div class="ms-3">
                    <a href="inlog.php" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container text-center">
            <h1>Welkom bij Speelhuys</h1>
            <p class="lead">De leukste speelgoedwinkel van Nederland</p>
            <a href="productpagina.php" class="btn btn-hero">
                <i class="bi bi-shop"></i> Bekijk ons assortiment
            </a>
        </div>
    </section>

    <section class="container">
        <div class="about">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Over <span>Joop en Ans</span></h2>
                    <p>
                        <i class="bi bi-heart-fill text-danger"></i> 
                        Wij zijn Joop en Ans Jansen, de trotse eigenaren van Speelhuys. 
                        Sinds 2005 runnen we met veel plezier deze speelgoedwinkel.
                    </p>
                    <p>
                        <i class="bi bi-stars text-warning"></i> 
                        Onze passie voor kwalitatief speelgoed begon toen onze eigen 
                        kinderen klein waren. Nu delen we die passie graag met andere families.
                    </p>
                    <p>
                        <i class="bi bi-trophy text-success"></i> 
                        Bij Speelhuys vind je alleen het beste speelgoed: van Lego en Duplo 
                        tot educatieve spellen en puzzels.
                    </p>
                    <p class="fst-italic text-primary">
                        <i class="bi bi-quote"></i> 
                        "Ieder kind verdient kwaliteitsspeelgoed om mee te spelen, 
                        leren en groeien."
                    </p>
                    <div class="mt-4">
                        <a href="productpagina.php" class="btn btn-producten">
                            <i class="bi bi-box-seam"></i> Ontdek onze producten
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1472289065668-ce650ac443d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Joop en Ans" 
                         class="img-fluid about-image">
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 Speelhuys - Door Joop en Ans</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>