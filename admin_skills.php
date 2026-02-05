<?php
session_start();
require_once 'includes/db.php';

// Sécurité
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Suppression
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: admin_skills.php?msg=deleted");
    exit;
}

// Ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $level = (int)$_POST['level'];

    if (!empty($name) && $level >= 0 && $level <= 100) {
        $stmt = $pdo->prepare("INSERT INTO skills (name, level) VALUES (:name, :level)");
        $stmt->execute(['name' => $name, 'level' => $level]);
        header("Location: admin_skills.php?msg=added");
        exit;
    }
}

// Récupération
$stmt = $pdo->query("SELECT * FROM skills ORDER BY level DESC");
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/admin_header.php'; ?>

<main class="container py-4">
    <h2 class="mb-4">Gérer mes compétences</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php
            if ($_GET['msg'] == 'deleted') echo "Compétence supprimée.";
            if ($_GET['msg'] == 'added') echo "Compétence ajoutée.";
            ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire Ajout -->
        <div class="col-md-4">
            <div class="card p-4 mb-4">
                <h3>Nouvelle compétence</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nom (ex: PHP)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Niveau (0-100%)</label>
                        <input type="range" name="level" class="form-range" min="0" max="100" step="5" oninput="this.nextElementSibling.value = this.value">
                        <output>50</output>%
                    </div>
                    <button type="submit" class="button-primary w-100">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Liste -->
        <div class="col-md-8">
            <div class="card p-4">
                <h3>Mes compétences</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Compétence</th>
                            <th>Niveau</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $skill): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($skill['name']); ?></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $skill['level']; ?>%;">
                                            <?php echo $skill['level']; ?>%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="admin_skills.php?delete=<?php echo $skill['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?');">X</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>