<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/user.php';

$user = new User(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $login = filter_var(trim($_POST['login']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$login) {
        $errors[] = "Email invalide.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit faire 8 caractères minimum.";
    }

    if (empty($errors)) {
        $user->setLogin($login);  
        $user->setPassword($password);  

        $registerResult = $user->register();

        if ($registerResult === true) {
            header("Location: ../public/index.php");
            exit();
        } else {
            $errors[] = $registerResult; 
        }
    }

  
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_data'] = $_POST;
    header("Location: register.php"); 
    exit();
}


?>
