<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            font-size: 24px;
            margin-top: 60px;
            color: #333;
            margin-bottom: 0;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 40px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
            color: red;
            font-size: 14px;
            text-align: left;
        }
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .nav-auth {
            padding: 20px;
            background: rgb(18,21,43);
            color: white;
            width: 100%;
        }
        .nav-auth a {
            color: white;
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="nav-auth">
        <a href="../public/index.php">Accueil</a>
    </div>

    <h2>Connexion</h2>

    <?php
    if (!empty($_SESSION['login_errors'])) {
        echo '<ul>';
        foreach ($_SESSION['login_errors'] as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        unset($_SESSION['login_errors']);
    }
    ?>

    <form action="login_process.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="<?= $_SESSION['old_login']['email'] ?? '' ?>">
        <?php unset($_SESSION['old_login']); ?>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

</body>
</html>
