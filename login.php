<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <style>
    /* Reset & basic */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, html { height: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
    
    /* Center container */
    .container { display: flex; align-items: center; justify-content: center; height: 100%; }
    .card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); width: 360px; padding: 2rem; }
    h4 { text-align: center; margin-bottom: 1.5rem; color: #333; }
    
    /* Form fields */
    .form-group { margin-bottom: 1rem; }
    label { display: block; font-size: 0.9rem; margin-bottom: 0.3rem; color: #555; }
    input { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; transition: border-color 0.2s; }
    input:focus { outline: none; border-color: #667eea; }
    
    /* Button */
    .btn { width: 100%; padding: 0.7rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 1rem; font-weight: 500; border: none; border-radius: 6px; cursor: pointer; transition: background 0.3s; }
    .btn:hover { background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%); }
    
    /* Alert */
    .alert { background: #ffe3e3; color: #d42121; padding: 0.8rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; text-align: center; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h4>Connexion</h4>
      <?php if (isset($_GET['erreur'])): ?>
        <div class="alert">Identifiants incorrects !</div>
      <?php endif; ?>
      <form action="formulaire_gest.php" method="POST">
        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
          <label for="motdepasse">Mot de passe</label>
          <input type="password" id="motdepasse" name="motdepasse" required>
        </div>
        <button type="submit" class="btn">Se connecter</button>
      </form>
    </div>
  </div>
</body>
</html>
