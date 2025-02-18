<?php
// include 'Database.php';


class User {
    private $db;
    private $id;
    private $login;
    private $password;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    
    public function register() {
        if ($this->getUserByLogin($this->login)) {
            return "Ce login est déjà utilisé.";
        }

        $sql = "INSERT INTO user (login, password) VALUES (:login, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $this->login);
        $stmt->bindParam(':password', $this->password);

        return $stmt->execute();
    }

    public function login($login, $password) {
        $sql = "SELECT * FROM user WHERE login = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->id = $user['id'];
            $this->login = $user['login'];
            session_start();
            $_SESSION['user_id'] = $this->id;
            $_SESSION['login'] = $this->login;
            return true;
        }

        return false;
    }

    
    public function updateProfile() {
        $sql = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $this->login);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    private function getUserByLogin($login) {
        $sql = "SELECT * FROM user WHERE login = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
