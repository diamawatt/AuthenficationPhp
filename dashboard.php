<?php
session_start();

// Redirection si non connecté
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
$user = htmlspecialchars($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Compte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Espace Client</span>
    <div class="d-flex">
      <span class="text-white me-3">Connecté en tant que <strong><?= $user ?></strong></span>
      <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
    </div>
  </div>
</nav>

<!-- Contenu -->
<div class="container mt-5">
  <h2 class="mb-4">Bienvenue dans ton espace privé, <?= $user ?> 👋</h2>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    <!-- Article 1 -->
<div class="col">
  <div class="card h-100">
    <img src="https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDI0LTA0L3Jhd3BpeGVsX29mZmljZV80OV9hX3Bob3RvX29mX2FuX292ZXJzaXplZF93aGl0ZV90LXNoaXJ0X2JhY2tfc19jZGVlZmExNS02ZmM0LTQyYTktOWJlOS1iMzk0MjM1MjhjNWQtMDEtbW9ja3VwXzEuanBn.jpg" class="card-img-top" alt="T-shirt Street">
    <div class="card-body">
      <h5 class="card-title">T-shirt Street</h5>
      <p class="card-text">Un t-shirt stylé pour représenter la street avec classe.</p>
    </div>
  </div>
</div>

<!-- Article 2 -->
<div class="col">
  <div class="card h-100">
    <img src="https://steezywave.com/wp-content/uploads/2023/10/casquette-newera-lasvegas-raiders.jpg" class="card-img-top" alt="Casquette NationDrip">
    <div class="card-body">
      <h5 class="card-title">Casquette NationDrip</h5>
      <p class="card-text">Affiche ton flow avec cette casquette tendance.</p>
    </div>
  </div>
</div>

<!-- Article 3 -->
<div class="col">
  <div class="card h-100">
    <img src="https://grunge-clothing.com/wp-content/uploads/2020/11/Hc1c53ce5d44749019515ed233c6458acq.jpg" class="card-img-top" alt="Sweat Oversize">
    <div class="card-body">
      <h5 class="card-title">Sweat Oversize</h5>
      <p class="card-text">Confort et style réunis dans ce sweat parfait pour l’hiver.</p>
    </div>
  </div>
</div>

  </div>

  <div class="text-center mt-5">
    <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
  </div>
</div>

</body>
</html>
