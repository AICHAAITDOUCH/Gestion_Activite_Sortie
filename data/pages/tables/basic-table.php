<?php
session_start();
require '../../../config.php';

// Vérifie utilisateur connecté
if (!isset($_SESSION['id_utilisateur'])) {
    die("Utilisateur non connecté !");
}

$id_utilisateur = $_SESSION['id_utilisateur'];

// Récupération de l'utilisateur connecté
if ($id_utilisateur == 0) {
    $user = [
        'nom' => 'Administrateur',
        'photo_profil' => 'team-2.jpg'
    ];
} else {
    $stm = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
    $stm->execute(['id' => $id_utilisateur]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
}

// ✅ Gestion de la recherche
$search = "";
$where = "";
if (!empty($_GET['search'])) {
    $search = trim($_GET['search']);
    $where = "WHERE a.titre LIKE :search";
}

// ✅ Requête principale
$sql = "SELECT a.*, u.nom, u.photo_profil 
        FROM activites a
        JOIN utilisateurs u ON a.id_createur = u.id_utilisateur
        $where";
$stmt = $pdo->prepare($sql);

if ($where) {
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt->execute();
}
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Activités confirmées
$confirmedStmt = $pdo->query("SELECT id_activite FROM activites_confirmees");
$confirmed = $confirmedStmt->fetchAll(PDO::FETCH_COLUMN);
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
        <a class="navbar-brand brand-logo mr-5" href="../../index.php" style="font-size:x-large;">
          <img src="../../../img/logo.jpg" class="mr-2" alt="logo"/>ADA
        </a>
      </div>

      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>

        <!-- ✅ Barre de recherche stylisée -->
        <form method="GET" class="d-none d-lg-flex" style="margin-right:20px; margin-left:20px; position:relative;">
          <input type="text" 
                 class="form-control"  
                 name="search"  
                 id="navbar-search-input" 
                 placeholder="Search par titre..."  
                 value="<?= htmlspecialchars($search); ?>"
                 style="border:none; background-color:#f1f1f1; border-radius:20px; padding-right:40px;">
          <button type="submit" 
                  style="position:absolute; right:10px; top:50%; transform:translateY(-50%); border:none; background:none; color:#555; cursor:pointer;">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="../../../uploads/<?= htmlspecialchars($user['photo_profil']); ?>" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../../profileAD.php">
                <i class="fa-solid fa-user text-primary"></i> Profile
              </a>
              <a class="dropdown-item" href="../connexion/logout.php">
                <i class="ti-power-off text-primary"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Sidebar -->
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <i class="fa-solid fa-grip mr-4"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="fa-solid fa-compass mr-4"></i>
              <span class="menu-title">Liste</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <a class="nav-link" href="../../pages/tables/basic-table.php">Liste Users</a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="sortiesAD.php">Mes Activites</a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="mesActivite.php">Activité confirmé</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../profileAD.php">
              <i class="fa-solid fa-user mr-4"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../connexion/logout.php">
              <i class="ti-power-off mr-4"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>

      <!-- Main content -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h1 class="card-title" style="color:#4B49AC;text-decoration:underline;">Liste Users</h1>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center">
                          <th>User</th>
                          <th>Name</th>
                          <th>Titre</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (empty($activites)): ?>
                          <tr><td colspan="5" class="text-center text-muted">Aucune activité trouvée.</td></tr>
                        <?php else: ?>
                          <?php foreach($activites as $a): ?>
                          <tr class="text-center">
                            <td>
                              <img src="../../../uploads/<?= htmlspecialchars($a['photo_profil']); ?>" width="40" height="40" style="border-radius:50%;">
                            </td>
                            <td><?= htmlspecialchars($a['nom']); ?></td>
                            <td><?= htmlspecialchars($a['titre']); ?></td>
                            <td><?= htmlspecialchars($a['description']); ?></td>
                            <td>
                              <form action="confirmer_activite.php" method="POST">
                                <input type="hidden" name="id_activite" value="<?= $a['id_activite']; ?>">
                                <input type="hidden" name="titre" value="<?= htmlspecialchars($a['titre']); ?>">
                                <input type="hidden" name="date" value="<?= htmlspecialchars($a['date_activite']); ?>">
                                <input type="hidden" name="description" value="<?= htmlspecialchars($a['description']); ?>">
                                <input type="hidden" name="photo" value="<?= htmlspecialchars($a['photo']); ?>">
                                <button type="submit" 
                                  class="btn <?= in_array($a['id_activite'], $confirmed) ? 'btn-success' : 'btn-primary'; ?>" 
                                  id="confirmButton<?= $a['id_activite']; ?>" 
                                  name="confirmer"
                                  <?= in_array($a['id_activite'], $confirmed) ? 'disabled' : ''; ?>>
                                  <?= in_array($a['id_activite'], $confirmed) ? 'Confirmé' : 'Confirmer'; ?>
                                  <span style="margin-left:10px;"><i class="fa-solid fa-circle-check"></i></span>
                                </button>
                              </form>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Popup Succès -->
          <?php if(isset($_GET['success']) && isset($_GET['id'])): ?>
          <div class="modal fade show" id="successModal" tabindex="-1" aria-modal="true" role="dialog" style="display:block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius:20px; background-color:#d1e7dd;">
                <div class="modal-body text-center py-4">
                  <h4 class="text-success fw-bold">✅ Activité est confirmée</h4>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                  <button type="button" class="btn btn-success rounded-pill px-4" onclick="updateButton(<?= $_GET['id']; ?>)">OK</button>
                </div>
              </div>
            </div>
          </div>

          <script>
          function updateButton(id){
              const btn = document.getElementById('confirmButton' + id);
              if(btn){
                  btn.classList.remove('btn-primary');
                  btn.classList.add('btn-success');
                  btn.innerHTML = 'Confirmé <span style="margin-left:10px;"><i class="fa-solid fa-check"></i></span>';
                  btn.disabled = true;
              }
              document.getElementById('successModal').style.display = 'none';
          }
          </script>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>

  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/template.js"></script>
</body>
</html>
