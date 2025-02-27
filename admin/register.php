<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
            background: rgba(53, 43, 43, 0.326);
            color: black;
            padding: 30px;
            border-radius: 10px;
            color: white;
            width: 300px;
            text-align: center;
            width: 300px;
            margin-top: 1px;
        }
        h2 {
            /* margin-bottom: 20px; */
            color: black;
            margin-top: 5px;
            font-family: "shadows into light"; 

        }
        input {
            width: 90%;
            margin: 0 auto;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid white;
            background-color: #f4f4f9;
            color: black;
            outline: none;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
        }
        label {
            display: block;
            color: whitesmoke;
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
        .btn-submit {
            margin-top: 80px;
        }
        
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>


    <div class="page-container">
        <div class="form-container">
            <h2>Inscription</h2>
            <?php
            session_start();
            if (!empty($_SESSION['form_errors'])) {
                echo '<ul style="color: yellow; text-align: left;">';
                foreach ($_SESSION['form_errors'] as $error) {
                    echo "<li>$error</li>";
                }
                echo '</ul>';
                unset($_SESSION['form_errors']); 
            }
            ?>
            <form action="register_process.php" method="POST">
                <label for="fullname">Nom - Prenom :</label>
                <input type="text" id="full_name" name="full_name" require value="<?= $_SESSION['old_data']['full_name'] ?? '' ?>">
                    
                <label for="email">Email :</label>
                <input type="email" id="login" name="login" required value="<?= $_SESSION['old_data']['login'] ?? '' ?>">
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                
                <button class="btn-submit" type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>
