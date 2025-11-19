<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();
        
        $nome_categoria = trim($_POST['nome_categoria']);

        if (!empty($nome_categoria)) {
            
            $stmt = $pdo->prepare("SELECT id_categoria FROM categorias WHERE nome_categoria = ?");
            $stmt->execute([$nome_categoria]);
            
            if ($stmt->rowCount() > 0) {
                echo "<script>
                        alert('A categoria \"$nome_categoria\" já existe!'); 
                        window.history.back();
                      </script>";
                exit;
            }

            $sql = "INSERT INTO categorias (nome_categoria) VALUES (?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome_categoria]);

            echo "<script>
                    alert('Categoria cadastrada com sucesso!'); 
                    window.location.href='../produtos.php';
                  </script>";
        } else {
            echo "<script>alert('O nome da categoria não pode ser vazio.'); window.history.back();</script>";
        }

    } catch (Exception $e) {
        echo "<script>alert('Erro ao salvar: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
} else {
    header("Location: ../produtos.php");
    exit;
}
?>
