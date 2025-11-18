<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $nome        = $_POST['nome'];
        $categoria   = $_POST['categoria'];
        $quantidade  = $_POST['quantidade'];
        $descricao   = $_POST['descricao'];
        $preco_custo = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_custo']);
        $preco_venda = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_venda']);
        $status = ($quantidade > 0) ? 'disponivel' : 'esgotado';
        $nome_imagem = 'padrao.png';

        if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === UPLOAD_ERR_OK) {
            $arquivo_tmp = $_FILES['foto_produto']['tmp_name'];
            $nome_original = $_FILES['foto_produto']['name'];
            $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extensao, $permitidos)) {
                $novo_nome = "prod_" . uniqid() . "." . $extensao;
                $pasta_destino = "../img/produtos/";

                if (!is_dir($pasta_destino)) {
                    mkdir($pasta_destino, 0755, true);
                }

                if (move_uploaded_file($arquivo_tmp, $pasta_destino . $novo_nome)) {
                    $nome_imagem = $novo_nome;
                }
            }
        }

        $sql = "INSERT INTO estoque (nome_produto, categoria, quantidade, preco_custo, preco_venda, status, foto, descricao) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome,
            $categoria,
            $quantidade,
            $preco_custo,
            $preco_venda,
            $status,
            $nome_imagem,
            $descricao
        ]);

        echo "<script>
            alert('Produto cadastrado com sucesso!');
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
