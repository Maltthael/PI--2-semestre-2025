<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        body,
        html {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }

        main {
            flex: 1;
        }

        .profile-banner {
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9) 0%, rgba(49, 15, 75, 0.9) 50%, rgba(162, 0, 183, 0.9) 100%);
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .profile-level {
            font-size: 1rem;
            color: #f5f5f5;
        }

        .info-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .info-card h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .info-item {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .info-item i {
            margin-right: 8px;
            color: #333;
        }

        .profile-btn {
            width: 100%;
            margin-bottom: 15px;
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9), rgba(49, 15, 75, 0.9));
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .profile-btn i {
            margin-right: 8px;
        }

        .profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: linear-gradient(90deg, rgba(162, 0, 183, 0.9), rgba(49, 15, 75, 0.9));
        }

        /* Últimos pedidos */
        .pedido-badge {
            padding: 5px 12px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            display: inline-block;
        }

        .status-entregue {
            background-color: #28a745;
        }

        .status-transporte {
            background-color: #fd7e14;
        }

        .status-pendente {
            background-color: #dc3545;
        }

        footer {
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9) 0%, rgba(49, 15, 75, 0.9) 50%, rgba(162, 0, 183, 0.9) 100%);
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        table th, table td {
            border-top: none;
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
        <div class="profile-banner">
            <div class="profile-name"><i class="fas fa-user-circle"></i> Matheus Alexandre</div>
            <div class="profile-level"><i class="fas fa-star"></i> Cliente VIP</div>
        </div>

        <div class="row">
            <!-- Dados do usuário -->
            <div class="col-md-6">
                <div class="info-card">
                    <h5><i class="fas fa-info-circle"></i> Informações do usuário</h5>
                    <hr>
                    <div class="info-item"><i class="fas fa-envelope"></i><strong>Email:</strong> matheus@email.com</div>
                    <div class="info-item"><i class="fas fa-id-card"></i><strong>CPF:</strong> 000.000.000-00</div>
                    <div class="info-item"><i class="fas fa-phone"></i><strong>Telefone:</strong> (11) 99999-9999</div>
                    <div class="info-item"><i class="fas fa-map-marker-alt"></i><strong>Endereço:</strong> Rua Exemplo, 123 - São Paulo, SP</div>
                    <div class="info-item"><i class="fas fa-credit-card"></i><strong>Forma de pagamento:</strong> PIX</div>
                </div>

                <!-- Últimos pedidos -->
                <div class="info-card">
                    <h5><i class="fas fa-shopping-basket"></i> Últimos Pedidos</h5>
                    <hr>
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th>Pedido #</th>
                                <th>Produto</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>001</td>
                                <td>Mouse Gamer RGB</td>
                                <td>20/11/2025</td>
                                <td><span class="pedido-badge status-entregue">Entregue</span></td>
                            </tr>
                            <tr>
                                <td>002</td>
                                <td>Teclado Mecânico ABC</td>
                                <td>21/11/2025</td>
                                <td><span class="pedido-badge status-transporte">Em Transporte</span></td>
                            </tr>
                            <tr>
                                <td>003</td>
                                <td>Monitor 27" 144Hz</td>
                                <td>22/11/2025</td>
                                <td><span class="pedido-badge status-pendente">Pendente</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-start text-center">
                <a href="edit_perfil.html" class="profile-btn"><i class="fas fa-edit"></i> Editar Perfil</a>
                <a href="alterar-senha.html" class="profile-btn"><i class="fas fa-lock"></i> Alterar Senha</a>
                <a href="lista_pedidos.html" class="profile-btn"><i class="fas fa-list"></i> Meus Pedidos</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
