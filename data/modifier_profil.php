<?php
session_start();
require '../config.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: pages/connexion/login.php");
    exit();
}

$id_utilisateur = $_SESSION['id_utilisateur'];

if ($id_utilisateur == 0) {
    $user = [
        'nom' => 'Administrateur',
        'email' => 'admin@gmail.com',
        'photo_profil' => 'team-2.jpg'
    ];
} else {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
    $stmt->execute(['id' => $id_utilisateur]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $email = $_POST['email'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_name = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], '../uploads/' . $photo_name);
    } else {
        $photo_name = $user['photo_profil']; 
    }

    if ($id_utilisateur != 0) {
        $update = $pdo->prepare("UPDATE utilisateurs SET nom=:nom, email=:email, photo_profil=:photo WHERE id_utilisateur=:id");
        $update->execute([
            'nom' => $nom,
            'email' => $email,
            'photo' => $photo_name,
            'id' => $id_utilisateur
        ]);
    }

    header("Location: profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Modifier Profil</title>
<link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="vendors/feather/feather.css">
<link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
<link rel="stylesheet" href="css/vertical-layout-light/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo mr-5" href="index.php" style="font-size:x-large;">
                <img src="../img/logo.jpg" class="mr-2" alt="logo"/>ADA
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                        <img src="../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="profile"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="pages/connexion/logout.php">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                        <i class="icon-grid-2 menu-icon"></i>
                        <span class="menu-title">Liste</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="pages/tables/basic-table.php">Liste Users</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row justify-content-center">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card shadow-sm">
                              <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group text-center">
                                        <img src="../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" 
                                             class="rounded-circle mb-3" width="120" height="120" alt="Photo profil">
                                    </div>
                                    <div class="form-group">
                                        <label for="nom">Nom</label>
                                        <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo de profil (optionnel)</label>
                                        <input type="file" class="form-control-file" name="photo">
                                    </div>
                                   <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary" style="width: 150px; margin-right:10px;">
                                      <i class="fa-regular fa-pen-to-square"></i> Modifier
                                     </button>
                                     <a href="profile.php" class="btn btn-secondary" style="width: 150px;">Annuler</a>
                                   </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="d-sm-flex align-items-center justify-content-center">
                    <span class="text-muted text-center text-sm-left">Copyright © 2025. ADA</span>
                </div>
            </footer>
        </div>
    </div>
</div>

<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/datatables.net/jquery.dataTables.js"></script>
<script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="js/dataTables.select.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<script src="js/dashboard.js"></script>
</body>
</html>
