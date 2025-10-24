<?php
require 'config.php';
session_start();

$today = date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM activites_confirmees WHERE dateA < ? ORDER BY dateA DESC");
$stmt->execute([$today]);
$activites_terminees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$commentsStmt = $pdo->prepare("
    SELECT c.*, u.nom, u.photo_profil 
    FROM commentaires c
    JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
    WHERE c.id_activite = ?
    ORDER BY c.date_commentaire DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
        <title>Application ADA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/logo.jpg" />

    <style>
        .star-rating {
            direction: rtl;
            display: inline-flex;
            gap: 5px;
        }
        .star-rating input { display: none; }
        .star-rating label {
            font-size: 25px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: gold; }

        .comment-item { border-top: 1px solid #eee; padding-top: 10px; margin-top: 10px; }
        .comment-user-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
    </style>
</head>

<body>

<div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a href="index.php" class="navbar-brand p-0">
            <h1 class="display-6 text-dark"><img src="img/logo.jpg" alt="">ADA</h1>
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
<div class="container-fluid blog py-5">
    <div class="container py-5">
        <div class="row g-4">
            <h1 class="display-5 mb-4">Activités & Sorties</h1>

            <?php if(count($activites_terminees) > 0): ?>
                <?php foreach($activites_terminees as $a): ?>
                    <div class="col-lg-4">
                        <div class="blog-item border rounded shadow-sm overflow-hidden">
                            <div class="blog-img position-relative">
                                <img src="uploads/<?= htmlspecialchars($a['photo']); ?>" class="img-fluid w-100 rounded-top" alt="Image activité">
                                <div class="blog-date ">
                                    <i class="fas fa-clock me-2"></i>
                                    <?= date('d-m-Y', strtotime($a['dateA'])) ?>
                                </div>
                            </div>
                            <div class="blog-content p-4">
                                <a href="#" class="h4 d-inline-block mb-3 text-dark"><?= htmlspecialchars($a['titre']) ?></a>
                                <p class="mb-3 text-muted"><?= nl2br(htmlspecialchars($a['description'])) ?></p>

                                <?php 
                                $commentsStmt->execute([$a['id_activite']]);
                                $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
                                if(count($comments) > 0): 
                                ?>
                                    <h6 class="text-primary">Commentaires :</h6>
                                    <?php foreach($comments as $c): ?>
                                        <div class="comment-item d-flex align-items-start">
                                            <img src="<?= !empty($c['photo_profil']) ? 'uploads/'.htmlspecialchars($c['photo_profil']) : 'img/default-user.jpg' ?>" class="comment-user-img me-3" alt="Photo utilisateur">
                                            <div>
                                                <strong><?= htmlspecialchars($c['nom']) ?></strong>
                                                <div class="d-flex text-primary">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <?php if($i <= (int)$c['note']): ?>
                                                            <i class="fas fa-star "></i>
                                                        <?php else: ?>
                                                            <i class="far fa-star"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                                <p class="mb-0"><?= nl2br(htmlspecialchars($c['contenu'])) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <button class="btn btn-primary rounded-pill py-2 px-4 mt-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#commentModal<?= $a['id_activite'] ?>">
                                     commentaire <i class="fas fa-comment ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="commentModal<?= $a['id_activite'] ?>" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-4 shadow">
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
                                            <div class="star-rating  text-primary">
                                                <?php for($i=5; $i>=1; $i--): ?>
                                                    <input type="radio" id="star<?= $i ?>_<?= $a['id_activite'] ?>" name="note" value="<?= $i ?>" required>
                                                    <label for="star<?= $i ?>_<?= $a['id_activite'] ?>"><i class="fas fa-star "></i></label>
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
                <div class="alert alert-info text-center mt-4">Aucune activité terminée pour le moment</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Footer -->
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

<a href="blog.php" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
