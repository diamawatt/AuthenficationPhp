<?php
session_start();

// Vérifier si l'utilisateur est connecté et pas un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user'] === "admin") {
    header("Location: formulaire.php");
    exit();
}

$user = $_SESSION['user'];

// Vérifier si le panier existe, sinon initialiser un panier vide
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fonction pour ajouter ou retirer un article du panier
function toggleCart($article) {
    if (in_array($article['title'], $_SESSION['cart'])) {
        // Retirer du panier
        $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $article['title']);
    } else {
        // Ajouter au panier
        $_SESSION['cart'][] = $article['title'];
    }
}

// Déterminer la catégorie sélectionnée
$category = isset($_GET['category']) ? $_GET['category'] : 'tshirts';

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

// Sélectionner les articles de la catégorie choisie
$selectedArticles = isset($articles[$category]) ? $articles[$category] : [];

// Vérifier si un article a été ajouté ou retiré
if (isset($_GET['action']) && isset($_GET['title'])) {
    $action = $_GET['action'];
    $title = $_GET['title'];

    // Trouver l'article correspondant
    foreach ($selectedArticles as $article) {
        if ($article['title'] === $title) {
            toggleCart($article);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Client</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      overflow-x: hidden;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #f8f9fa;
      border-left: 1px solid #dee2e6;
    }
    .sidebar .nav-link {
      color: #333;
    }
    .sidebar .nav-link:hover {
      background-color: #e9ecef;
    }
    .cart-icon {
      position: relative;
    }
    .cart-notification {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 5px 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<!-- Navbar horizontale -->
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid justify-content-between">
    <span class="navbar-brand">Espace Client</span>
    <div class="d-flex align-items-center">
      <span class="text-white me-3">Bienvenue, <strong><?= htmlspecialchars($user) ?></strong></span>
      <a href="panier.php" class="btn btn-outline-light me-2 cart-icon">
        <i class="bi bi-cart"></i>
        <?php if (count($_SESSION['cart']) > 0): ?>
          <span class="cart-notification"><?= count($_SESSION['cart']) ?></span>
        <?php endif; ?>
      </a>
      <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">

    <!-- Contenu principal -->
    <div class="col-md-9 p-4">
      <h2 class="mb-4">Bienvenue dans ton espace privé, <?= htmlspecialchars($user) ?> 👋</h2>

      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($selectedArticles as $article) : ?>
          <div class="col">
            <div class="card h-100">
              <img src="<?= $article['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($article['description']) ?></p>
                <p class="card-text"><strong>Prix: <?= number_format($article['price'], 0, ',', ' ') ?> CFA</strong></p>
                
                <?php
                // Vérifier si l'article est dans le panier
                $isInCart = in_array($article['title'], $_SESSION['cart']);
                $buttonText = $isInCart ? 'Supprimer du panier' : 'Ajouter au panier';
                $action = $isInCart ? 'remove' : 'add';
                ?>

                <a href="?category=<?= $category ?>&action=<?= $action ?>&title=<?= urlencode($article['title']) ?>" class="btn btn-primary">
                  <?= $buttonText ?>
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Sidebar verticale à droite -->
    <div class="col-md-3 sidebar p-4">
      <h5 class="mb-3">Catégories</h5>
      <div class="nav flex-column">
        <a class="nav-link <?= $category === 'tshirts' ? 'active' : '' ?>" href="?category=tshirts">T-shirts</a>
        <a class="nav-link <?= $category === 'sweats' ? 'active' : '' ?>" href="?category=sweats">Sweats</a>
        <a class="nav-link <?= $category === 'casquettes' ? 'active' : '' ?>" href="?category=casquettes">Casquettes</a>
      </div>
    </div>

  </div>
</div>

</body>
</html>
