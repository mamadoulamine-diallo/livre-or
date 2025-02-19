<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';


$db = Database::getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $login = filter_var(trim($_POST['login']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$login) $errors[] = "Email invalide.";
    if (empty($password)) $errors[] = "Le mot de passe est obligatoire.";

    
    if (empty($errors)) {
        if ($user->login($login, $password)) {
            header("Location: profil.php"); 
            exit();
        } else {
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }


    $_SESSION['login_errors'] = $errors;
    $_SESSION['old_login'] = $_POST;
    header("Location: login.php");
    exit();
}
?>
