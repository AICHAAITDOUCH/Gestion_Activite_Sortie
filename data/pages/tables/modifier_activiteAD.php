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
        // 🔹 نحسب nb_places_restantes الجديدة
        // إذا بغيت تكون مساوية تماماً لـ nb_places، استعمل هاد السطر
        $nb_places_restantes = $nb_places;

        // 🔹 نعدل فـ table activites
        $stmt1 = $pdo->prepare("UPDATE activites 
                                SET titre = ?, lieu = ?, date_activite = ?, description = ?, 
                                    nb_places = ?, nb_places_restantes = ?
                                WHERE id_activite = ?");
        $stmt1->execute([$titre, $lieu, $date_activite, $description, $nb_places, $nb_places_restantes, $id]);

        // 🔹 نعدل فـ table activites_confirmees بنفس القيم (إلا كانت مسجلة)
        $stmt2 = $pdo->prepare("UPDATE activites_confirmees 
                                SET titre = ?, dateA = ?, description = ?
                                WHERE id_activite = ?");
        $stmt2->execute([$titre, $date_activite, $description, $id]);

        header("Location: mesActivite.php");
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
    <link rel="shortcut icon" href="../../../img/logo.jpg" />
 <style>
    label{
        color:#3cbeee ;
    }</style>
</head>
<body style="background-color:#f2f6fc;">
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow p-4">
            <h2 class="text-center">Modifier l'activité</h2>
            <form method="post">
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label">Titre :</label>
                    <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($activite['titre']); ?>" >
                </div>
                    <div class="col-md-6">
                    <label class="form-label">Lieu :</label>
                    <input type="text" name="lieu" class="form-control" value="<?= htmlspecialchars($activite['lieu']); ?>" >
                </div>
                </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                    <label class="form-label">Date :</label>
                    <input type="date" name="date_activite" class="form-control" value="<?= htmlspecialchars($activite['date_activite']); ?>" >
                </div>
                    <div class="col-md-6">
                    <label class="form-label">Nombre de places :</label>
                    <input type="number" name="nb_places" class="form-control" value="<?= htmlspecialchars($activite['nb_places']); ?>" >
                </div>
                  </div>
                <div class="mb-3">
                    <label class="form-label">Description :</label>
                    <textarea name="description" class="form-control" rows="3" ><?= htmlspecialchars($activite['description']); ?></textarea>
                </div>
                    <button type="submit" name="modifier" class="btn btn-success  ">Enregistrer</button>
                    <a href="mesActivite.php" class="btn btn-secondary ">Annuler</a>
                
            </form>
        </div>
        </div>
        </div>
</body>
</html>
