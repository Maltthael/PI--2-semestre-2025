<?php
include 'conecta_bd.php';

$email = $_POST['email'];
$senha = $_POST['senha'];
$endereco = $_POST['endereco'];
$cpf = $_POST['cpf'];

try{
    $sql = 'INSERT INTO pdo(id, email, senha) VALUES ('', '$email', '$senha', '$endereco', '$cpf')';    
}catch(PDOException $e){
    echo $sql.'<br>'.$e->getMessage();
}

$conn = null;
    

?>