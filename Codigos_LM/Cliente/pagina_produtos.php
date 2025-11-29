<?php
require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/produto.php';

$conn = conecta_bd::getInstance()->getConnection();

$produtoObj = new Produto($conn);

$resultado = $produtoObj->listarComFiltros($_GET);

$lista_categorias = $produtoObj->buscarTodasCategorias();

$preco_max = isset($_GET['preco_max']) ? $_GET['preco_max'] : 5000;
$busca_atual = isset($_GET['busca']) ? $_GET['busca'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - LM Informática</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vendas.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
</head>

<body>
    <?php echo $navbar; ?>
    
    <section class="produtos-section py-5" id="produtos">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Nossos Produtos</h2>

            <div class="row">
                
                <aside class="col-lg-3 col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Filtrar Produtos</h5>
                            
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                                
                                <div class="mb-4">
                                    <h6 class="fw-bold">Pesquisar</h6>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="busca" 
                                               placeholder="Nome do produto..." 
                                               value="<?php echo htmlspecialchars($busca_atual); ?>">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold">Categorias</h6>
                                    <?php if (!empty($lista_categorias)): ?>
                                        <?php foreach($lista_categorias as $cat): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="categorias[]" 
                                                       value="<?php echo $cat['id_categoria']; ?>" 
                                                       id="cat_<?php echo $cat['id_categoria']; ?>"
                                                       <?php if(isset($_GET['categorias']) && in_array($cat['id_categoria'], $_GET['categorias'])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="cat_<?php echo $cat['id_categoria']; ?>">
                                                    <?php echo htmlspecialchars($cat['nome_categoria']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted small">Nenhuma categoria encontrada.</p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <h6 class="fw-bold">Faixa de Preço</h6>
                                    <input type="range" class="form-range" name="preco_max" min="0" max="10000" step="100" 
                                           id="precoRange" value="<?php echo $preco_max; ?>" 
                                           oninput="document.getElementById('valorPreco').innerText = this.value">
                                    <p class="text-muted small mb-0">Até R$ <span id="valorPreco"><?php echo $preco_max; ?></span></p>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                                
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline-secondary w-100 mt-2">Limpar Filtros</a>
                            </form>
                        </div>
                    </div>
                </aside>

                <div class="col-lg-9 col-md-8">
                    <div class="row g-4">
                        
                        <?php if ($resultado->rowCount() > 0): ?>
                            <?php while($produto = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                                
                                <div class="col-md-6 col-lg-4">
                                    <div class="card produto-card h-100">
                                        
                                        <?php 
                                            $nome_arquivo = $produto['foto'];
                                            $caminho_imagem = "../admin/img/produtos/" . $nome_arquivo;

                                            if (!empty($nome_arquivo) && file_exists($caminho_imagem)) {
                                                $imagem_final = $caminho_imagem;
                                            } else {
                                                $imagem_final = "https://via.placeholder.com/300x200?text=Sem+Foto";
                                            }
                                        ?>
                                        
                                        <img src="<?php echo $imagem_final; ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo htmlspecialchars($produto['nome_produto']); ?>"
                                             style="height: 200px; object-fit: contain; padding: 15px; background-color: #fff;">
                                        
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?php echo htmlspecialchars($produto['nome_produto']); ?></h5>
                                            
                                            <p class="card-text text-muted" style="font-size: 0.9em;">
                                                <?php echo htmlspecialchars(substr($produto['descricao'], 0, 80)) . '...'; ?>
                                            </p>
                                            
                                            <div class="preco mt-auto">
                                                <span class="preco-atual">R$ <?php echo number_format($produto['preco_venda'], 2, ',', '.'); ?></span><br>
                                                <span class="parcelamento">ou 10x de R$ <?php echo number_format($produto['preco_venda']/10, 2, ',', '.'); ?></span>
                                            </div>
                                            
                                            <a href="detalhes_produto.php?id=<?php echo $produto['id_produto']; ?>" class="btn btn-primary w-100 mt-3">Ver Detalhes</a>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <div class="alert alert-warning">
                                    <h4>Nenhum produto encontrado! 😕</h4>
                                    <p>Tente buscar por outro nome ou mudar os filtros.</p>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 footer" style="color: white; background-color: #333;">
        <div class="container">
           <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>