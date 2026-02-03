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
                    <ul>
                        <li>HTML5 / CSS3</li>
                        <li>PHP / MySQL (En cours d'apprentissage)</li>
                        <li>Git / GitHub</li>
                    </ul>

                    <div class="mt-4 text-center">
                        <a href="contact.php" class="button-primary">Me contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>