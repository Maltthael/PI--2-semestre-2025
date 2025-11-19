<?php
session_start();
require_once '../../Classes/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $id = (int)$_POST['id_produto'];
        $nome = $_POST['nome'];
        $categoria_id = (int)$_POST['categoria_id'];
        $quantidade = (int)$_POST['quantidade'];
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];
        
        $preco_custo = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_custo']);
        $preco_venda = str_replace(['R$', '.', ','], ['', '', '.'], $_POST['preco_venda']);

        $novo_nome_imagem = null;
        $erro_upload = "";

        if (isset($_FILES['nova_foto_produto']) && $_FILES['nova_foto_produto']['size'] > 0) {
            
            if ($_FILES['nova_foto_produto']['error'] === UPLOAD_ERR_OK) {
                $extensao = strtolower(pathinfo($_FILES['nova_foto_produto']['name'], PATHINFO_EXTENSION));
                
                if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $novo_nome = "prod_" . uniqid() . "." . $extensao;
                    $pasta_destino = "../img/produtos/";

                    if (!is_dir($pasta_destino)) {
                        mkdir($pasta_destino, 0777, true);
                    }

                    if (move_uploaded_file($_FILES['nova_foto_produto']['tmp_name'], $pasta_destino . $novo_nome)) {
                        $novo_nome_imagem = $novo_nome; 
                        
                        $stmt = $pdo->prepare("SELECT foto FROM estoque WHERE id_produto = ?");
                        $stmt->execute([$id]);
                        $produto_antigo = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($produto_antigo && $produto_antigo['foto'] != 'padrao.png') {
                            $caminho_antigo = $pasta_destino . $produto_antigo['foto'];
                            if (file_exists($caminho_antigo)) {
                                unlink($caminho_antigo);
                            }
                        }
                        
                    } else {
                        $erro_upload = "Falha ao mover a nova foto.";
                    }
                } else {
                    $erro_upload = "Formato de imagem inválido.";
                }
            } else {
                $erro_upload = "Erro no envio do arquivo.";
            }
        }
        
        $sql = "UPDATE estoque SET nome_produto = ?, fk_id_categoria = ?, quantidade = ?, preco_custo = ?, preco_venda = ?, status = ?, descricao = ?";
        $params = [$nome, $categoria_id, $quantidade, $preco_custo, $preco_venda, $status, $descricao];

        if ($novo_nome_imagem) {
            $sql .= ", foto = ?";
            $params[] = $novo_nome_imagem;
        }

        $sql .= " WHERE id_produto = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $mensagem_alerta = "Produto atualizado com sucesso!";
        if (!empty($erro_upload)) {
            $mensagem_alerta = "O produto foi atualizado, mas houve erro com a imagem: $erro_upload";
        }

        echo "<script>alert('$mensagem_alerta'); window.location.href='../produtos.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Erro ao editar: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}
?>