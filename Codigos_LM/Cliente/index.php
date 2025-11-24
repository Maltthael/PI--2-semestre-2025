<?php
session_start();
require_once '../Classes/conecta.php';
include '../Classes/layout.php';

try {
    $pdo = conecta_bd::getInstance()->getConnection();
    
    $sql = "SELECT * FROM estoque WHERE status = 'disponivel' ORDER BY id_produto DESC LIMIT 8";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $produtos = []; 
}
?>

<!DOCTYPE html>
<html lang="pt-br">

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

<?php
 echo $navbar;
?>

    <div id="destaquesCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#destaquesCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#destaquesCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#destaquesCarousel" data-bs-slide-to="2"></button>
        </div>
        
        <div class="carousel-inner">
            
            <div class="carousel-item active">
                <div class="carousel-img-container centraliza-2" style="height: 500px; overflow: hidden;">
                    <img src="img/notebook.png" 
                         alt="Promoção de Notebooks" 
                         style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6);">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold">Notebooks de Alta Performance</h2>
                    <p class="fs-5">Trabalhe ou jogue com a máxima velocidade. Confira nossa linha Dell e Lenovo.</p>
                    <a href="#produtos" class="btn btn-primary btn-lg mt-2">Ver Ofertas</a>
                </div>
            </div>

            <div class="carousel-item">
                <div class="carousel-img-container centraliza-2" style="height: 500px; overflow: hidden;">
                    <img src="img/acessorios-para-games.png" 
                         alt="Acessórios em Promoção"
                         style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6);">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold">Acessórios Gamer</h2>
                    <p class="fs-5">Mouses, teclados mecânicos e headsets para elevar o seu nível.</p>
                    <a href="#produtos" class="btn btn-info text-white btn-lg mt-2">Upgrade no Setup</a>
                </div>
            </div>

            <div class="carousel-item">
                <div class="carousel-img-container centraliza-2" style="height: 500px; overflow: hidden;">
                    <img src="img/pc.png" 
                         alt="Manutenção Especial"
                         style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.5);">
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="fw-bold">Seu PC está lento?</h2>
                    <p class="fs-5">Traz para a LM Informática! Diagnóstico rápido e serviço especializado.</p>
                    <a href="servicos.php" class="btn btn-success btn-lg mt-2">Agendar Visita</a>
                </div>
            </div>

        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#destaquesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#destaquesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

    <section class="produtos-section py-5" id="produtos">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Nossos Produtos</h2>
            <div class="row g-4">
                
                <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $prod): 
                        
                        $caminho_imagem = "../admin/img/produtos/" . $prod['foto'];
                        if (empty($prod['foto']) || !file_exists($caminho_imagem)) {
                            $caminho_imagem = "img/imagem_azul.png"; 
                        }

                        $preco = number_format($prod['preco_venda'], 2, ',', '.');
                        
                        $parcela = number_format($prod['preco_venda'] / 12, 2, ',', '.');
                    ?>

                    <div class="col-md-6 col-lg-3">
                        <div class="card produto-card h-100"> <?php if($prod['preco_venda'] > 2000): ?>
                                <div class="badge-oferta">Oferta</div>
                            <?php endif; ?>

                            <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img src="<?php echo htmlspecialchars($caminho_imagem); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($prod['nome_produto']); ?>"
                                     style="max-height: 100%; width: auto;">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($prod['nome_produto']); ?></h5>
                                
                                <p class="card-text text-muted" style="font-size: 0.9rem;">
                                    <?php echo htmlspecialchars(substr($prod['descricao'], 0, 50)) . '...'; ?>
                                </p>
                                
                                <div class="preco mt-auto">
                                    <span class="preco-atual">R$ <?php echo $preco; ?></span>
                                    <span class="parcelamento d-block">ou 12x de R$ <?php echo $parcela; ?></span>
                                </div>
                                
                                <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Nenhum produto disponível no momento.</p>
                    </div>
                <?php endif; ?>

            </div>
            
            <div class="text-center mt-5">
                <a href="pagina_produtos.php" class="btn btn-outline-primary btn-lg">Ver Todos os Produtos</a>
            </div>
        </div>
    </section>

    <section class="destaques-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Destaques</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="destaque-card text-center p-4">
                        <i class="fas fa-shipping-fast destaque-icon"></i>
                        <h3>Frete Grátis</h3>
                        <p>Para compras acima de R$ 300 em todo o Brasil</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="destaque-card text-center p-4">
                        <i class="fas fa-lock destaque-icon"></i>
                        <h3>Site Seguro</h3>
                        <p>Compra 100% protegida e dados criptografados</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="destaque-card text-center p-4">
                        <i class="fas fa-credit-card destaque-icon"></i>
                        <h3>Parcele em até 12x</h3>
                        <p>No cartão de crédito com parcela mínima de R$ 50</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 footer" style="color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="fundo_imagem">
                        <a class="navbar-brand home-link" href="index.html">
                            <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="nav-item"><a class="nav-link" href="sobre.html">Sobre Nós</a></li>
                        <li class="nav-item"><a class="nav-link" href="servicos.html">Serviços</a></li>
                        <li class="nav-item"><a class="nav-link" href="contato.html">Contato</a></li>
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
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>