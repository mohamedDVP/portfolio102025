<?php include 'includes/header.php'; ?>
<?php include 'includes/data.php'; ?>
<main>
    <div class="container-fluid">
        <h1>À propos de moi</h1>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card p-4">
                    <h2>Bonjour, je suis <?php echo $infos_perso['nom']; ?></h2>
                    <h3 class="text-muted"><?php echo $infos_perso['poste']; ?></h3>
                    <hr>
                    <p>
                        Passionné par le développement web, j'ai commencé mon apprentissage en créant des sites statiques avant de plonger
                        dans l'univers dynamique du PHP.
                    </p>
                    <p>
                        Mon objectif est de créer des applications web performantes et utiles.
                    </p>

                    <h4 class="mt-4">Mes Compétences</h4>

                    <?php if (count($skills) > 0): ?>
                        <div class="mt-3">
                            <?php foreach ($skills as $skill): ?>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo htmlspecialchars($skill['name']); ?></strong>
                                        <span><?php echo $skill['level']; ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $skill['level']; ?>%;"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>Aucune compétence listée pour le moment.</p>
                    <?php endif; ?>

                    <div class="mt-4 text-center">
                        <a href="contact.php" class="button-primary">Me contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>