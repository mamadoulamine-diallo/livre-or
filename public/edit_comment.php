<?php
require_once __DIR__ . '/../admin/auth.php';
require_once __DIR__ . '/../classes/Comment.php';

$commentObj = new Comment();

if (!isset($_GET['id'])) {
    die("Aucun commentaire spécifié.");
}

$commentId = (int) $_GET['id'];
$comment = $commentObj->getCommentById($commentId);

if (!$comment || $comment['id_user'] !== $_SESSION['user_id']) {
    die("Accès refusé.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $newComment = trim($_POST['comment']);

    if ($commentObj->updateComment($commentId, $newComment)) {
        header("Location: /livre-or/admin/profil.php?message=Commentaire mis à jour avec succès !");
        exit();
    } else {
        echo "Erreur lors de la modification.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Commentaire</title>
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
        height: 150px;
        padding: 10px;
        margin: 10px 0;
        border-radius: 3px;
        border: 1px solid yellow;
        background: black;
        color: white;
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
    <h1>Modifier votre commentaire</h1>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $commentId; ?>">
        <textarea name="comment" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
        <button type="submit">Enregistrer</button>
    </form>

    <a href="/livre-or/admin/profil.php" class="return-link">Annuler</a>
</body>
</html>
