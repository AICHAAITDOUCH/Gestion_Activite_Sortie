<?php
require 'config.php';
session_start();
$isLoggedIn = isset($_SESSION['id_utilisateur']);
$user_id = $isLoggedIn ? $_SESSION['id_utilisateur'] : null;

if ($isLoggedIn) {
    $stmUser = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmUser->execute([$user_id]);
    $user = $stmUser->fetch(PDO::FETCH_ASSOC);
}

$sql = "SELECT * FROM activites_confirmees ORDER BY dateA DESC";
$stmt = $pdo->query($sql);
$activites_confirmees = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sq = $pdo->prepare("
    SELECT a.* 
    FROM activites a
    JOIN activites_confirmees ac ON a.id_activite = ac.id_activite
    WHERE a.id_createur = ?
");
$sq->execute([$user_id]);
$activites = $sq->fetchAll(PDO::FETCH_ASSOC);

$stm = $pdo->prepare("
    SELECT c.*, u.nom, u.photo_profil 
    FROM commentaires c
    JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
    ORDER BY c.date_commentaire DESC
    LIMIT 10
");
$stm->execute();
$commentaires = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
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
<style>
    .blog-item {
    height: 100%;          /* Prend toute la hauteur du parent */
    display: flex;
    flex-direction: column;
}

.blog-content {
    flex-grow: 1;          /* Prend l’espace restant pour égaliser la hauteur */
}
.blog-img img {
    width: 100%;          /* largeur pleine de la card */
    height: 200px;        /* fixe la hauteur */
    object-fit: cover;    /* garde le ratio et crop si nécessaire */
}

</style>
    </head>
    <body>
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
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
          <div class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <img src="img/bod.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="container align-items-center py-4">
                        <div class="row g-5 align-items-center">
                            <div class="col-xl-7 fadeInLeft animated" >
                                <div class="text-start">
                                    <h4 class="text-primary text-uppercase fw-bold mb-4">Bienvenue a ADA</h4>
                                    <h1 class="display-4 text-uppercase text-white mb-4">Découvrez les Meilleures Activités & Sorties</h1>
                                    <p class="mb-4 fs-5">Explorez une sélection des meilleures activités et sorties près de chez vous ! Profitez de moments inoubliables en famille, entre amis ou en solo. Loisirs, divertissements, événements et aventures vous attendent pour rendre chaque journée exceptionnelle.
                                    </p>
                                    <div class="d-flex flex-shrink-0">
                                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="Activite.php">Crée une activite</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
     <div class="container-fluid feature py-3">
            <div class="container py-3">
                
            </div>
        </div>
         <div class="container-fluid blog pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Notre Activite</h4>
                    <h1 class="display-5 mb-4">Dernières Activités & Sorties</h1>
                    <p class="mb-0">Découvrez nos toutes dernières aventures avec ADA ! Entre moments de détente, découvertes passionnantes et expériences inoubliables, chaque activité est une nouvelle occasion de partager, d’apprendre et de s’amuser ensemble. Rejoignez-nous pour vivre ces instants uniques !
                    </p>
                </div>
               
                <div class="row g-4">
<?php foreach($activites_confirmees as $index => $act): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="<?php echo 0.2 + ($index * 0.1); ?>s">
        <div class="blog-item">
            <div class="blog-img">
                <a href="#">
                    <img src="uploads/<?php echo htmlspecialchars($act['photo']); ?>" 
                         class="img-fluid w-100 rounded-top" alt="Image activité">
                </a>
                <div class="blog-date">
                    <i class="fas fa-clock me-2"></i>
                    <?php echo date('d M Y', strtotime($act['dateA'])); ?>
                </div>
            </div>
            <div class="blog-content p-4">
                <a href="#" class="h4 d-inline-block mb-4"><?php echo htmlspecialchars($act['titre']); ?></a>
                <p class="mb-4"><?php echo htmlspecialchars($act['description']); ?></p>
                <a href="read.php?id=<?= $act['id_activite'] ?>" class="btn btn-primary rounded-pill py-2 px-4">
                   Lire plus <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
</div>
</div>




        <div class="container-fluid about pb-4 pt-4">
            <div class="container pb-4">
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
       
        </div>
       <div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">

            <?php foreach ($commentaires as $c): ?>
            <div class="testimonial-item p-4">
                <p class="text-white fs-4 mb-4">
                    <?= htmlspecialchars($c['contenu']) ?>
                </p>

                <div class="testimonial-inner">
                    <div class="testimonial-img">
                        <img src="<?= !empty($c['photo_profil']) ? 'uploads/' . htmlspecialchars($c['photo_profil']) : 'img/default-user.jpg' ?>"
                             class="img-fluid" alt="Image utilisateur">
                    </div>

                    <div class="ms-4">
                        <h4 class="text-white"><?= htmlspecialchars($c['nom']) ?></h4>
                        <div class="d-flex text-primary">
                            <?php
                            $note = (int)$c['note'];
                            for ($i = 1; $i <= 5; $i++):
                                if ($i <= $note): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="fas fa-star text-white"></i>
                                <?php endif;
                            endfor;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

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

    <a href="index.php" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
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