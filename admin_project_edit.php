<?php
session_start();
require_once 'includes/db.php';

// Sécurité
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
$stmt->execute(['id' => $id]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$projet) {
    die("Projet introuvable.");
}

// Traitement de la modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $lien = htmlspecialchars($_POST['lien']);

    // Par défaut, on garde l'ancienne image
    $image_path = $projet['image'];

    // Si une nouvelle image est uploadée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['image']['name'];
        $filesize = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if ($filesize < 5 * 1024 * 1024) {
                $new_filename = uniqid() . "." . $ext;
                $upload_dir = "Assets/images/projects/";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                    $image_path = $upload_dir . $new_filename;
                    // Optionnel : Supprimer l'ancienne image si elle existe et n'est pas une URL externe
                    if (file_exists($projet['image']) && $projet['image'] != $image_path) {
                        unlink($projet['image']);
                    }
                } else {
                    $error = "Erreur lors du téléchargement de l'image.";
                }
            } else {
                $error = "L'image est trop volumineuse (Max 5Mo).";
            }
        } else {
            $error = "Format de fichier non autorisé.";
        }
    }

    if (!isset($error)) {
        $stmt_update = $pdo->prepare("UPDATE projects SET titre = :titre, description = :description, image = :image, lien = :lien WHERE id = :id");
        $stmt_update->execute([
            'titre' => $titre,
            'description' => $description,
            'image' => $image_path,
            'lien' => $lien,
            'id' => $id
        ]);
        header("Location: admin.php?msg=updated");
        exit;
    }
}
?>

<?php include 'includes/admin_header.php'; ?>

<main class="container py-4">
    <a href="admin.php" class="btn btn-outline-secondary mb-3">&larr; Retour aux projets</a>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3>Modifier le projet</h3>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" name="titre" class="form-control" value="<?php echo htmlspecialchars($projet['titre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($projet['description']); ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Image actuelle</label>
                            <div class="border p-2 rounded text-center">
                                <img src="<?php echo htmlspecialchars($projet['image']); ?>" class="img-fluid" style="max-height: 100px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Changer d'image (optionnel)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Laisser vide pour conserver l'image actuelle.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lien du projet</label>
                        <input type="text" name="lien" class="form-control" value="<?php echo htmlspecialchars($projet['lien']); ?>" placeholder="#">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="admin.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="button-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>