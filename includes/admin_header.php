<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/css/style.css">
    <title>Administration Portfolio</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark mb-4 p-3">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand mb-0 h1">Admin Panel</span>
            <div>
                <span class="text-white me-3">Bienvenue, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
                <a href="index.php" class="btn btn-light btn-sm ms-2" target="_blank">Voir le site</a>
            </div>
        </div>
    </nav>