<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
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
            max-width: 900px;
            margin: 0 auto;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table th i, .table td i {
            margin-right: 5px;
            color: #333;
        }

        .btn-back {
            width: 100%;
            margin-top: 15px;
            background: rgba(162,0,183,0.1);
            color: #a200b7;
            border: 1px solid #a200b7;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-back i {
            margin-right: 8px;
        }

        .btn-back:hover {
            background: rgba(162,0,183,0.2);
            transform: scale(1.02);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            display: inline-block;
        }
        .status-entregue { background-color: #28a745; } 
        .status-transporte { background-color: #fd7e14; } 
        .status-pendente { background-color: #dc3545; }

        footer {
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        @media (max-width: 767px) {
            .card-custom { padding: 15px; }
            table { font-size: 14px; }
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
        <div class="page-banner"> Meus Pedidos</div>
        <div class="card-custom">
            <div class="table-responsive">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> Pedido #</th>
                            <th><i class="fas fa-box"></i> Produto</th>
                            <th><i class="fas fa-calendar-alt"></i> Data</th>
                            <th><i class="fas fa-dollar-sign"></i> Preço</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-hashtag"></i> 001</td>
                            <td><i class="fas fa-mouse"></i> Mouse Gamer RGB</td>
                            <td><i class="fas fa-calendar-alt"></i> 20/11/2025</td>
                            <td><i class="fas fa-dollar-sign"></i> R$ 150,00</td>
                            <td><span class="status-badge status-entregue"><i class="fas fa-check"></i> Entregue</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-hashtag"></i> 002</td>
                            <td><i class="fas fa-keyboard"></i> Teclado Mecânico ABC</td>
                            <td><i class="fas fa-calendar-alt"></i> 21/11/2025</td>
                            <td><i class="fas fa-dollar-sign"></i> R$ 350,00</td>
                            <td><span class="status-badge status-transporte"><i class="fas fa-truck"></i> Em Transporte</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-hashtag"></i> 003</td>
                            <td><i class="fas fa-desktop"></i> Monitor 27" 144Hz</td>
                            <td><i class="fas fa-calendar-alt"></i> 22/11/2025</td>
                            <td><i class="fas fa-dollar-sign"></i> R$ 1.200,00</td>
                            <td><span class="status-badge status-pendente"><i class="fas fa-hourglass-half"></i> Pendente</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="perfil.html" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar para Perfil</a>
        </div>
    </main>

    <footer class="fixed-bottom">
        &copy; 2025 LM Informática. Todos os direitos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
