<?php
require_once '../Classes/conecta.php';
include '../Classes/layout.php';
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
    <style>
        .carrinho-item {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .carrinho-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .quantidade-wrapper button {
            width: 30px;
            padding: 0;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25em 0.4em;
        }
    </style>
</head>

<body>
    <?php
    echo $navbar;
    ?>

    <div class="container mt-5 pt-5">
        <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>

        <div class="row">
            <div class="col-lg-8">
                <div id="carrinho-items">
                    <div class="d-flex align-items-center border rounded mb-3 p-3 bg-white shadow-sm carrinho-item">
                        <div class="me-3 position-relative">
                            <img src="img/imagem_azul.png" width="120" alt="Mouse Gamer RGB" class="rounded">
                            <span class="badge bg-success position-absolute top-0 start-0 m-1">Frete Grátis</span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Mouse Gamer RGB</h5>
                            <p class="text-primary mb-2" style="font-weight: bold; font-size: 1.1rem;">
                                <i class="fas fa-dollar-sign"></i> R$ 150,00
                            </p>
                            <div class="d-flex align-items-center mb-2 quantidade-wrapper">
                                <label for="quantidade1" class="me-2 mb-0"><strong>Qtd:</strong></label>
                                <button class="btn btn-outline-secondary btn-sm me-1 btn-decrease">-</button>
                                <input type="number" id="quantidade1" value="1" min="1" class="form-control text-center"
                                    style="width: 50px;">
                                <button class="btn btn-outline-secondary btn-sm ms-1 btn-increase">+</button>
                            </div>
                            <p class="mb-0"><strong>Subtotal:</strong> <span class="subtotal">R$ 150,00</span></p>
                        </div>
                        <div class="ms-3 text-end">
                            <button class="btn btn-danger btn-sm remover-item"><i class="fas fa-trash-alt"></i>
                                Remover</button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center border rounded mb-3 p-3 bg-white shadow-sm carrinho-item">
                        <div class="me-3 position-relative">
                            <img src="img/imagem_azul.png" width="120" alt="Teclado Mecânico ABC" class="rounded">
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-1">Novo</span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Teclado Mecânico ABC</h5>
                            <p class="text-primary mb-2" style="font-weight: bold; font-size: 1.1rem;">
                                <i class="fas fa-dollar-sign"></i> R$ 350,00
                            </p>
                            <div class="d-flex align-items-center mb-2 quantidade-wrapper">
                                <label for="quantidade2" class="me-2 mb-0"><strong>Qtd:</strong></label>
                                <button class="btn btn-outline-secondary btn-sm me-1 btn-decrease">-</button>
                                <input type="number" id="quantidade2" value="1" min="1" class="form-control text-center"
                                    style="width: 50px;">
                                <button class="btn btn-outline-secondary btn-sm ms-1 btn-increase">+</button>
                            </div>
                            <p class="mb-0"><strong>Subtotal:</strong> <span class="subtotal">R$ 350,00</span></p>
                        </div>
                        <div class="ms-3 text-end">
                            <button class="btn btn-danger btn-sm remover-item"><i class="fas fa-trash-alt"></i>
                                Remover</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="border rounded p-3 bg-white shadow-sm">
                    <h4 class="mb-3">Resumo do Pedido</h4>

                    <p><strong>Subtotal:</strong> <span id="subtotal">R$ 500,00</span></p>
                    <p><strong>Cupom aplicado:</strong> <span id="cupom">Nenhum</span></p>
                    <p><strong>Forma de pagamento:</strong> <span id="forma-pagamento">PIX</span></p>
                    <hr>
                    <p><strong>Total:</strong> <span id="total">R$ 500,00</span></p>
                    <a href="#" class="btn btn-success w-100"><i class="fas fa-credit-card"></i> Finalizar Compra</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 footer" style="margin-top: 150px; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <a class="navbar-brand home-link" href="index.html">
                        <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200">
                    </a>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a class="nav-link active" href="sobre.html">Sobre Nós</a></li>
                        <li><a class="nav-link" href="servicos.html">Serviços</a></li>
                        <li><a class="nav-link" href="contato.html">Contato</a></li>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carrinhoItems = document.querySelectorAll('.carrinho-item');

            carrinhoItems.forEach(item => {
                const input = item.querySelector('input[type="number"]');
                const subtotalSpan = item.querySelector('.subtotal');
                const precoText = item.querySelector('p.text-primary').innerText;
                const preco = parseFloat(precoText.replace('R$', '').replace(',', '.').trim());

                const updateSubtotal = () => {
                    const quantidade = parseInt(input.value);
                    const subtotal = (preco * quantidade).toFixed(2).replace('.', ',');
                    subtotalSpan.innerText = `R$ ${subtotal}`;
                    updateTotal();
                }

                item.querySelector('.btn-increase').addEventListener('click', () => {
                    input.value = parseInt(input.value) + 1;
                    updateSubtotal();
                });

                item.querySelector('.btn-decrease').addEventListener('click', () => {
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateSubtotal();
                    }
                });

                input.addEventListener('change', updateSubtotal);
            });

            const updateTotal = () => {
                let total = 0;
                carrinhoItems.forEach(item => {
                    const subtotalText = item.querySelector('.subtotal').innerText;
                    const subtotalNum = parseFloat(subtotalText.replace('R$', '').replace(',', '.').trim());
                    total += subtotalNum;
                });
                document.getElementById('total').innerText = `R$ ${total.toFixed(2).replace('.', ',')}`;
            }

            updateTotal();
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>