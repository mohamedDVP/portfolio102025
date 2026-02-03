<?php
session_start();
require_once 'includes/db.php';

// VÉRIFICATION DE SÉCURITÉ
// Si l'utilisateur n'est pas connecté, ouste !
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Traitement de la suppression
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: admin.php?msg=deleted");
    exit;
}

// Traitement de l'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $lien = htmlspecialchars($_POST['lien']);
    
    $image_path = "";

    // Gestion de l'upload d'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];
        $filesize = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // Limite de taille (ex: 5Mo)
            if ($filesize < 5 * 1024 * 1024) {
                $new_filename = uniqid() . "." . $ext;
                $upload_dir = "Assets/images/projects/";
                
                // Créer le dossier s'il n'existe pas
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
                    $image_path = $upload_dir . $new_filename;
                } else {
                    $error = "Erreur lors du téléchargement de l'image.";
                }
            } else {
                $error = "L'image est trop volumineuse (Max 5Mo).";
            }
        } else {
            $error = "Format de fichier non autorisé. (JPG, PNG, WEBP, GIF)";
        }
    } else {
        $error = "Veuillez sélectionner une image.";
    }

    if (!empty($titre) && !empty($description) && !empty($image_path)) {
        $stmt = $pdo->prepare("INSERT INTO projects (titre, description, image, lien) VALUES (:titre, :description, :image, :lien)");
        $stmt->execute([
            'titre' => $titre,
            'description' => $description,
            'image' => $image_path,
            'lien' => $lien
        ]);
        header("Location: admin.php?msg=added");
        exit;
    }
}

// Récupération des projets
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/admin_header.php'; ?>

<main class="container py-4">

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['msg'] == 'deleted') echo "Projet supprimé avec succès.";
            if ($_GET['msg'] == 'added') echo "Projet ajouté avec succès.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire d'ajout -->
        <div class="col-md-4">
            <div class="card p-4 mb-4">
                <h3>Ajouter un projet</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" name="titre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image du projet</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">JPG, PNG, WEBP, GIF (Max 5Mo)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lien du projet</label>
                        <input type="text" name="lien" class="form-control" placeholder="#">
                    </div>
                    <button type="submit" class="button-primary w-100">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste des projets -->
        <div class="col-md-8">
            <div class="card p-4">
                <h3>Projets existants</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projets as $projet): ?>
                                <tr>
                                    <td><img src="<?php echo $projet['image']; ?>" style="height: 50px; width: 50px; object-fit: cover; border-radius: 4px;"></td>
                                    <td><?php echo $projet['titre']; ?></td>
                                    <td>
                                        <a href="admin.php?delete=<?php echo $projet['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>