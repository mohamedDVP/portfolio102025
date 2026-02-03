<?php
session_start();
require_once 'includes/db.php';

// Si l'utilisateur est déjà connecté, on le redirige vers l'admin
if (isset($_SESSION['user_id'])) {
    header("Location: admin.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Authentification via config.php
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];

    // On récupère les constantes définies dans includes/config.php (chargé via includes/db.php)
    if ($username_input === ADMIN_USER && password_verify($password_input, ADMIN_PASS_HASH)) {
        // Authentification réussie
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username_input;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/css/style.css">
    <title>Connexion Admin</title>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: var(--light-bg);">

    <div class="card p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Administration</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Identifiant</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="button-primary w-100">Se connecter</button>
        </form>
        <div class="mt-3 text-center">
            <a href="index.php">Retour au site</a>
        </div>
    </div>

</body>

</html>