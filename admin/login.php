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
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
            
        }
        h2 {
            font-family: "shadows into light"; 
            font-size: 24px;
            margin-top: 60px;
            color: black;
            margin-bottom: 0;
        }
        form {
            background: rgba(53, 43, 43, 0.326);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            /* margin-top: 40px; */
            margin: 40px 0 0 0;
            
        }
        .maConnexion {
            display: flex;
            justify-content: center;
            align-items: center;
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
            color: whitesmoke;
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
        .btn-connexion {
            margin-top: 20px;
        }
        span {
            /* text-decoration: underline ; */
            color: yellow;
            font-family: "shadows into light";
            font-size: 1.5rem;
        }
        
    </style>
</head>
<body>

    <?php include '../includes/header.php'; ?>

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
    <div class="maConnexion">
        <form action="login_process.php" method="POST">
            
            <label for="email">Email :</label>
            <input type="email" id="email" name="login" required value="<?= $_SESSION['old_login']['login'] ?? '' ?>">
            <?php unset($_SESSION['old_login']); ?>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button class="btn-connexion" type="submit">Se connecter</button>
        </form>
    </div>
    
    <p>Vous n'avez pas de compte ? <a href="register.php"><span>Inscrivez-vous ici</span></a></p>


</body>
</html>
