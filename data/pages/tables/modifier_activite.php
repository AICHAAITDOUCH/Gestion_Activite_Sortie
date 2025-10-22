<?php
require '../../../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 🟢 نجيب المعلومات القديمة ديال النشاط
    $stmt = $pdo->prepare("SELECT * FROM activites WHERE id_activite = ?");
    $stmt->execute([$id]);
    $activite = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$activite) {
        die("Activité introuvable !");
    }
}

// 🟢 ملي المستخدم يرسل الفورم
if (isset($_POST['modifier'])) {
    $titre = $_POST['titre'];
    $lieu = $_POST['lieu'];
    $date_activite = $_POST['date_activite'];
    $description = $_POST['description'];
    $nb_places = $_POST['nb_places'];

    try {
        // 🔹 نعدل فـ table activites
        $stmt1 = $pdo->prepare("UPDATE activites 
                                SET titre = ?, lieu = ?, date_activite = ?, description = ?, nb_places = ? 
                                WHERE id_activite = ?");
        $stmt1->execute([$titre, $lieu, $date_activite, $description, $nb_places, $id]);

        // 🔹 نعدل فـ table activites_confirmees بنفس القيم (إلا كانت مسجلة)
        $stmt2 = $pdo->prepare("UPDATE activites_confirmees 
                                SET titre = ?, dateA = ?, description = ?
                                WHERE id_activite = ?");
        $stmt2->execute([$titre, $date_activite, $description,$id]);

        header("Location: table.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Activité</title>
    <link href="../../../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier l'activité</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Titre :</label>
            <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($activite['titre']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lieu :</label>
            <input type="text" name="lieu" class="form-control" value="<?= htmlspecialchars($activite['lieu']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date :</label>
            <input type="date" name="date_activite" class="form-control" value="<?= htmlspecialchars($activite['date_activite']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description :</label>
            <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($activite['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre de places :</label>
            <input type="number" name="nb_places" class="form-control" value="<?= htmlspecialchars($activite['nb_places']); ?>" required>
        </div>

        <button type="submit" name="modifier" class="btn btn-success">Enregistrer les modifications</button>
        <a href="table.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
