<?php
session_start();
require '../../../config.php';

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];

    // 🔹 التحقق من admin
    if ($email === "admin@gmail.com" && $mot_de_passe === "admin123") {
        $_SESSION['id_utilisateur'] = 2; // juste pour indiquer que c’est l’admin
        $_SESSION['nom'] = "Administrateur";

        header("Location:../../index.php");
        exit();
    }

    // 🔹 التحقق من المستخدم العادي
    // 🔹 Vérifier admin
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ? AND mot_de_passe = ?");
$stmt->execute([$email, $mot_de_passe]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION['id_utilisateur'] = $user['id_utilisateur']; // l’ID réel
    $_SESSION['nom'] = $user['nom'];
    $_SESSION['email'] = $user['email'];

    if ($user['email'] === "admin@gmail.com") {
        header("Location: ../../index.php"); // page admin
    } else {
        header("Location: ../../index-user.php"); // page utilisateur normal
    }
    exit();
} else {
    $_SESSION['error'] = "Email ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>LogIn</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../img/logo.jpg" />

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
          
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="" method="post">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button type="submit" name="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" >SIGN IN</button>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
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
</body>

</html>
