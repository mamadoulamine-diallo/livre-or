<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';



$admin = new User();

if (!isset($_SESSION['user_id'])) {
?>
  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Refusé</title>
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background: rgba(53, 43, 43, 0.326);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        text-align: center;
      }

      .container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }

      h1 {
        color: #ff0000;
        margin-bottom: 10px;
      }

      p {
        color: #333;
        margin-bottom: 20px;
      }

      .login-btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background-color: #007BFF;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
      }

      .login-btn:hover {
        background-color: #0056b3;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h1>Accès Refusé</h1>
      <p>Vous devez être inscrit pour accéder à cette page.</p>
      <a href="../admin/login.php" class="login-btn">Se connecter</a>
    </div>

  </body>

  </html>
<?php
  exit;
}
?>