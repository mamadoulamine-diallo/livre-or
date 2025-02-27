<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/comment.php';


$user = new User();
$user->setId($_SESSION['user_id']);

$commentObj = new Comment();
$userComments = $commentObj->getUserComments($_SESSION['user_id']);



$user->login($_SESSION['login'], '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login']);
  $currentPassword = trim($_POST['current_password']); 
  $newPassword = trim($_POST['password']);

  try {
      if (!$user->verifyPassword($currentPassword)) {
          throw new Exception("Le mot de passe actuel est incorrect.");
      }

      $user->setLogin($login);
      
      if (!empty($newPassword)) {
          $user->setPassword($newPassword);
      }

      if ($user->updateProfile()) {
          $_SESSION['login'] = $login;
          $message = 'Identifiants mis à jour avec succès !';
      } else {
          $error = 'Erreur lors de la mise à jour des identifiants.';
      }
  } catch (Exception $e) {
      $error = $e->getMessage();
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Profil</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      position: relative;
    }
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
      display: flex;
      justify-content: center;
      align-items: center;
      visibility: hidden;
      opacity: 0;
      transition: opacity 0.3s ease;
    }


    #editOverlay:target {
      visibility: visible;
      opacity: 1;
    }


    .overlay-content {
      background: rgba(0, 0, 0, 0.3);
      padding: 20px;
      border-radius: 10px;
      width: 500px;
      text-align: center;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    
    input {
      width: 80%;
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    input:focus {
            border-color: green;
            outline: none;
        }

    .btn {
      padding: 10px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10px;
    }

    .save-btn {
      background: green;
      color: white;
    }

    .close-btn {
      background: red;
      color: white;
    }

    .btn-edit {
      border-radius: 8px;
      background: rgba(0, 128, 0, 0.7);
      border: none;
      margin-right: 150px;
    }
    .btn-delete {
      position: absolute;
      bottom: 20px;
      right: 150px;
      background: rgba(128, 0, 0, 0.7);
      border: none;
    }
  
    h2 {
      margin-left: 150px;
      text-transform: capitalize;
      font-family: Arial, Helvetica, sans-serif;
      font-weight: 500;
    }
    h3 {
      font-family: "shadows into light"; 
      font-weight: 300;
      letter-spacing: 1px;
    }
    .comment {
    width: 80%;
    margin: 20px auto;
    border: 2px solid yellow;
    border-radius: 5px;
    padding: 10px;
    background-color: #222;
    color: white;
}

  .comments {
      width: 100%;
      margin: 0 auto;
      padding: 15px;
      line-height: 20px;
      font-weight: normal;
  }

  .comment-date {
      width: 100%;
      margin: 5px auto;
      padding-left: 15px;
      color: yellow;
      font-size: 14px;
  }
  .comment p {
    margin: 0;
  }

  .comment a {
      display: inline-block;
      margin-top: 10px;
      padding: 5px 10px;
      border-radius: 3px;
      text-decoration: none;
      color: white;
  }

  .comment a:hover {
      text-decoration: underline;
  }

  .comment a:nth-child(2) {
      background: rgba(0, 128, 0, 0.7);
  }

  .comment a:nth-child(3) {
      background: rgba(128, 0, 0, 0.7);
  }

    
  </style>
</head>

<body>
  <?php include '../includes/header.php';  ?>

  <h1>Bonjour <?php echo htmlspecialchars($_SESSION['full_name']) ?> !</h1>

  <button class="btn-edit"><a href="#editOverlay">Modifier mes identifiants</a></button>

  <div id="editOverlay" class="overlay">
    <div class="overlay-content">
      <h3>Modifier mes Identifiants</h3>

      <?php if (!empty($message)) echo '<p style="color:yellow;">' . $message . '</p>'; ?>
      <?php if (!empty($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>
      
      <form method="POST" action="">
        <input type="text" name="login" placeholder="Nouveau login" value="<?php echo htmlspecialchars($user->getLogin()) ?>" required>
        <input type="password" name="current_password" placeholder="Mot de passe actuel" required>
        <input type="password" name="password" placeholder="Nouveau mot de passe">
        <button type="submit" class="btn save-btn">Enregistrer</button>
        <a href="#" class="btn close-btn">Annuler</a> 
      </form>

    </div>
  </div>
  <section class="msge">
    <h2>Mes commentaires</h2>
    <?php if (!empty($userComments)) : ?>
        <?php foreach ($userComments as $comment) : ?>
            <div class="comment">
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                <span>Posté le <?php echo $comment['date']; ?></span>
                <a href="../public/edit_comment.php?id=<?php echo $comment['id']; ?>">Modifier</a>
                <a href="../public/delete_comment.php?id=<?php echo $comment['id']; ?>" onclick="return confirm('Supprimer ce commentaire ?');">Supprimer</a>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucun commentaire posté.</p>
    <?php endif; ?>
</section>


    <button class="btn-delete">  <a href="logout.php">Se déconnecter</a>
    </button>




</body>

</html>