<?php
require 'config.php';
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("location:Sign-In.php");
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.jpg" />
</head>

<body>
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
                <a href="Sign-In.php" class="btn btn-primary rounded-pill py-2 px-4">Login</a>
                <a href="logout.php" class="btn btn-primary rounded-pill py-2 px-4 m-2">Logout</a>
            </div>
        </nav>
    </div>

    <!-- Contenu avec Card Bootstrap -->
    <div class="container py-2 d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded-4 "style="max-width: 600px;">
            <img src="uploads/<?= htmlspecialchars($activite['photo']); ?>" alt="photo" class="card-img-top rounded-top-4" style="height:300px;object-fit:cover;">
            <div class="card-body">
                <h3 class="card-title mb-3"><?= htmlspecialchars($activite['titre']); ?></h3>
                <p><?= date('d-m-Y', strtotime($activite['date_activite'])); ?></p>
                <p> <?= htmlspecialchars($activite['lieu']); ?></p>
                <p><?= htmlspecialchars($activite['description']); ?></p>
                <p></p>
                <p><?= htmlspecialchars($activite['nb_places_restantes']); ?>/<?= htmlspecialchars($activite['nb_places']); ?></p>

                <?php if($deja_inscrit): ?>
                    <form method="post">
                        <button type="submit" name="annuler" class="btn btn-warning w-80 rounded-pill mt-3 text-white">Annuler l'inscription</button>
                    </form>
                <?php elseif($activite['nb_places_restantes'] == 0): ?>
                    <button class="btn btn-danger w-100 rounded-pill mt-3" disabled>Complet</button>
                <?php else: ?>
                    <form method="post">
                        <button type="submit" name="inscrire" class="btn btn-success w-80 rounded-pill mt-3">S'inscrire</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up Message -->
<?php if (isset($message)): ?>
<div class="modal fade show" id="messageModal" tabindex="-1" 
     style="display:block;background:rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg"
             style="height: 250px; display: flex; justify-content: center; border-radius: 20px;">
             
            <div class="modal-body d-flex align-items-center justify-content-center 
                        <?= strpos($message, 'réussie') !== false ? 'bg-success' : 'bg-warning'; ?> text-white"
                 style="height: 100%; font-size: 2rem; text-align: center; border-radius: 20px;">
                 
                <p class="fs-1 fw-bold mb-0"><?= htmlspecialchars($message); ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('messageModal').style.display = 'none';
    }
    setTimeout(closeModal, 2000);
</script>
<?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
