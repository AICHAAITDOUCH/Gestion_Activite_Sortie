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
        'photo_profil' => 'team-2.jpg' 
    ];
} else {
    $stm = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
    $stm->execute(['id' => $id_utilisateur]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daschbord </title>
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css">
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="shortcut icon" href="../img/logo.jpg" />
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.php" style="font-size:x-large;"><img src="../img/logo.jpg" class="mr-2" alt="logo"/>ADA</a>
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
    <img src="../uploads/<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="profile"/>
    </a>

            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="profileAD.php">
                <i class="fa-solid fa-user text-primary"></i>
                Profile
              </a>
              <a class="dropdown-item" href="pages/connexion/logout.php">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    </div>
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
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
                <li class="nav-item"> <a class="nav-link" href="pages/tables/mesActivite.php">Mes Activites</a></li>
              </ul>
            </div>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="profileAD.php">
              <i class="fa-solid fa-user mr-4"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>
             <li class="nav-item">
            <a class="nav-link" href="pages/connexion/logout.php">
                <i class="ti-power-off mr-4"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
     
        </ul>
      </nav>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h1 class="font-weight-bold">Welcome <span style="color:#4B49AC"><?php echo htmlspecialchars($user['nom']); ?></span></h1>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                 <h4 >Today: <span style="color:#4B49AC;"><?php echo date('d/m/Y');?></span></h4>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="images/dashboard/people.svg" alt="people">
              
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
  <script src="js/Chart.roundedBarCharts.js"></script>
</body>

</html>

