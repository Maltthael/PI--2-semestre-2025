<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $id = $_POST['id_cliente'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        $sql = "UPDATE cliente SET 
                    nome = ?, 
                    email = ?, 
                    telefone = ?,
                    cpf = ?, 
                    cep = ?, 
                    endereco = ?, 
                    numero = ?, 
                    bairro = ?, 
                    cidade = ?, 
                    estado = ? 
                WHERE id_cliente = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $cpf, $cep, $endereco, $numero, $bairro, $cidade, $estado, $id]);

        echo "<script>alert('Dados atualizados com sucesso!'); window.location.href='../clientes.php';</script>";
        
    } catch (Exception $e) {
        echo "<script>alert('Erro ao atualizar: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    header("Location: ../clientes.php");
    exit;
}
?>