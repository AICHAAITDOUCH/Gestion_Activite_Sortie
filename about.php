<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Application ADA</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/LOX.png" />

    </head>

    <body>

       <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="index.php" class="navbar-brand p-0">
                    <h1 class="display-6 text-dark"><img src="img/LOX.png" alt="">ADA</h1>
                 </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="blog.php" class="nav-item nav-link">Activites</a>
                                           
                    </div>
                    <a href="Sign-In.php" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Login</a>
                    <a href="logout.php" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0 m-2">Logout</a>
                </div>
            </nav>
        </div>

        <div class="container-fluid about pb-5">
            <div class="container pb-5">
                <div class="row g-5">
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div>
                            <h4 class="text-primary">About ADA</h4>
                            <h1 class="display-5 mb-4">Des moments inoubliables avec ADA</h1>
                            <p class="mb-5">ADA est une plateforme innovante dédiée à la découverte et au divertissement.
                                        Elle réunit les meilleures activités, sorties et expériences à vivre en famille, entre amis ou en groupe.
                                        Notre objectif est simple : offrir à chacun la possibilité de vivre des moments uniques, de découvrir de nouveaux lieux et de partager des instants de bonheur.
                                        Avec ADA, chaque sortie devient une aventure, chaque activité une nouvelle émotion !
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="position-relative rounded">
                            <div class="rounded" style="margin-top: 40px;">
                                <div class="row g-0">
                                    <div class="col-lg-12">
                                        <div class="rounded mb-4">
                                            <img src="img/impo.jpg" class="img-fluid rounded w-100" alt="">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="rounded bg-primary p-4 position-absolute d-flex justify-content-center" style="width: 90%; height: 80px; top: -40px; left: 50%; transform: translateX(-50%);">
                                <h3 class="mb-0 text-white">15 ans Experiance</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid gallery pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Notre Galerie</h4>
                    <h1 class="display-5 mb-4">Moments capturés avec ADA</h1>
                    <p class="mb-0">Plongez au cœur des instants magiques vécus avec ADA ! Chaque sourire, chaque regard et chaque aventure racontent une histoire unique. Ces moments immortalisés témoignent de la joie, du partage et de l’énergie positive que nous créons ensemble à travers nos activités et sorties.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="gallery-item">
                            <img src="img/bod.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/bod.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-1"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="gallery-item">
                            <img src="img/blog-2.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/blog-2.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-2"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="gallery-item">
                            <img src="img/ima.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/ima.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-3"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="gallery-item">
                            <img src="img/blog-3.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/blog-3.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-4"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="gallery-item">
                            <img src="img/gallery-5.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/gallery-5.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-5"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="gallery-item">
                            <img src="img/gallery-6.jpg" class="img-fluid rounded w-100 h-100" alt="">
                            <div class="search-icon">
                                <a href="img/gallery-6.jpg" class="btn btn-light btn-lg-square rounded-circle" data-lightbox="Gallery-6"><i class="fas fa-search-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="container-fluid team pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Rencontrez notre équipe</h4>
                    <h1 class="display-5 mb-4">Notre membre de l'équipe dédiée d'activite</h1>
                    <p class="mb-0">Notre équipe passionnée met tout son savoir-faire au service de vos moments de détente et de découverte.
                            Chaque membre s’engage à rendre vos activités plus agréables, organisées et inoubliables.
                            Avec ADA, vous êtes accompagnés par des professionnels qui partagent la même passion : créer des expériences uniques et authentiques.
                    </p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="team-item p-4">
                            <div class="team-content">
                                <div class="d-flex justify-content-between border-bottom pb-4">
                                    <div class="text-start">
                                        <h4 class="mb-0">Ali Jado</h4>
                                    </div>
                                    <div>
                                        <img src="img/team-1.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="team-icon rounded-pill my-4 p-3">
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <p class="text-center mb-0">Ali est un jeune passionné par l’organisation et l’animation.
                                     Toujours dynamique et souriant, il veille à ce que chaque activité se déroule dans la bonne humeur et la réussite.
                                     Grâce à son sens du détail, chaque événement devient une expérience inoubliable.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="team-item p-4">
                            <div class="team-content">
                                <div class="d-flex justify-content-between border-bottom pb-4">
                                    <div class="text-start">
                                        <h4 class="mb-0">Rayan Dani</h4>
                                    </div>
                                    <div>
                                        <img src="img/team-2.jpg" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="team-icon rounded-pill my-4 p-3">
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <p class="text-center mb-0">Rayan est la force tranquille de l’équipe ADA.
                                    Il s’assure que tout fonctionne parfaitement, du matériel aux installations techniques.
                                    Fiable et attentif, il est toujours prêt à résoudre les imprévus avec calme et efficacité.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
         <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-8">
                        <div class="footer-item">
                            <a href="index.html" class="p-0">
                                <h4 class="text-white mb-4">ADA</h4>
                               
                            </a>
                            <p class="mb-2">ADA est une plateforme qui propose les meilleures activités et sorties pour découvrir, s’amuser et partager des moments inoubliables.</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <p class="text-white mb-0">123 TAROUDANT </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <p class="text-white mb-0">ada@gmail.com</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-phone-alt text-primary me-3"></i>
                                <p class="text-white mb-0">+212 645657890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Liens</h4>
                            <a href="index.php"><i class="fas fa-angle-right me-2"></i> Home</a>
                            <a href="about.php"><i class="fas fa-angle-right me-2"></i> About</a>
                            <a href="blog.php"><i class="fas fa-angle-right me-2"></i> Activites</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <a href="about.php" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <script src="js/main.js"></script>
    </body>

</html>