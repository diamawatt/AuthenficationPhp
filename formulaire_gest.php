<?php
session_start();

// Base de données simulée
$utilisateurs = [
    "admin" => "admin",
    "diama" => "motdepasse",
    "sophie" => "azerty",
    "aliou" => "breukh"
];

// Récupération des données du formulaire
$prenom = $_POST['prenom'] ?? '';
$motdepasse = $_POST['motdepasse'] ?? '';

// Vérification des identifiants
if (isset($utilisateurs[$prenom]) && $utilisateurs[$prenom] === $motdepasse) {
    $_SESSION['user'] = $prenom;

    // Redirection selon le rôle
    if ($prenom === "admin") {
        header("Location: admin.php");
    } else {
        header("Location: espace_user.php");
    }
    exit();
} else {
    // Message d'erreur si mauvais identifiants
    echo "<script>alert('Identifiants incorrects.'); window.location.href='formulaire.php';</script>";
    exit();
}
?>
