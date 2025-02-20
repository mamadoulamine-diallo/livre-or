<?php
require_once 'Database.php'; 

class Comment {
    private $db;
    private $idUser;
    private $comment;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function setUserId($idUser) {
        $this->idUser = (int) $idUser;
    }

    public function setComment($comment) {
        $this->comment = trim($comment);
    }

    public function addComment() {
        if (empty($this->comment)) {
            throw new Exception("Le commentaire ne peut pas être vide.");
        }

        $sql = "INSERT INTO comment (comment, id_user, date) VALUES (:comment, :id_user, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':comment' => $this->comment,
            ':id_user' => $this->idUser
        ]);
    }

    public function getComments($searchTerm = '', $page = 1, $perPage = 10) {
      $offset = ($page - 1) * $perPage;
      $sql = "SELECT c.comment, c.date, u.full_name 
              FROM comment c 
              JOIN user u ON c.id_user = u.id 
              WHERE c.comment LIKE :searchTerm 
              ORDER BY c.date DESC 
              LIMIT :offset, :perPage";
  
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
      $stmt->execute();
  
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

    public function getUserComments($userId) {
        $sql = "SELECT id, comment, date FROM comment WHERE id_user = :id_user ORDER BY date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_user' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteComment($commentId) {
        $sql = "DELETE FROM comment WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $commentId]);
    }
    
    public function updateComment($commentId, $newComment) {
        $sql = "UPDATE comment SET comment = :comment, date = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':comment' => trim($newComment),
            ':id' => $commentId
        ]);
    }

    public function getCommentById($commentId) {
        $sql = "SELECT id, comment, id_user FROM comment WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function getTotalComments($searchTerm = '') {
        $sql = "SELECT COUNT(*) FROM comment WHERE comment LIKE :searchTerm";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchColumn();
    }
}
?>
