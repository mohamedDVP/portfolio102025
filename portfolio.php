<?php include 'includes/header.php'; ?>
<?php include 'includes/data.php'; ?>
<main>
    <div class="container-fluid">
        <h1>Mon Portfolio</h1>
        <p>Découvrez mes réalisations.</p>

        <div class="row">
            <?php foreach ($projets as $projet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $projet['image']; ?>" alt="<?php echo $projet['titre']; ?>">
                        <h3><?php echo $projet['titre']; ?></h3>
                        <p><?php echo $projet['description']; ?></p>
                        <div class="card-footer-custom">
                            <a href="<?php echo $projet['lien']; ?>" class="button-primary">Voir le projet</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>