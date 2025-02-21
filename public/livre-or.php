<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
  
}

// require_once __DIR__ . '/../admin/auth.php';
require_once __DIR__ . '/../classes/Comment.php';

$comment = new Comment();

// Gestion de la recherche
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$perPage = 5;
$totalComments = $comment->getTotalComments($searchTerm);
$comments = $comment->getComments($searchTerm, $page, $perPage);

// Calcul du nombre de pages
$totalPages = ceil($totalComments / $perPage);

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or</title>
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
      body {
        min-height: 100vh;
        position: relative;
      }
      h1 {
        color: yellow;
      }
      form {
        width: 80%;
        margin: 0 auto;
      }
      input {
        width: 300px;
        padding: 10px;
        border-radius: 3px;
        outline: none;
        border: 1px solid yellow;
      }
      .search-btn {
        display: inline;
        padding: 3px 10px;
        vertical-align: bottom;
        color: yellow;
      }
      .comment {
        width: 80%;
        margin: 20px auto;
        border: 2px solid yellow;
        border-radius: 5px;
        background: rgba(53, 43, 43, 0.51);

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
      }
      .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80px;
        margin: 0 auto;
        background: white;
        color: black;
        padding: 5px;
        border-radius: 2px;
        margin-bottom: 20px;
      }
      .pagination a {
        color: black;
      }
      .comment-link {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 240px;
        right: 150px;
        width: 200px;
        padding: 8px;
        border-radius: 3px;
        background: rgba(0, 128, 0, 0.7);
        font-family: "shadows into light"; 
        letter-spacing: 2px;
      }
    </style>
</head>
<body>

  <?php include '../includes/header.php'; ?>

    <h1>Livre d'Or</h1>

    <form method="GET" action="livre-or.php">
        <input type="text" name="search" placeholder="Rechercher un commentaire" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button class="search-btn" type="submit">Rechercher</button>
    </form>

    <?php foreach ($comments as $com): ?>
        <div class="comment">
            <p class="comment-date"><strong><?php echo htmlspecialchars($com['full_name']); ?></strong> - 
            <em>posté le <?php echo date('d/m/Y', strtotime($com['date'])); ?></em></p>
            <p class="comments"><?php echo nl2br(htmlspecialchars($com['comment'])); ?></p>
        </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchTerm); ?>">Précédent</a>
        <?php endif; ?>
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchTerm); ?>">Suivant</a>
        <?php endif; ?>
    </div>

    <?php if ($isLoggedIn): ?>
      <div class="comment-link">
          <a href="commentaires.php">Ajouter un commentaire</a>
      </div>
   <?php endif; ?>

    
</body>
</html>
