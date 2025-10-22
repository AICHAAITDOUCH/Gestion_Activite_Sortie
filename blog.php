
<?php
require 'config.php';
session_start();

// Date d'aujourd'hui
$today = date('Y-m-d');

// Récupérer les activités confirmées terminées
$stmt = $pdo->prepare("SELECT * FROM activites_confirmees WHERE dateA < ? ORDER BY dateA DESC");
$stmt->execute([$today]);
$activites_terminees = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        <!-- Google Web Fonts -->
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
        <link rel="shortcut icon" href="img/logo.jpg" />
        <style>
.star-rating {
  direction: rtl;
  display: inline-flex;
  gap: 5px;
}
.star-rating input {
  display: none;
}
.star-rating label {
  font-size: 35px;
  color: #ccc;
  cursor: pointer;
  transition: color 0.2s;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
  color: gold;
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
                    <h1 class="display-6 text-dark"><img src="img/logo.jpg" alt="">ADA</h1>
                 </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="blog.php" class="nav-item nav-link">Blog</a>
                                           
                    </div>
                    <a href="Sign-In.php" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Login</a>
                    <a href="logout.php" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0 m-2">Logout</a>
                </div>
            </nav>
        </div>
   
        <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="row g-4">
                   <h1 class="display-5 mb-4">Activités & Sorties</h1>


                    <?php if (count($activites_terminees) > 0): ?>
                        <?php foreach ($activites_terminees as $a): ?>
                            <div class="col-lg-4 wow fadeInUp">
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <img src="uploads/<?php echo htmlspecialchars($a['photo']); ?>" class="img-fluid w-100 rounded-top" alt="Image activité">
                                        <div class="blog-date">
                                            <i class="fas fa-clock me-2"></i>
                                            <?= htmlspecialchars($a['dateA']) ?>
                                        </div>
                                    </div>
                                    <div class="blog-content p-4">
                                        <a href="#" class="h4 d-inline-block mb-4">
                                            <?= htmlspecialchars($a['titre']) ?>
                                        </a>
                                        <p class="mb-4">
                                            <?= nl2br(htmlspecialchars($a['description'])) ?>
                                        </p>
                                    <button class="btn btn-primary rounded-pill py-2 px-4" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#commentModal<?= $a['id_activite'] ?>">
                                    Commentaire <i class="fas fa-comment ms-2"></i>
                                </button>

                                    </div>
                                </div>
                            </div>
                               <div class="modal fade" id="commentModal<?= $a['id_activite'] ?>" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="commantaire.php">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentModalLabel">Laisser un commentaire</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_activite" value="<?= $a['id_activite'] ?>">

                                <div class="mb-3">
                                    <label for="contenu" class="form-label">Votre commentaire :</label>
                                    <textarea name="contenu" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Votre note :</label><br>
                                    <div class="star-rating">
                                        <?php for($i = 5; $i >= 1; $i--): ?>
                                            <input type="radio" id="star<?= $i ?>_<?= $a['id_activite'] ?>" name="note" value="<?= $i ?>" required>
                                            <label for="star<?= $i ?>_<?= $a['id_activite'] ?>">⭐</label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center mt-4">
                            Aucune activité terminée pour le moment 
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Blog End -->
         <div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">

            <?php foreach ($commentaires as $c): ?>
            <div class="testimonial-item p-4">
                <!-- Contenu du commentaire -->
                <p class="text-white fs-4 mb-4">
                    <?= htmlspecialchars($c['contenu']) ?>
                </p>

                <div class="testimonial-inner">
                    <div class="testimonial-img">
                        <!-- Photo de l'utilisateur (photo par défaut si vide) -->
                        <img src="<?= !empty($c['photo_profil']) ? 'uploads/' . htmlspecialchars($c['photo_profil']) : 'img/default-user.jpg' ?>"
                             class="img-fluid" alt="Image utilisateur">
                    </div>

                    <div class="ms-4">
                        <!-- Nom de l'utilisateur -->
                        <h4 class="text-white"><?= htmlspecialchars($c['nom']) ?></h4>

                        <!-- Affichage des étoiles -->
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
                            <a href="blog.php"><i class="fas fa-angle-right me-2"></i> Blog</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <a href="blog.php" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>



