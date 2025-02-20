<?php
require_once __DIR__ . '/../admin/auth.php';
require_once __DIR__ . '/../classes/Comment.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$comment = new Comment();
$comment->setUserId($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['comment']);
    
    try {
        $comment->setComment($content);
        if ($comment->addComment()) {
            header("Location: livre-or.php");
            exit();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Commentaire</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
      body {
        min-height: 100vh;
        position: relative;
      }
      h1 {
        color: yellow;
        text-align: center;
      }
      form {
        width: 50%;
        margin: 20px auto;
        padding: 20px;
        background: rgba(53, 43, 43, 0.51);
        border: 2px solid yellow;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      textarea {
        width: 90%;
        font-size: 1rem;
        padding: 10px;
        margin: 10px auto;
        border-radius: 3px;
        border: 1px solid yellow;
        background: black;
        color: white;
        height: 150px;
        resize: none;
      }
      button {
        padding: 10px 20px;
        background: rgba(0, 128, 0, 0.7);
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
      }
      .error {
        color: red;
        text-align: center;
      }
      .return-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: white;
        text-decoration: underline;
      }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Ajouter un Commentaire</h1>

    <?php if (!empty($error)) echo '<p class="error">' . $error . '</p>'; ?>

    <form method="POST" action="">
        <textarea name="comment" placeholder="Votre commentaire" required></textarea>
        <button type="submit">Envoyer</button>
    </form>

    <a href="livre-or.php" class="return-link">Retour au Livre d'Or</a>
</body>
</html>
