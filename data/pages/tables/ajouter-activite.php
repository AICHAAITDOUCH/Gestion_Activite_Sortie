<?php
session_start();
require '../../../config.php'; // connexion PDO

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['id_utilisateur'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'id du créateur depuis la session
$id_createur = $_SESSION['id_utilisateur'];

// Si c’est l’admin (id = 0), on ne vérifie pas dans la table
if($id_createur != 0) {
    $stmt_check = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmt_check->execute([$id_createur]);
    $user = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
        die("⚠️ Erreur : L'utilisateur connecté n'existe pas dans la base !");
    }
}

// Gestion du formulaire
if(isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $lieu = $_POST['lieu'];
    $date_activite = $_POST['date_activite'];
    $description = $_POST['description'];
    $nb_places = $_POST['nb_places'];
    $nb_places_restantes = $nb_places;
if (!empty($_FILES['photo']['name'])) {
    $tmp_name = $_FILES['photo']['tmp_name'];
    $photo = time() . '_' . basename($_FILES['photo']['name']); // nom unique
    $upload_dir = '../../../uploads/'; 
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // créer si inexistant
    }
    if(!move_uploaded_file($tmp_name, $upload_dir . $photo)) {
        die("Erreur lors de l'upload de la photo !");
    }
} else {
    $photo = null;
}

    // 💾 Insertion dans la table activites
    $stmt = $pdo->prepare("
        INSERT INTO activites 
        (id_createur, titre, lieu, date_activite, description, nb_places, nb_places_restantes, photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$id_createur, $titre, $lieu, $date_activite, $description, $nb_places, $nb_places_restantes, $photo]);

    header("Location: sortiesAD.php"); 
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Activité</title>
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="../../../img/logo.jpg" />

    <style>
    label{
        color:#3cbeee ;
    }
</style>
</head>
<body style="background-color:#f2f6fc;">

<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4 ">Créer une nouvelle activité</h3>
            
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label  " >Titre:</label>
                    <input type="text" name="titre" class="form-control" >
                    </div>
                    <div class="col-md-6">
                    <label class="form-label ">Lieu:</label>
                    <input type="text" name="lieu" class="form-control" >
                </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label ">Date de l’activité:</label>
                    <input type="date" name="date_activite" class="form-control" >
                </div>
                    <div class="col-md-6">
                     <label class="form-label ">Nombre de places:</label>
                    <input type="number" name="nb_places" class="form-control" min="1" >
                </div>
                </div>
                <div class="row mb-3">
                   <label class="form-label ">Description:</label>
                   <textarea name="description" rows="4" class="form-control" ></textarea>
                </div>
                   <div class="row mb-3">
                    <label class="form-label ">Photo d'activité:</label>
                    <input type="file" name="photo" class="form-control" >
                </div>
                <button type="submit" name="submit" class="btn btn-primary text-white">Créer</button>
                <a href="mesActivite.php" class="btn btn-secondary">Annuler</a> </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
