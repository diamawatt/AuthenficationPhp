<?php
session_start();

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user = 'Admin';  // ou htmlspecialchars($_SESSION['user']) si tu préfères

// Fonction pour obtenir les articles depuis le fichier JSON
function getArticles() {
    return json_decode(file_get_contents('articles.json'), true);
}

// Fonction pour sauvegarder les articles dans le fichier JSON
function saveArticles($articles) {
    file_put_contents('articles.json', json_encode($articles, JSON_PRETTY_PRINT));
}

// Ajouter un article
if (isset($_POST['add'])) {
    $articles = getArticles();
    $new_article = [
        'id' => uniqid(),
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'price' => $_POST['price']
    ];
    $articles[] = $new_article;
    saveArticles($articles);
}

// Modifier un article
if (isset($_POST['update'])) {
    $articles = getArticles();
    foreach ($articles as &$article) {
        if ($article['id'] == $_POST['id']) {
            $article['title'] = $_POST['title'];
            $article['description'] = $_POST['description'];
            $article['price'] = $_POST['price'];
            break;
        }
    }
    saveArticles($articles);
}

// Supprimer un article
if (isset($_POST['delete'])) {
    $articles = getArticles();
    $articles = array_filter($articles, function($article) {
        return $article['id'] != $_POST['id'];
    });
    saveArticles(array_values($articles));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar horizontale -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Tableau de bord - Admin</span>
    <div class="d-flex align-items-center">
      <span class="text-white me-3">Connecté en tant que <strong><?= $user ?></strong></span>
      <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar vertical à gauche -->
    <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="min-height:100vh;">
      <div class="position-sticky pt-4">
        <h6 class="px-3 text-muted">Actions</h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#addArticle">
              <i class="bi bi-plus-circle me-2"></i>Ajouter un article
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#editArticle">
              <i class="bi bi-pencil-square me-2"></i>Modifier un article
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#deleteArticle">
              <i class="bi bi-trash me-2"></i>Supprimer un article
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Contenu principal -->
    <main class="col-md-10 ms-sm-auto px-4">
      <div class="pt-4 pb-2">
        <h2 class="text-center">Espace Administrateur 🛠️</h2>
      </div>

      <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Carte Ajouter -->
        <div class="col">
          <div class="card border-primary h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Ajouter un article</h5>
              <form method="POST" action="#addArticle">
                <input type="text" name="title" placeholder="Titre" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="number" name="price" placeholder="Prix" required>
                <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Carte Modifier -->
        <div class="col">
          <div class="card border-warning h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Modifier un article</h5>
              <form method="POST" action="#editArticle">
                <select name="id" required>
                  <?php foreach (getArticles() as $article): ?>
                    <option value="<?= $article['id'] ?>"><?= $article['title'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="text" name="title" placeholder="Nouveau Titre" required>
                <input type="text" name="description" placeholder="Nouvelle Description" required>
                <input type="number" name="price" placeholder="Nouveau Prix" required>
                <button type="submit" name="update" class="btn btn-warning">Modifier</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Carte Supprimer -->
        <div class="col">
          <div class="card border-danger h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Supprimer un article</h5>
              <form method="POST" action="#deleteArticle">
                <select name="id" required>
                  <?php foreach (getArticles() as $article): ?>
                    <option value="<?= $article['id'] ?>"><?= $article['title'] ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>

  </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
