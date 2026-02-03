<?php
// EXEMPLE DE CONFIGURATION
// Renommez ce fichier en 'config.php' et mettez vos vraies informations.

// 1. Base de données
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mettez votre mot de passe ici

// 2. Compte Admin
define('ADMIN_USER', 'admin');
// Générez votre propre hash avec : echo password_hash('votre_mot_de_passe', PASSWORD_DEFAULT);
define('ADMIN_PASS_HASH', 'METTRE_LE_HASH_ICI');
