<?php include 'includes/header.php'; ?>
<main>
    <div class="container-fluid">
        <h1>Contact</h1>
        <p class="text-center">N'hésitez pas à me laisser un message.</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                // Traitement du formulaire
                require_once 'includes/db.php'; // On se connecte à la BDD

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nom = htmlspecialchars($_POST['nom']);
                    $email = htmlspecialchars($_POST['email']);
                    $message = htmlspecialchars($_POST['message']);

                    try {
                        $stmt = $pdo->prepare("INSERT INTO messages (nom, email, message) VALUES (:nom, :email, :message)");
                        $stmt->execute([
                            'nom' => $nom,
                            'email' => $email,
                            'message' => $message
                        ]);
                        echo '<div class="alert alert-success">Merci ' . $nom . ', votre message a bien été enregistré !</div>';
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Erreur lors de l\'envoi : ' . $e->getMessage() . '</div>';
                    }
                }
                ?>

                <form action="contact.php" method="POST" class="card p-4">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom :</label>
                        <input type="text" id="nom" name="nom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message :</label>
                        <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="button-primary w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>