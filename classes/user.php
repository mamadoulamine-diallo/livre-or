<?php
class User {
    private $db;
    private $id;
    private $fullName;
    private $login;
    private $password;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = trim($fullName);
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = trim($login);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new Exception("Le mot de passe doit contenir au moins 8 caractères.");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function register() {
        if ($this->getUserByLogin($this->login)) {
            return "Ce login est déjà utilisé.";
        }

        $sql = "INSERT INTO user (full_name, login, password) VALUES (:fullName, :login, :password)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':fullName' => $this->fullName,
            ':login' => $this->login,
            ':password' => $this->password
        ]);
    }

    public function login($login, $password) {
        $sql = "SELECT * FROM user WHERE login = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':login' => trim($login)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->fullName = $user['full_name'];
            $this->login = $user['login'];
            session_start();
            $_SESSION['user_id'] = $this->id;
            $_SESSION['full_name'] = $this->fullName;
            $_SESSION['login'] = $this->login;
            return true;
        }
        return false;
    }

    public function updateProfile() {
        if (empty($this->id)) {
            throw new Exception("ID utilisateur manquant pour la mise à jour.");
        }
    
        if (!empty($this->password)) {
            $sql = "UPDATE user SET login = :login, password = :password WHERE id = :id";
            $params = [
                ':login' => $this->login,
                ':password' => $this->password,
                ':id' => $this->id
            ];
        } else {
            $sql = "UPDATE user SET login = :login WHERE id = :id";
            $params = [
                ':login' => $this->login,
                ':id' => $this->id
            ];
        }
    
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function verifyPassword($currentPassword) {
        $sql = "SELECT password FROM user WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $this->id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($currentPassword, $user['password'])) {
            return true;
        }
        return false;
    }
    
    private function getUserByLogin($login) {
        $sql = "SELECT * FROM user WHERE login = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':login' => trim($login)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
