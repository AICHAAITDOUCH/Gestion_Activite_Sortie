<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link href="css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
  

         <form action="" method="post" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class=" rounded p-4 p-sm-5 my-4 mx-3" style="background-color:#6D94C5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            
                            <h3 class="text-white " style="font-size:xx-large;">Sign In</h3>
                        </div>
                         <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="Name" placeholder="Votre Name" name="name">
                            <label for="Name">Name</label>
                        </div>
                       
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        
                          <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="file" name="photo">
                            <label for="file">Photo de Prpfil</label>
                        </div>
                       
                        <button type="submit" name="submit" style="font-size:larger;"class="btn btn-primary py-3 w-100 mb-4 text-white ">Login</button>
                        <p class="text-center mb-0 text-white ">Do you have an Account? <a href="Sign-In.php" style="color:#F5EFE6; font-size:medium;">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>

<?php 

session_start();
require 'config.php';

if(isset($_POST['submit'])){
    $nom = $_POST['name'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];
    $photo = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];

move_uploaded_file($tmp_name, "uploads/".$photo);

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0){
        echo "Cet email est déjà utilisé.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, photo_profil	) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $email, $mot_de_passe, $photo]);
       header("location:Sign-In.php");

    }
}
?>
