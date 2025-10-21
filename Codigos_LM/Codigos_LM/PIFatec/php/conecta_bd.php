<?php
$server = 'localhost:3306';
$username = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$server:dbname=pdo", $username, $pass);

    //definir erro exceções de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Conexão reaizada!';
} catch(PDOException $e){
    echo 'Conexão falhou!'.$e->getMessage();
}
?>