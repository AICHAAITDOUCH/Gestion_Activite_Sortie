<?php
session_start();
require '../../../config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    die("Utilisateur non connecté !");
}

$id_utilisateur = $_SESSION['id_utilisateur'];
if ($id_utilisateur == 0) {
    // Cas admin
    $user = [
        'nom' => 'Administrateur',
        'photo_profil' => 'team-2.jpg' // mettre le nom du fichier photo admin dans uploads
    ];
} else {
$stm = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
$stm->execute(['id' => $id_utilisateur]);
$user = $stm->fetch(PDO::FETCH_ASSOC);
}
// ✅ On récupère seulement les activités confirmées appartenant à cet utilisateur
$sql = "SELECT a.* 
        FROM activites a
        INNER JOIN activites_confirmees ac ON a.id_activite = ac.id_activite
        WHERE a.id_createur = :id_utilisateur
        ORDER BY a.date_activite DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_utilisateur' => $id_utilisateur]);
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daschbord </title>
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../../img/logo.jpg" />

</head>

<body>
  <div class="container-scroller">

    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="../../index-user.php" style="font-size:x-large;"><img src="../../../img/logo.jpg" class="mr-2" alt="logo"/>ADA</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
             <img src="../../../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="profile"/></a>


            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../../profileAD.php" >
                <i class="fa-solid fa-user text-primary"></i>
                Profile
              </a>
              <a class="dropdown-item" href="../connexion/logout.php">
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
            <a class="nav-link" href="../../index-user.php">
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
                <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.php">Liste Users</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/table.php">Mes activites</a></li>
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div style="display: flex; flex-direction:row; justify-content:space-between;  ">
                    <h1 class="card-title" style="color: #4B49AC; font-size:x-large; text-decoration:underline" >Liste D'activites</h1>
                    <a href="ajouter-activite.php" class="btn btn-primary btn-sm text-center"><i class="fa-solid fa-square-plus" style="color:white; padding-top:5px;"></i> </a>
                  </div>
                  
                    <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr class="text-center" >
                          <th>
                            Id
                          </th>
                          <th>
                            Titre
                          </th>
                          <th>
                            Lieu 
                          </th>
                          <th>
                            Date
                          </th>
                          <th>
                           Description
                          </th> 
                          <th>
                           Nombre de place
                          </th>
                           <th>
                           NbP restant 
                          </th>
                          <th>
                           Action
                          </th>
                        </tr>
                      </thead>
  <tbody>
<?php if (empty($activites)): ?>
  <tr>
    <td colspan="9" class="text-center">Aucune activité confirmée pour le moment.</td>
  </tr>
<?php else: ?>
  
  <?php 
    $i = 1;
    foreach ($activites as $a): ?>
    <tr class="text-center">
        <td><?= $i++; ?></td>
      <td><?= htmlspecialchars($a['titre']); ?></td>
      <td><?= htmlspecialchars($a['lieu']); ?></td>
      <td><?= htmlspecialchars($a['date_activite']); ?></td>
      <td><?= htmlspecialchars($a['description']); ?></td>
      <td><?= htmlspecialchars($a['nb_places']); ?></td>
      <td><?= htmlspecialchars($a['nb_places_restantes']); ?></td>
      <!-- <td>
        <img src="../../../uploads/<?= htmlspecialchars($a['photo'] ?? 'default.jpg'); ?>" width="100" alt="Image activité" >
      </td> -->
       <td>
      <!-- ✅ Bouton Modifier -->
      <a href="modifier_activite.php?id=<?= $a['id_activite']; ?>" 
         class="btn btn-warning btn-sm">
        <i class="fa-solid fa-pen-to-square" style="color: white;"></i>
      </a>

      <!-- ❌ Bouton Supprimer -->
      <a href="supprimer_activite.php?id=<?= $a['id_activite']; ?>" 
         class="btn btn-danger btn-sm"
         onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?');">
         <i class="fa-solid fa-trash" style="color: white;"></i>
      </a>
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
           
       <footer class="footer">
          <div class="d-sm-flex align-items-center justify-content-center">
            <span class="text-muted text-center text-sm-left">Copyright © 2025. ADA</span>
          </div>
        
        </footer> 
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
