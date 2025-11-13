<?php
require_once '../../Classes/conecta.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $sql = "INSERT INTO cliente (nome, email, senha, endereco, numero, bairro, cep, cidade, estado, cpf)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['nome'], $_POST['email'], $_POST['senha'],
            $_POST['endereco'], $_POST['numero'], $_POST['bairro'],
            $_POST['cep'], $_POST['cidade'], $_POST['estado'], $_POST['cpf']
        ]);

        echo json_encode([
            'sucesso' => true,
            'id' => $pdo->lastInsertId()
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => $e->getMessage()
        ]);
    }
}
