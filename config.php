<?php  
try {
  $mysqlClient = new PDO('mysql:host=127.0.0.1;port=3306;dbname=livreor;charset=utf8', 'root', 'root');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('❌ Erreur : ' . $e->getMessage());
}


?>

