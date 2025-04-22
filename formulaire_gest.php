<?php
session_start();

// Base de données simulée
$utilisateurs = [
    "admin" => "admin",
    "diama" => "motdepasse",
    "sophie" => "azerty",
    "aliou" => "breukh"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'] ?? '';
    $motdepasse = $_POST['motdepasse'] ?? '';

    if (isset($utilisateurs[$prenom]) && $utilisateurs[$prenom] === $motdepasse) {
        $_SESSION['user'] = $prenom;
        header("Location: " . ($prenom === "admin" ? "admin.php" : "espace_user.php"));
        exit();
    } else {
        $erreur = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        .erreur {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <?php if (isset($erreur)): ?>
            <div class="erreur">❌ Identifiants incorrects. Veuillez réessayer.</div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
