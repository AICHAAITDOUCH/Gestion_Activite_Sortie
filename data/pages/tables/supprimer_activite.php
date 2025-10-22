<?php
require '../../../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 🧹 نحيد أولا من table dyal activites_confirmees
        $stmt1 = $pdo->prepare("DELETE FROM activites_confirmees WHERE id_activite = ?");
        $stmt1->execute([$id]);

        // 🗑 نحيد النشاط من table activites
        $stmt2 = $pdo->prepare("DELETE FROM activites WHERE id_activite = ?");
        $stmt2->execute([$id]);

        // ✅ من بعد نحولو للمكان الرئيسي
        header("Location: table.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    echo "Aucune activité sélectionnée.";
}
?>
