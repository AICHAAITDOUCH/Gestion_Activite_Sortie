<?php
require '../../../config.php';
session_start();

if(isset($_POST['confirmer'])){
    $id_activite = $_POST['id_activite'];
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    // Vérifier si activité est déjà confirmée
    $check = $pdo->prepare("SELECT * FROM activites_confirmees WHERE id_activite = ?");
    $check->execute([$id_activite]);
    if($check->rowCount() == 0){
        $stmt = $pdo->prepare("INSERT INTO activites_confirmees (id_activite, titre, dateA, description, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_activite, $titre, $date, $description, $photo]);
    }

    header("Location: basic-table.php?success=1&id=".$id_activite);
    exit();
}
?>
