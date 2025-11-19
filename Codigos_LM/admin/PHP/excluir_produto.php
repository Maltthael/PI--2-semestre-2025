<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();
        $id = (int)$_POST['id'];

        $stmt = $pdo->prepare("SELECT foto FROM estoque WHERE id_produto = ?");
        $stmt->execute([$id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("DELETE FROM estoque WHERE id_produto = ?");
        $stmt->execute([$id]);

        if ($produto && !empty($produto['foto']) && $produto['foto'] != 'padrao.png') {
            $caminho_foto = "../img/produtos/" . $produto['foto'];
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto); 
            }
        }

        echo "<script>
                alert('Produto excluído com sucesso!'); 
                window.location.href='../produtos.php';
              </script>";

    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            echo "<script>
                    alert('Não é possível excluir este produto pois ele já possui vendas registradas.\\n\\nSugestão: Mude o status para \"Descontinuado\".'); 
                    window.location.href='../produtos.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao excluir: " . addslashes($e->getMessage()) . "'); 
                    window.location.href='../produtos.php';
                  </script>";
        }
    }
} else {
    header("Location: ../produtos.php");
    exit;
}
?>