<?php
require '../../../config.php';
session_start();

if (isset($_POST['confirmer'])) {
    $id_activite = $_POST['id_activite'];
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    // مثال: نحدث حالة النشاط أو نضيفه فـ جدول آخر (مثلاً "activites_confirmees")
    $stmt = $pdo->prepare("INSERT INTO activites_confirmees (id_activite, titre,dateA, description, photo) VALUES (?, ?, ?, ?,?)");
    $stmt->execute([$id_activite, $titre, $date,$description, $photo]);

    // بعد التأكيد نرجع المستخدم للصفحة الأصلية
    header("Location: basic-table.php?success=1");
    exit();
} else {
    // header("Location: Activite.php");
    exit();
}
?>
