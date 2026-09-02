<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Speelhuys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigatie -->
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
                    <li class="nav-item"><a class="nav-link active" href="Contact_page.php">Contact</a></li>
                </ul>
                <div class="ms-3">
                    <a href="login_page.php" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Inloggen
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Sectie Contact -->
    <section class="hero hero-contact">
        <div class="container text-center">
            <h1>Neem contact met ons op</h1>
            <p class="lead">We horen graag van je! 📞</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="container">
        <!-- Eerste rij: Contactgegevens -->
        <div class="row">
            <div class="col-md-12">
                <div class="contact-card text-center">
                    <h3>Onze <span>gegevens</span></h3>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="contact-info text-center">
                                <i class="bi bi-geo-alt contact-icon d-block"></i>
                                <p><strong>Adres</strong></p>
                                <p>Speelstraat 42<br>1234 AB Speelstad</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info text-center">
                                <i class="bi bi-telephone contact-icon d-block"></i>
                                <p><strong>Telefoon</strong></p>
                                <p>+31 6 12345678</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info text-center">
                                <i class="bi bi-envelope contact-icon d-block"></i>
                                <p><strong>E-mail</strong></p>
                                <p>info@speelhuys.nl</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info text-center">
                                <i class="bi bi-clock contact-icon d-block"></i>
                                <p><strong>Openingstijden</strong></p>
                                <p>Ma - Vr: 09:00 - 18:00<br>Za: 10:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leuke Foto 1 -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="contact-card">
                    <h3>Onze <span>winkel</span> 🏪</h3>
                    <img src="https://images.unsplash.com/photo-1558981403-c5f9896a7e15?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Onze winkel" 
                         class="fun-image">
                    <p class="mt-3 text-muted">
                        <i class="bi bi-emoji-smile text-warning"></i> 
                        Onze gezellige winkel in het hart van Speelstad. Kom gerust eens langs!
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-card">
                    <h3>Joop en Ans in <span>actie</span> 🎪</h3>
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Joop en Ans" 
                         class="fun-image">
                    <p class="mt-3 text-muted">
                        <i class="bi bi-emoji-laughing text-warning"></i> 
                        Joop en Ans tijdens het uitpakken van nieuwe voorraad! Altijd gezellig.
                    </p>
                </div>
            </div>
        </div>

        <!-- Leuke Foto 2 -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="contact-card text-center">
                    <h4>Onze <span>voorraad</span> 📦</h4>
                    <img src="https://images.unsplash.com/photo-1513828583688-c52646db42da?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Voorraad" 
                         class="fun-image-small">
                    <p class="mt-2 text-muted small">
                        <i class="bi bi-box-seam text-success"></i> 
                        Altijd vol met leuk speelgoed!
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card text-center">
                    <h4>Onze <span>klanten</span> 👨‍👩‍👧‍👦</h4>
                    <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Klanten" 
                         class="fun-image-small">
                    <p class="mt-2 text-muted small">
                        <i class="bi bi-people-fill text-primary"></i> 
                        Blije kinderen en tevreden ouders!
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card text-center">
                    <h4>Ons <span>team</span> 🤝</h4>
                    <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" 
                         alt="Team" 
                         class="fun-image-small">
                    <p class="mt-2 text-muted small">
                        <i class="bi bi-heart-fill text-danger"></i> 
                        Samen zorgen we voor de beste service!
                    </p>
                </div>
            </div>
        </div>

        <!-- Extra leuke tekst -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="contact-card text-center" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                    <h3 style="color: white;">✨ Kom langs voor een <span style="color: #ffd700;">glimlach</span>! ✨</h3>
                    <p class="lead" style="color: rgba(255,255,255,0.9);">
                        Of je nu komt voor speelgoed, advies of gewoon een praatje, 
                        we staan altijd voor je klaar! 
                        <i class="bi bi-emoji-heart-eyes"></i>
                    </p>
                    <div class="mt-3">
                        <a href="productpagina.php" class="btn btn-hero" style="background: white; color: #764ba2;">
                            <i class="bi bi-shop"></i> Bekijk onze producten
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2025 Speelhuys - Door Joop en Ans</p>
            <p class="mt-2" style="opacity: 0.6; font-size: 0.9rem;">
                <i class="bi bi-heart-fill text-danger"></i> 
                Met liefde gemaakt in Speelstad 
                <i class="bi bi-heart-fill text-danger"></i>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>