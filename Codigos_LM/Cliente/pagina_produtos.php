<?php
require_once '../Classes/conecta.php';
include '../Classes/layout.php';
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
    <?php
     echo $navbar;
    ?>
    <section class="produtos-section py-5" id="produtos">
        <div class="container">
            <h2 class="text-center mb-5 section-title">Nossos Produtos</h2>

            <div class="row">
                <aside class="col-lg-3 col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Filtrar Produtos</h5>

                            <div class="mb-4">
                                <h6 class="fw-bold">Categoria</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notebooks">
                                    <label class="form-check-label" for="notebooks">Notebooks</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="perifericos">
                                    <label class="form-check-label" for="perifericos">Periféricos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="armazenamento">
                                    <label class="form-check-label" for="armazenamento">Armazenamento</label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-bold">Faixa de Preço</h6>
                                <input type="range" class="form-range" min="0" max="5000" step="100" id="precoRange">
                                <p class="text-muted small mb-0">Até R$ <span id="valorPreco">5000</span></p>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-bold">Marca</h6>
                                <select class="form-select">
                                    <option selected>Todas</option>
                                    <option>Dell</option>
                                    <option>Logitech</option>
                                    <option>Kingston</option>
                                    <option>Redragon</option>
                                </select>
                            </div>

                            <button class="btn btn-primary w-100">Aplicar Filtros</button>
                        </div>
                    </div>
                </aside>

                <div class="col-lg-9 col-md-8">
                    <div class="row g-4">

                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <div class="badge-oferta">-20%</div>
                                <img src="img/imagem_azul.png" class="card-img-top" alt="Notebook Dell Inspiron">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Notebook Dell Inspiron</h5>
                                    <p class="card-text">i5 10ª geração, 8GB RAM, SSD 256GB</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-antigo">R$ 3.999,00</span><br>
                                        <span class="preco-atual">R$ 3.199,00</span><br>
                                        <span class="parcelamento">ou 12x de R$ 299,90</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <img src="img/imagem_azul.png" class="card-img-top" alt="Mouse Gamer">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Mouse Gamer Redragon</h5>
                                    <p class="card-text">RGB, 12400DPI, 7 botões programáveis</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-atual">R$ 199,90</span><br>
                                        <span class="parcelamento">ou 3x de R$ 66,63</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <div class="badge-oferta">-15%</div>
                                <img src="img/imagem_azul.png" class="card-img-top" alt="SSD Kingston">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">SSD Kingston 480GB</h5>
                                    <p class="card-text">SATA III, Leitura 500MB/s</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-antigo">R$ 299,90</span><br>
                                        <span class="preco-atual">R$ 254,90</span><br>
                                        <span class="parcelamento">ou 4x de R$ 63,73</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <div class="badge-oferta">-15%</div>
                                <img src="img/imagem_azul.png" class="card-img-top" alt="SSD Kingston">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">SSD Kingston 480GB</h5>
                                    <p class="card-text">SATA III, Leitura 500MB/s</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-antigo">R$ 299,90</span><br>
                                        <span class="preco-atual">R$ 254,90</span><br>
                                        <span class="parcelamento">ou 4x de R$ 63,73</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <div class="badge-oferta">-15%</div>
                                <img src="img/imagem_azul.png" class="card-img-top" alt="SSD Kingston">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">SSD Kingston 480GB</h5>
                                    <p class="card-text">SATA III, Leitura 500MB/s</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-antigo">R$ 299,90</span><br>
                                        <span class="preco-atual">R$ 254,90</span><br>
                                        <span class="parcelamento">ou 4x de R$ 63,73</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card produto-card h-100">
                                <div class="badge-oferta">-15%</div>
                                <img src="img/imagem_azul.png" class="card-img-top" alt="SSD Kingston">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">SSD Kingston 480GB</h5>
                                    <p class="card-text">SATA III, Leitura 500MB/s</p>
                                    <div class="preco mt-auto">
                                        <span class="preco-antigo">R$ 299,90</span><br>
                                        <span class="preco-atual">R$ 254,90</span><br>
                                        <span class="parcelamento">ou 4x de R$ 63,73</span>
                                    </div>
                                    <a href="#" class="btn btn-primary w-100 mt-3">Comprar</a>
                                </div>
                            </div>
                        </div>
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
                        <li class="nav-item">
                            <a class="nav-link active" href="sobre.html">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="servicos.html">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contato.html">Contato</a>
                        </li>
                        <li>
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
</body>

</html>