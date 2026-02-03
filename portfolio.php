<?php include 'includes/header.php'; ?>
<?php
// Exemple de projets (Tableau PHP)
$projets = [
    [
        "titre" => "Site E-commerce",
        "description" => "Un site de vente en ligne complet avec panier et paiement.",
        "image" => "Assets/images/v627-aew-01-technologybackground.webp", 
        "lien" => "#"
    ],
    [
        "titre" => "Blog Personnel",
        "description" => "Un blog minimaliste développé en PHP.",
        "image" => "https://placehold.co/600x400/007bff/ffffff?text=Mon+Blog",
        "lien" => "#"
    ],
    [
        "titre" => "Application To-Do",
        "description" => "Une application simple pour gérer sa liste de choses à faire.",
        "image" => "https://placehold.co/600x400/28a745/ffffff?text=To-Do+List",
        "lien" => "#"
    ]
];
?>
<main>
    <div class="container-fluid">
        <h1>Mon Portfolio</h1>
        <p>Découvrez mes réalisations.</p>
        
        <div class="row">
            <?php foreach($projets as $projet): ?>
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