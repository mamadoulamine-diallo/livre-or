<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        .page-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            /* background: url('../../assets/images/background.jpg') no-repeat center center/cover; */
        }
        .form-container {
            background: whitesmoke;
            color: black;
            padding: 30px;
            border-radius: 10px;
            color: white;
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: black;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid white;
            background: transparent;
            color: black;
            outline: none;
        }
        label {
            color: black;
        }
        button {
            background: #5a2df3;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background: #3a1bd5;
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

    <div class="page-container">
        <div class="form-container">
            <h2>Inscription</h2>
            <?php
            session_start();
            if (!empty($_SESSION['form_errors'])) {
                echo '<ul style="color: red; text-align: left;">';
                foreach ($_SESSION['form_errors'] as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul>';
                unset($_SESSION['form_errors']); 
            }
            ?>
            <form action="register_process.php" method="POST">
                
                <label for="email">Email :</label>
                <input type="email" id="login" name="login" required value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>
