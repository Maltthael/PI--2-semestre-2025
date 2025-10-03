<?php
$host = 'localhost:3306';
$user = 'root';
$pass = '';
$db = 'loja_informatica';

$conn = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $db);

if(!$conn){
    die("Morreu fi: " . mysqli_connect_error());
}


//try {
    //$conn = new PDO("mysql:host=$server;dbname=$db", $username, $pass);

    //definir erro exceções de erro
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'Conexão reaizada!';
//} catch(PDOException $e){
   //echo 'Conexão falhou!'.$e->getMessage();
//}
?>