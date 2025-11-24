<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        body, html {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        main { flex: 1; }

        .page-banner {
            background: linear-gradient(90deg, rgba(0,0,128,0.9) 0%, rgba(49,15,75,0.9) 50%, rgba(162,0,183,0.9) 100%);
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .card-custom {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .form-control:focus {
            border-color: #a200b7;
            box-shadow: 0 0 0 2px rgba(162,0,183,0.2);
        }

        .btn-save {
            width: 100%;
            margin-top: 15px;
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9));
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: linear-gradient(90deg, rgba(162,0,183,0.9), rgba(49,15,75,0.9));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        footer {
            background: linear-gradient(90deg, rgba(0,0,128,0.9) 0%, rgba(49,15,75,0.9) 50%, rgba(162,0,183,0.9) 100%);
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <div class="fundo_imagem">
                <a class="navbar-brand home-link" href="index.php">
                    <img src="img/LMinformatica_logo_h (2).svg" alt="Logo">
                </a>
            </div>
        </div>
    </nav>

    <main class="container mt-5 pt-5">
        <div class="page-banner">Editar Perfil</div>
        <div class="card-custom">
            <form>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="nome" value="Matheus Alexandre">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" value="matheus@email.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="CPF" class="form-label">CPF</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" id="CPF" value="000.000.000-00">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="formaPagamento" class="form-label">Forma de pagamento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                        <select class="form-select" id="formaPagamento" onchange="toggleCartaoFields()">
                            <option value="PIX" selected>PIX</option>
                            <option value="cartao">Cartão de Crédito</option>
                        </select>
                    </div>
                </div>

                <div id="cartaoCampos" style="display: none;">
                    <div class="mb-3">
                        <label for="numCartao" class="form-label">Número do Cartão</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            <input type="text" class="form-control" id="numCartao" placeholder="0000 0000 0000 0000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="validade" class="form-label">Validade</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="text" class="form-control" id="validade" placeholder="MM/AA">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cvv" class="form-label">CVV</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="text" class="form-control" id="cvv" placeholder="123">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control" id="telefone" value="(11) 99999-9999">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" id="endereco" value="Rua Exemplo, 123 - São Paulo, SP">
                    </div>
                </div>

                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            &copy; 2025 LM Informática. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleCartaoFields() {
            const select = document.getElementById('formaPagamento');
            const campos = document.getElementById('cartaoCampos');
            campos.style.display = select.value === 'cartao' ? 'block' : 'none';
        }
    </script>
</body>
</html>
