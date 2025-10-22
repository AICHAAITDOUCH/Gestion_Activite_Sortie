<?php
require 'config.php';
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    die("Vous devez être connecté(e) pour accéder à cette page.");
}

$user_id = $_SESSION['id_utilisateur'];

if (!isset($_GET['id'])) {
    die("Activité introuvable.");
}

$id_activite = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM activites WHERE id_activite = ?");
$stmt->execute([$id_activite]);
$activite = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$activite) {
    die("Activité introuvable.");
}

$stmt2 = $pdo->prepare("SELECT COUNT(*) FROM inscriptions WHERE id_utilisateur = ? AND id_activite = ?");
$stmt2->execute([$user_id, $id_activite]);
$deja_inscrit = $stmt2->fetchColumn() > 0;

if (isset($_POST['inscrire']) && !$deja_inscrit && $activite['nb_places_restantes'] > 0) {

    $stmt3 = $pdo->prepare("INSERT INTO inscriptions (id_utilisateur, id_activite) VALUES (?, ?)");
    $stmt3->execute([$user_id, $id_activite]);

    // Diminuer 
    $stmt4 = $pdo->prepare("UPDATE activites 
                            SET nb_places_restantes = nb_places_restantes - 1 
                            WHERE id_activite = ? AND nb_places_restantes > 0");
    $stmt4->execute([$id_activite]);

    $message = "Inscription réussie !";
    $deja_inscrit = true;

    $stmt = $pdo->prepare("SELECT * FROM activites WHERE id_activite = ?");
    $stmt->execute([$id_activite]);
    $activite = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['annuler']) && $deja_inscrit) {

    $stmt5 = $pdo->prepare("DELETE FROM inscriptions WHERE id_utilisateur = ? AND id_activite = ?");
    $stmt5->execute([$user_id, $id_activite]);

    // Augmenter 
    $stmt6 = $pdo->prepare("UPDATE activites 
                            SET nb_places_restantes = nb_places_restantes + 1 
                            WHERE id_activite = ?");
    $stmt6->execute([$id_activite]);

    $message = "Inscription annulée !";
    $deja_inscrit = false;

    $stmt = $pdo->prepare("SELECT * FROM activites WHERE id_activite = ?");
    $stmt->execute([$id_activite]);
    $activite = $stmt->fetch(PDO::FETCH_ASSOC);
}

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
        <link rel="shortcut icon" href="img/logo.jpg" />

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

        
    <div class="col-md col-lg col-xl-12 text-center" >
                        
                <div class="container py-5">
                    <h2><?= htmlspecialchars($activite['titre']); ?></h2>
                    <p><strong>Date:</strong> <?= htmlspecialchars($activite['date_activite']); ?></p>
                    <p><strong>Lieu:</strong> <?= htmlspecialchars($activite['lieu']); ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($activite['description']); ?></p>
                    <p><strong>Nombre de places:</strong> <?= htmlspecialchars($activite['nb_places']); ?></p>
                    <p><strong>Places restantes:</strong> <?= htmlspecialchars($activite['nb_places_restantes']); ?></p>

                    <?php if(isset($message)) echo "<p style='color:green;'>$message</p>"; ?>

                    <?php if($deja_inscrit): ?>
    <form method="post">
        <button type="submit" name="annuler" class="btn btn-warning">Annuler l'inscription</button>
    </form>
<?php elseif($activite['nb_places_restantes'] == 0): ?>
    <button class="btn btn-danger" disabled>Complet</button>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="inscrire" class="btn btn-success">S'inscrire</button>
             </form>
              <?php endif; ?>

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