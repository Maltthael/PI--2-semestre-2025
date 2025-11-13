<?php
session_start();
require_once '../../Classes/conecta.php';

try {
    $pdo = conecta_bd::getInstance()->getConnection();

    $id = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cpf = $_POST['cpf'];

    $sql = "UPDATE cliente SET nome=?, email=?, senha=?, endereco=?, numero=?, bairro=?, cep=?, cidade=?, estado=?, cpf=? WHERE id_cliente=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senha, $endereco, $numero, $bairro, $cep, $cidade, $estado, $cpf, $id]);

    echo json_encode(['status' => 'success', 'mensagem' => 'Cliente atualizado com sucesso!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'mensagem' => 'Erro: ' . $e->getMessage()]);
}
