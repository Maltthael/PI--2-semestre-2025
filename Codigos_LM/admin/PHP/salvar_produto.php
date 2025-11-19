<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $nome = $_POST['nome'];
        $categoria_id = $_POST['categoria_id']; 
        $quantidade = $_POST['quantidade'];
        $descricao = $_POST['descricao'];
        
        $preco_custo = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_custo']);
        $preco_venda = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_venda']);

        $status = ($quantidade > 0) ? 'disponivel' : 'esgotado';

        $nome_imagem = 'padrao.png';
        if (isset($_FILES['foto_produto']) && $_FILES['foto_produto']['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($_FILES['foto_produto']['name'], PATHINFO_EXTENSION));
            if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                $novo_nome = "prod_" . uniqid() . "." . $extensao;
                if (move_uploaded_file($_FILES['foto_produto']['tmp_name'], "../img/produtos/" . $novo_nome)) {
                    $nome_imagem = $novo_nome;
                }
            }
        }

        $sql = "INSERT INTO estoque (nome_produto, fk_id_categoria, quantidade, preco_custo, preco_venda, status, foto, descricao) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $categoria_id, $quantidade, $preco_custo, $preco_venda, $status, $nome_imagem, $descricao]);

        echo "<script>alert('Produto cadastrado com sucesso!'); window.location.href='../produtos.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Erro ao cadastrar: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}
?>