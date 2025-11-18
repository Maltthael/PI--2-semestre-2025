<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $categoria   = $_POST['nome_categoria'];

        $sql = "INSERT INTO estoque (categoria) 
                VALUES (?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $categoria
        ]);

        echo "<script>
            alert('Categpria cadastrado com sucesso!');
            window.location.href='../produtos.php';
        </script>";

    } catch (Exception $e) {
        echo "<script>
            alert('Erro ao cadastrar: " . addslashes($e->getMessage()) . "');
            window.history.back();
        </script>";
    }
} else {
    header("Location: ../produtos.php");
    exit;
}
?>
