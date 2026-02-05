<?php
require_once 'includes/db.php';

// Récupération des projets depuis la base de données MySQL
try {
    $stmt = $pdo->query("SELECT * FROM projects");
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En cas d'erreur (table vide ou autre), on prévoit un tableau vide pour éviter de casser le site
    $projets = [];
    // echo "Erreur lors de la récupération des projets : " . $e->getMessage();
}

// Récupération des compétences (Skills)
try {
    $stmt_skills = $pdo->query("SELECT * FROM skills ORDER BY level DESC");
    $skills = $stmt_skills->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $skills = [];
}

// On pourrait aussi ajouter d'autres données ici, comme vos informations personnelles
$infos_perso = [
    "nom" => "Mohamed Makhloufi",
    "email" => "contact@portfolio.com",
    "poste" => "Développeur PHP Junior"
];
