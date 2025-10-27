<?php
session_start();
require '../../../config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    die("Utilisateur non connecté !");
}

$id_utilisateur = $_SESSION['id_utilisateur'];

// Récupération des infos utilisateur
$stm = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
$stm->execute(['id' => $id_utilisateur]);
$user = $stm->fetch(PDO::FETCH_ASSOC);

// ✅ Gestion de la recherche via navbar
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// ✅ Requête pour récupérer les activités selon l'utilisateur connecté
$sql = "SELECT * FROM activites WHERE id_createur = :id_utilisateur";

if ($search !== '') {
    $sql .= " AND titre LIKE :search";
}

$sql .= " ORDER BY date_activite DESC";

$stmt = $pdo->prepare($sql);
$params = ['id_utilisateur' => $id_utilisateur];
if ($search !== '') {
    $params['search'] = "%$search%";
}

$stmt->execute($params);
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../img/logo.jpg" />
</head>

<body>
<div class="container-scroller">
  <!-- Navbar -->
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-5" href="../../index-user.php" style="font-size:x-large;">
        <img src="../../../img/logo.jpg" class="mr-2" alt="logo"/>ADA
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </button>

      <!-- 🔍 Barre de recherche stylée -->
      <form method="GET" class="d-none d-lg-flex" style="margin-right:20px; margin-left:20px; position:relative;">
        <input 
          type="text" 
          class="form-control"  
          name="search"  
          id="navbar-search-input" 
          placeholder="Search par titre..."  
          value="<?= htmlspecialchars($search); ?>"
          style="border:none; background-color:#f1f1f1; padding-right:35px; border-radius:20px;"
        />
        <button 
          type="submit" 
          style="position:absolute; right:10px; top:50%; transform:translateY(-50%); border:none; background:none; color:#555; cursor:pointer;">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
           <img src="../../../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="profile"/>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="../../profile.php"><i class="fa-solid fa-user text-primary"></i> Profile</a>
            <a class="dropdown-item" href="../connexion/logout.php"><i class="ti-power-off text-primary"></i> Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="container-fluid page-body-wrapper">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item"><a class="nav-link" href="../../index-user.php"><i class="fa-solid fa-grip mr-4"></i>Dashboard</a></li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
            <i class="fa-solid fa-compass mr-4"></i>Liste
          </a>
          <div class="collapse" id="tables">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"><a class="nav-link" href="../../pages/tables/sorties.php">Mes Activites</a></li>
              <li class="nav-item"><a class="nav-link" href="../../pages/tables/table.php">Activité confirmé </a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item"><a class="nav-link" href="../../profile.php"><i class="fa-solid fa-user mr-4"></i>Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="../connexion/logout.php"><i class="ti-power-off mr-4"></i>Logout</a></li>
      </ul>
    </nav>

    <!-- Main Panel -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h3 class="text-primary">Liste D'activites</h3>

                <div class="table-responsive mt-3">
                  <table class="table table-striped">
                    <thead>
                      <tr class="text-center">
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Nb Places</th>
                        <th>Places Restantes</th>
                        <th>Photo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (count($activites) > 0): ?>
                       
                        <?php  $i=1;
                            foreach ($activites as $act): ?>
                          <tr class="text-center">
                            <td><?= $i++; ?></td>
                            <td><?= htmlspecialchars($act['titre']); ?></td>
                            <td><?= htmlspecialchars($act['lieu']); ?></td>
                            <td><?= htmlspecialchars($act['date_activite']); ?></td>
                            <td><?= htmlspecialchars($act['description']); ?></td>
                            <td><?= htmlspecialchars($act['nb_places']); ?></td>
                            <td><?= htmlspecialchars($act['nb_places_restantes']); ?></td>
                            <td>
                              <?php if (!empty($act['photo'])): ?>
                                <img src="../../../uploads/<?= htmlspecialchars($act['photo']); ?>" alt="photo" style="width:60px; height:60px; border-radius:10px; object-fit:cover;">
                              <?php else: ?>
                                <span>-</span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr><td colspan="8" class="text-center">Aucune activité trouvée</td></tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>

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

<script src="../../vendors/js/vendor.bundle.base.js"></script>
<script src="../../js/off-canvas.js"></script>
<script src="../../js/hoverable-collapse.js"></script>
<script src="../../js/template.js"></script>
<script src="../../js/settings.js"></script>
<script src="../../js/todolist.js"></script>

</body>
</html>
