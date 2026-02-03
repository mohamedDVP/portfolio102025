<?php
session_start();
require_once 'includes/db.php';

// Sécurité
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_messages.php");
    exit;
}

$message_id = (int)$_GET['id'];
$message = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
$message->execute(['id' => $message_id]);
$msg = $message->fetch(PDO::FETCH_ASSOC);

if (!$msg) {
    die("Message introuvable.");
}

// Traitement de l'envoi de la réponse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reponse_contenu = htmlspecialchars($_POST['reponse']);

    if (!empty($reponse_contenu)) {
        // 1. Sauvegarder la réponse en BDD
        $stmt = $pdo->prepare("INSERT INTO reponses (message_id, contenu) VALUES (:msg_id, :contenu)");
        $stmt->execute([
            'msg_id' => $message_id,
            'contenu' => $reponse_contenu
        ]);

        // 2. Simulation de l'envoi d'email
        // mail($msg['email'], "Réponse à votre message", $reponse_contenu);

        $success = "Réponse enregistrée avec succès (Simulation d'email envoyée).";
    }
}

// Récupérer l'historique des réponses
$stmt_rep = $pdo->prepare("SELECT * FROM reponses WHERE message_id = :id ORDER BY date_reponse ASC");
$stmt_rep->execute(['id' => $message_id]);
$reponses = $stmt_rep->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include 'includes/admin_header.php'; ?>

<div class="container">
    <a href="admin_messages.php" class="btn btn-outline-secondary mb-3">&larr; Retour aux messages</a>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-4 mb-4">
                <h3>Message Original</h3>
                <hr>
                <p><strong>De :</strong> <?php echo htmlspecialchars($msg['nom']); ?> (<?php echo htmlspecialchars($msg['email']); ?>)</p>
                <p><strong>Date :</strong> <?php echo $msg['date_creation']; ?></p>
                <div class="bg-light p-3 rounded">
                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4">
                <h3>Répondre</h3>

                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Votre réponse :</label>
                        <textarea name="reponse" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="button-primary w-100">Envoyer la réponse</button>
                    <small class="text-muted d-block mt-2 text-center">* En local, l'email n'est pas réellement envoyé, mais la réponse est stockée.</small>
                </form>
            </div>
        </div>
    </div>

    <!-- Historique des réponses -->
    <?php if (count($reponses) > 0): ?>
        <div class="row mt-4">
            <div class="col-12">
                <h4 class="mb-3">Historique de la conversation</h4>
                <?php foreach ($reponses as $rep): ?>
                    <div class="card p-3 mb-2 border-primary" style="margin-left: 50px;">
                        <div class="d-flex justify-content-between">
                            <strong>Admin (Vous)</strong>
                            <small><?php echo $rep['date_reponse']; ?></small>
                        </div>
                        <p class="mt-2 mb-0"><?php echo nl2br(htmlspecialchars($rep['contenu'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>