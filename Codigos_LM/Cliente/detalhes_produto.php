<?php
require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/produto.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: produtos.php");
    exit;
}

$id_produto = $_GET['id'];

$conn = conecta_bd::getInstance()->getConnection();
$produtoObj = new Produto($conn);

$detalhes = $produtoObj->buscarPorId($id_produto);

if (!$detalhes) {
    header("Location: produtos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($detalhes['nome_produto']); ?> - LM Informática</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vendas.css"> <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    
    <style>
        .img-detalhe-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .img-detalhe {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
        }
        .preco-grande {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .detalhe-info {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
        }
    </style>
</head>

<body>
    <?php echo $navbar; ?>
    
    <div class="container py-5" style="margin-top: 80px;"> <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pagina_produtos.php">Produtos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>

        <div class="row mt-4">
            
            <div class="col-md-6 mb-4">
                <div class="img-detalhe-container">
                    <?php 
                        $nome_arquivo = $detalhes['foto'];
                        $caminho_imagem = "../admin/img/produtos/" . $nome_arquivo;

                        if (!empty($nome_arquivo) && file_exists($caminho_imagem)) {
                            $imagem_final = $caminho_imagem;
                        } else {
                            $imagem_final = "https://via.placeholder.com/500x500?text=Sem+Foto";
                        }
                    ?>
                    <img src="<?php echo $imagem_final; ?>" alt="<?php echo htmlspecialchars($detalhes['nome_produto']); ?>" class="img-detalhe">
                </div>
            </div>

            <div class="col-md-6">
                <div class="detalhe-info h-100">
                    <h1 class="mb-2"><?php echo htmlspecialchars($detalhes['nome_produto']); ?></h1>
                    
                    <div class="mb-3">
                        <?php if($detalhes['quantidade'] > 0 && $detalhes['status'] == 'disponivel'): ?>
                            <span class="badge bg-success">Em Estoque</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Esgotado</span>
                        <?php endif; ?>
                        
                        <span class="text-muted ms-2">Cód: <?php echo $detalhes['id_produto']; ?></span>
                    </div>

                    <div class="preco-area mb-4">
                        <span class="text-muted text-decoration-line-through">De: R$ <?php echo number_format($detalhes['preco_venda'] * 1.2, 2, ',', '.'); ?></span><br>
                        <span class="preco-grande">R$ <?php echo number_format($detalhes['preco_venda'], 2, ',', '.'); ?></span>
                        <p class="text-muted">À vista ou em até 10x de R$ <?php echo number_format($detalhes['preco_venda']/10, 2, ',', '.'); ?> sem juros</p>
                    </div>

                    <form action="carrinho.php" method="POST" class="mb-4">
                        <input type="hidden" name="acao" value="add">
                        <input type="hidden" name="id_produto" value="<?php echo $detalhes['id_produto']; ?>">
                        
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="qtd" class="col-form-label fw-bold">Quantidade:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="qtd" name="quantidade" class="form-control text-center" value="1" min="1" max="<?php echo $detalhes['quantidade']; ?>" style="width: 80px;">
                            </div>
                            <div class="col">
                                <?php if($detalhes['quantidade'] > 0 && $detalhes['status'] == 'disponivel'): ?>
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-shopping-cart me-2"></i> Adicionar ao Carrinho
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                                        Produto Indisponível
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <h4 class="mt-4">Descrição do Produto</h4>
                    <p class="mt-3" style="line-height: 1.6; color: #555;">
                        <?php echo nl2br(htmlspecialchars($detalhes['descricao'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 footer mt-5" style="color: white; background-color: #333;">
        <div class="container">
           <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>