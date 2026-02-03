<?php include 'includes/header.php'; ?>
<?php include 'includes/data.php'; ?>
<main>
    <div class="container-fluid">
        <h1>Mon Portfolio</h1>
        <p>Découvrez mes réalisations.</p>

        <div class="row">
            <?php foreach ($projets as $projet): ?>
                <div class="col-md-4">
                    <div class="card" style="min-height: 400px;">
                        <img src="<?php echo $projet['image']; ?>" alt="<?php echo $projet['titre']; ?>" class="img-fluid mb-3" style="border-radius: 5px;">
                        <h3><?php echo $projet['titre']; ?></h3>
                        <p><?php echo $projet['description']; ?></p>
                        <div style="margin-top: auto;">
                            <a href="<?php echo $projet['lien']; ?>" class="button-primary">Voir le projet</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>