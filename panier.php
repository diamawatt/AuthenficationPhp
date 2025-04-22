<?php
session_start();

// Verifier si l'utilisateur est connecté et n'est pas un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user'] === "admin") {
    header("Location: formulaire.php");
    exit();
}

$user = $_SESSION['user'];

// Verifier si le panier existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fonction pour supprimer un article du panier
function removeFromCart($articleTitle) {
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $articleTitle);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Réindexer le tableau
}

// Verifier si un article doit etre retiré
if (isset($_GET['remove']) && isset($_GET['title'])) {
    $title = $_GET['title'];
    removeFromCart($title);
    header("Location: panier.php"); // Rediriger après suppression
    exit();
}

// Les articles par catégorie (3 articles par catégorie)
$articles = [
    'tshirts' => [
        [
            'title' => 'T-shirt Street',
            'description' => 'Un t-shirt stylé pour représenter la street avec classe.',
            'image' => 'https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDI0LTA0L3Jhd3BpeGVsX29mZmljZV80OV9hX3Bob3RvX29mX2FuX292ZXJzaXplZF93aGl0ZV90LXNoaXJ0X2JhY2tfc19jZGVlZmExNS02ZmM0LTQyYTktOWJlOS1iMzk0MjM1MjhjNWQtMDEtbW9ja3VwXzEuanBn.jpg',
            'price' => 2500
        ],
        [
            'title' => 'T-shirt Minimaliste',
            'description' => 'Simple mais élégant, ce t-shirt convient à tous les styles.',
            'image' => 'https://i.pinimg.com/736x/c2/dc/05/c2dc056b7fe60086428e6072989208dd.jpg',
            'price' => 2000
        ],
        [
            'title' => 'T-shirt Logo',
            'description' => 'Montre ta loyauté à la marque avec ce t-shirt au logo iconique.',
            'image' => 'https://www.onlyvibes.fr/wp-content/uploads/2023/10/T-shirt-tee-shirt-streetwear-homme-79-scaled.jpg',
            'price' => 3000
        ]
    ],
    'sweats' => [
        [
            'title' => 'Sweat Oversize',
            'description' => 'Confort et style réunis dans ce sweat parfait pour l’hiver.',
            'image' => 'https://grunge-clothing.com/wp-content/uploads/2020/11/Hc1c53ce5d44749019515ed233c6458acq.jpg',
            'price' => 4500
        ],
        [
            'title' => 'Sweat à Capuche',
            'description' => 'Le classique sweat à capuche pour tous les jours.',
            'image' => 'https://tenko.fr/cdn/shop/files/S5450f332ece641e5b2bd01e2a6879d69p.webp?v=1735124787',
            'price' => 4000
        ],
        [
            'title' => 'Sweat Street',
            'description' => 'Un sweat tendance pour les amateurs de streetwear.',
            'image' => 'https://urb1-vetements-streetwear.com/cdn/shop/products/BUTTERFLY-Sweat-shirt-Hoodie-noir-Urb1-vetements-streetwear-homme-femme-mixte-unisexe-2_2048x.png?v=1611618925',
            'price' => 5000
        ]
    ],
    'casquettes' => [
        [
            'title' => 'Casquette NationDrip',
            'description' => 'Affiche ton flow avec cette casquette tendance.',
            'image' => 'https://steezywave.com/wp-content/uploads/2023/10/casquette-newera-lasvegas-raiders.jpg',
            'price' => 1500
        ],
        [
            'title' => 'Casquette Classique',
            'description' => 'Un design simple et élégant, idéal pour tous les jours.',
            'image' => 'https://akitoparis.com/cdn/shop/products/casquette-streetwear-280504.jpg?v=1673311233',
            'price' => 1200
        ],
        [
            'title' => 'Casquette Sport',
            'description' => 'Pour les passionnés de sport, cette casquette allie confort et style.',
            'image' => 'https://urb1-vetements-streetwear.com/cdn/shop/articles/Casquettes-Nike-Les-meilleures-marques-de-casquettes-baseball--snapback-streetwear_503x.png?v=1616112083',
            'price' => 1800
        ]
    ],
];

// Recuperer les articles du panier
$cartItems = [];
foreach ($_SESSION['cart'] as $title) {
    foreach ($articles as $category => $categoryItems) {
        foreach ($categoryItems as $article) {
            if ($article['title'] === $title) {
                $cartItems[] = $article;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand">Panier</span>
        <div class="d-flex align-items-center">
            <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2>Articles dans ton panier</h2>
    <?php if (empty($cartItems)) : ?>
        <p>Ton panier est vide.</p>
    <?php else : ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($cartItems as $item) : ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?= $item['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($item['description']) ?></p>
                            <p class="card-text"><strong>Prix: <?= number_format($item['price'], 0, ',', ' ') ?> CFA</strong></p>
                            <a href="?remove=true&title=<?= urlencode($item['title']) ?>" class="btn btn-danger">
                                Supprimer du panier
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
