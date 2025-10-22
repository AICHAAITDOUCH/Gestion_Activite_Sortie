<?php 
session_start();
require '../config.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: pages/connexion/login.php");
    exit();
} 

$id_utilisateur = $_SESSION['id_utilisateur'];

// Récupération des données selon l'utilisateur
if ($id_utilisateur == 0) {
    $user = [
        'nom' => 'Administrateur',
        'email' => 'admin@gmail.com',
        'photo_profil' => 'team-2.jpg', // photo admin
        'role' => 'Admin'
    ];
} else {
    $stm = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
    $stm->execute(['id' => $id_utilisateur]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
    $user['role'] = 'Utilisateur';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daschbord</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../img/logo.jpg" />

  <style>
    .profile-card {
      background:#fff;
      border-radius:15px;
      padding:30px;
      text-align:center;
      max-width:600px;
      margin:30px auto;
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }
    .profile-card img {
      width:120px;
      height:120px;
      border-radius:50%;
      object-fit:cover;
      border:4px solid #4B49AC;
    }
    .profile-card h2 {
      margin-top:20px;
      color:#4B49AC;
      font-weight:bold;
    }
    .profile-card p {
      color:#555;
      font-size:16px;
      margin:5px 0;
    }
    .role-badge {
      font-size:14px;
      padding:5px 12px;
      border-radius:50px;
      background-color:#4B49AC;
      color:#fff;
      display:inline-block;
      margin-top:10px;
    }
    .edit-btn {
      margin-top:20px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- Navbar -->
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
      <!-- Sidebar -->
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
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.php">Liste Users</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="profile-card">
                <img src="../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="Photo de profil">
                <h2><?php echo htmlspecialchars($user['nom']); ?></h2>
                <p><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <span class="role-badge"><?php echo htmlspecialchars($user['role']); ?></span>
                <div class="edit-btn">
                  <a href="modifier_profil.php" class="btn btn-primary">
                    <i class="fa-regular fa-pen-to-square"></i> Modifier le profil
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
          <div class="d-sm-flex align-items-center justify-content-center">
            <span class="text-muted text-center text-sm-left">Copyright © 2025. ADA</span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- JS -->
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
