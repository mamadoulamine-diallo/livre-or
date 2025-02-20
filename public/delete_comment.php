<?php
require_once __DIR__ . '/../admin/auth.php';
require_once __DIR__ . '/../classes/Comment.php';
// require_once __DIR__ . '/../classes/Database.php';

$commentObj = new Comment();

if (isset($_GET['id'])) {
    $commentId = (int) $_GET['id'];

    if ($commentObj->deleteComment($commentId)) {
        echo "Commentaire supprimé avec succès !";
    } else {
        echo "Erreur lors de la suppression.";
    }
}