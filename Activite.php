<?php
session_start();
require 'config.php'; // fichier de connexion à ta base (PDO)

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['id_utilisateur'])) {
    header("Location: Sign-In.php");
    exit();
}


if(isset($_POST['submit'])) {
    $id_createur = $_SESSION['id_utilisateur']; // ID du créateur connecté
    $titre = $_POST['titre'];
    $lieu = $_POST['lieu'];
    $date_activite = $_POST['date_activite'];
    $description = $_POST['description'];
    $nb_places = $_POST['nb_places'];
    $nb_places_restantes = $nb_places;
if (!empty($_FILES['photo']['name'])) {
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    move_uploaded_file($tmp_name, "uploads/".$photo);
} else {
    $photo = null;
}

    // Préparer l'insertion
    $stmt = $pdo->prepare("INSERT INTO activites (id_createur, titre, lieu, date_activite, description, nb_places, nb_places_restantes,photo) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
    
    $stmt->execute([$id_createur, $titre, $lieu, $date_activite, $description, $nb_places, $nb_places_restantes, $photo]);

    // Redirection après succès
    header("Location: data/index-user.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Activité</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="img/logo.jpg" />
<style>
    label{
        color:#3cbeee ;
    }
</style>
</head>
<body style="background-color:#f2f6fc;">

<div class="container mt-5">
    <div class="col-md-8 mx-auto">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4 ">Créer une nouvelle activité</h3>
            
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label fs-5 " >Titre:</label>
                    <input type="text" name="titre" class="form-control" >
                    </div>
                    <div class="col-md-6">
                    <label class="form-label fs-5">Lieu:</label>
                    <input type="text" name="lieu" class="form-control" >
                </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label fs-5">Date de l’activité:</label>
                    <input type="date" name="date_activite" class="form-control" >
                </div>
                    <div class="col-md-6">
                     <label class="form-label fs-5">Nombre de places:</label>
                    <input type="number" name="nb_places" class="form-control" min="1" >
                </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                   <label class="form-label fs-5">Description:</label>
                   <textarea name="description" rows="4" class="form-control" ></textarea>
                </div>
                  <div class="col-md-6 mt-5">
                    <label class="form-label fs-5">Photo d'activité:</label>
                    <input type="file" name="photo" class="form-control" >
                </div>
                </div>
                 <div class="d-flex flex-row justify-content-center align-items-center gap-5 mt-5">
                <button type="submit" name="submit" class="btn-sm btn-primary w-30 text-white">Créer</button>
                <button class="btn-sm btn-success w-30"><a href="index.php" style="text-decoration: none; color:snow">Annuler</a> </button>
                 </div>   
            </form>
        </div>
    </div>
</div>

</body>
</html>
