<?php
include 'conecta_bd.php';

$email = $_POST['email'];
$senha = $_POST['senha'];
$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$cpf = $_POST['cpf'];

$stmt = $conn->prepare("INSERT INTO cliente (email, senha, endereco, numero, bairro, cep, cpf) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssss", $email, $senha, $endereco, $numero, $bairro, $cep, $cpf);

if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
