<?php
session_start();
require_once 'includes/db.php';

// VÉRIFICATION DE SÉCURITÉ
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Suppression d'un message
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
    $stmt->execute(['id' => $id]);
    header("Location: admin_messages.php?msg=deleted");
    exit;
}

// Récupération des messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY date_creation DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/admin_header.php'; ?>

<div class="container">
    <h2 class="mb-4">Messages reçus</h2>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success">Message supprimé.</div>
    <?php endif; ?>

    <?php if (empty($messages)): ?>
        <div class="alert alert-info">Aucun message pour le moment.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($messages as $msg): ?>
                <div class="col-md-12 mb-3">
                    <div class="card p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="mb-1"><?php echo htmlspecialchars($msg['nom']); ?> <small class="text-muted">(<?php echo htmlspecialchars($msg['email']); ?>)</small></h5>
                            <small class="text-muted"><?php echo $msg['date_creation']; ?></small>
                        </div>
                        <p class="mt-2 mb-2"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        <div class="text-end">
                            <a href="admin_message_reply.php?id=<?php echo $msg['id']; ?>" class="btn btn-primary btn-sm">Ouvrir & Répondre</a>
                            <a href="admin_messages.php?delete=<?php echo $msg['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce message ?');">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>