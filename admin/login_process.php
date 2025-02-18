<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/user.php';


$db = Database::getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if (!$email) $errors[] = "Email invalide.";
    if (empty($password)) $errors[] = "Le mot de passe est obligatoire.";

    
    if (empty($errors)) {
        if ($user->login($email, $password)) {
            header("Location: ../public/index.php"); 
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
