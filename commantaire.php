<?php
require 'config.php';
session_start();

if(!isset($_SESSION['id_utilisateur'])){
    die("Veuillez vous connecter pour commenter.");
}

if(isset($_POST['id_activite'], $_POST['contenu'], $_POST['note'])){
    $id_utilisateur = $_SESSION['id_utilisateur'];
    $id_activite = $_POST['id_activite'];
    $contenu = trim($_POST['contenu']);
    $note = (int)$_POST['note'];
    $date = date('Y-m-d H:i:s');

    if(!empty($contenu) && $note > 0){
        $stmt = $pdo->prepare("INSERT INTO commentaires (id_utilisateur, id_activite, contenu, note, date_commentaire)
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_utilisateur, $id_activite, $contenu, $note, $date]);
    }
}

header("Location: blog.php");
exit;
?>
