<?php
session_start();
require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/produto.php';
require_once '../Classes/Carrinho.php';

$conn = conecta_bd::getInstance()->getConnection();
$produtoObj = new Produto($conn);
$carrinhoObj = new Carrinho();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'add') {
    $id = intval($_POST['id_produto']);
    $qtd = intval($_POST['quantidade']);
    if ($id > 0 && $qtd > 0) $carrinhoObj->adicionar($id, $qtd);
    header("Location: carrinho.php");
    exit;
}


if (isset($_GET['acao']) && $_GET['acao'] === 'remover' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $carrinhoObj->remover($id);
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] === 'alterar' && isset($_GET['id']) && isset($_GET['qtd'])) {
    $id = intval($_GET['id']);
    $qtd = intval($_GET['qtd']);
    $carrinhoObj->atualizarQuantidade($id, $qtd);
    header("Location: carrinho.php");
    exit;
}

$itens_sessao = $carrinhoObj->getItens();
$dados_carrinho = [];
$valor_total_pedido = 0;

if (!empty($itens_sessao)) {
    foreach ($itens_sessao as $id_prod => $quantidade) {
        $detalhes = $produtoObj->buscarPorId($id_prod);
        if ($detalhes) {
            $subtotal = $detalhes['preco_venda'] * $quantidade;
            $valor_total_pedido += $subtotal;
            
            $dados_carrinho[] = [
                'id' => $detalhes['id_produto'],
                'nome' => $detalhes['nome_produto'],
                'foto' => $detalhes['foto'],
                'preco' => $detalhes['preco_venda'],
                'qtd' => $quantidade,
                'subtotal' => $subtotal
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vendas.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        .carrinho-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .carrinho-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .quantidade-wrapper a {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            line-height: 1;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.25em 0.4em;
        }
    </style>
</head>

<body>
    <?php echo $navbar; ?>

    <div class="container mt-5 pt-5">
        <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>

        <?php if (empty($dados_carrinho)): ?>
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <i class="fas fa-shopping-basket fa-4x text-muted mb-3"></i>
                <h3>Seu carrinho está vazio.</h3>
                <p class="text-muted">Navegue por nossos produtos e aproveite as ofertas!</p>
                <a href="pagina_produtos.php" class="btn btn-primary mt-3">Continuar Comprando</a>
            </div>
        <?php else: ?>

        <div class="row">
            <div class="col-lg-8">
                <div id="carrinho-items">
                    
                    <?php foreach ($dados_carrinho as $item): ?>
                        <?php 
                            $caminho = "../admin/img/produtos/" . $item['foto'];
                            $img_src = (!empty($item['foto']) && file_exists($caminho)) ? $caminho : "https://via.placeholder.com/120?text=Sem+Foto";
                        ?>

                        <div class="d-flex align-items-center border rounded mb-3 p-3 bg-white shadow-sm carrinho-item">
                            <div class="me-3 position-relative">
                                <img src="<?php echo $img_src; ?>" width="120" alt="<?php echo htmlspecialchars($item['nome']); ?>" class="rounded" style="object-fit: contain; height: 100px;">
                                <span class="badge bg-success position-absolute top-0 start-0 m-1">Disponível</span>
                            </div>
                            
                            <div class="flex-grow-1">
                                <h5 class="mb-1">
                                    <a href="detalhes_produto.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($item['nome']); ?>
                                    </a>
                                </h5>
                                <p class="text-primary mb-2" style="font-weight: bold; font-size: 1.1rem;">
                                    R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                </p>
                                
                                <div class="d-flex align-items-center mb-2 quantidade-wrapper">
                                    <label class="me-2 mb-0"><strong>Qtd:</strong></label>
                                    
                                    <a href="carrinho.php?acao=alterar&id=<?php echo $item['id']; ?>&qtd=<?php echo $item['qtd'] - 1; ?>" 
                                       class="btn btn-outline-secondary btn-sm me-1">
                                        -
                                    </a>

                                    <input type="number" readonly value="<?php echo $item['qtd']; ?>" class="form-control text-center" style="width: 50px;">
                                    
                                    <a href="carrinho.php?acao=alterar&id=<?php echo $item['id']; ?>&qtd=<?php echo $item['qtd'] + 1; ?>" 
                                       class="btn btn-outline-secondary btn-sm ms-1">
                                        +
                                    </a>
                                </div>
                                <p class="mb-0"><strong>Subtotal:</strong> <span class="subtotal text-dark">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></span></p>
                            </div>
                            
                            <div class="ms-3 text-end">
                                <a href="carrinho.php?acao=remover&id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm remover-item">
                                    <i class="fas fa-trash-alt"></i> Remover
                                </a>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
                
                <div class="mt-3 mb-4">
                    <a href="pagina_produtos.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="border rounded p-3 bg-white shadow-sm position-sticky" style="top: 100px;">
                    <h4 class="mb-3">Resumo do Pedido</h4>

                    <div class="d-flex justify-content-between">
                        <p><strong>Subtotal:</strong></p>
                        <p>R$ <?php echo number_format($valor_total_pedido, 2, ',', '.'); ?></p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <p><strong>Frete:</strong></p>
                        <p class="text-success">Grátis</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <p><strong>Forma de pagamento:</strong></p>
                        <p>A definir</p>
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <p class="fs-5"><strong>Total:</strong></p>
                        <p class="fs-4 text-primary fw-bold">R$ <?php echo number_format($valor_total_pedido, 2, ',', '.'); ?></p>
                    </div>
                    
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <a href="checkout.php" class="btn btn-success w-100 py-2 fs-5">
                            <i class="fas fa-check-circle me-2"></i> Finalizar Compra
                        </a>
                    <?php else: ?>
                        <div class="alert alert-warning small">
                            Você precisa entrar na conta para finalizar.
                        </div>
                        <a href="entrar.php" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i> Fazer Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>

    <footer class="text-center py-4 footer" style="margin-top: 150px; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <a class="navbar-brand home-link" href="index.php">
                        <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200">
                    </a>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a class="nav-link active" href="sobre.php">Sobre Nós</a></li>
                        <li><a class="nav-link" href="servicos.php">Serviços</a></li>
                        <li><a class="nav-link" href="contato.php">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> (XX) XXXX-XXXX</li>
                        <li><i class="fas fa-envelope me-2"></i> contato@lminformatica.com.br</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>