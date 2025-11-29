<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: entrar.php");
    exit;
}

require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/cliente.php';

$conn = conecta_bd::getInstance()->getConnection();

$id_cliente = $_SESSION['usuario_id'];

$dados = Cliente::buscarDadosPorId($conn, $id_cliente);
$pedidos = Cliente::buscarUltimosPedidos($conn, $id_cliente);

if (!$dados) {
    echo "Erro ao carregar dados do usuário.";
    exit;
}

$endereco_formatado = htmlspecialchars($dados['endereco']);
if (!empty($dados['numero'])) $endereco_formatado .= ", " . htmlspecialchars($dados['numero']);
if (!empty($dados['bairro'])) $endereco_formatado .= " - " . htmlspecialchars($dados['bairro']);
if (!empty($dados['cidade'])) $endereco_formatado .= " - " . htmlspecialchars($dados['cidade']);
if (!empty($dados['estado'])) $endereco_formatado .= "/" . htmlspecialchars($dados['estado']);
if (!empty($dados['cep'])) $endereco_formatado .= " (CEP: " . htmlspecialchars($dados['cep']) . ")";
?>

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
        body, html { min-height: 100%; display: flex; flex-direction: column; background-color: #f5f5f5; }
        main { flex: 1; }
        .profile-banner {
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9) 0%, rgba(49, 15, 75, 0.9) 50%, rgba(162, 0, 183, 0.9) 100%);
            height: 150px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white; text-align: center; border-radius: 8px; margin-bottom: 30px;
        }
        .profile-name { font-size: 1.8rem; font-weight: bold; }
        .profile-level { font-size: 1rem; color: #f5f5f5; }
        .info-card {
            background-color: white; border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px; margin-bottom: 30px;
        }
        .info-card h5 { margin-bottom: 20px; font-weight: bold; }
        .info-item { margin-bottom: 10px; font-size: 1rem; }
        .info-item i { margin-right: 8px; color: #333; }
        .profile-btn {
            width: 100%; margin-bottom: 15px;
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9), rgba(49, 15, 75, 0.9));
            color: white; border: none; border-radius: 5px; padding: 12px;
            font-weight: bold; transition: all 0.3s ease; display: block; text-align: center;
        }
        .profile-btn i { margin-right: 8px; }
        .profile-btn:hover {
            transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: linear-gradient(90deg, rgba(162, 0, 183, 0.9), rgba(49, 15, 75, 0.9)); color: white;
        }
        .pedido-badge { padding: 5px 12px; border-radius: 12px; color: white; font-weight: bold; display: inline-block; }
        .status-concluido { background-color: #28a745; }
        footer {
            background: linear-gradient(90deg, rgba(0, 0, 128, 0.9) 0%, rgba(49, 15, 75, 0.9) 50%, rgba(162, 0, 183, 0.9) 100%);
            color: white; padding: 20px 0; text-align: center;
        }
        a { text-decoration: none; color: inherit; }
        table th, table td { border-top: none; }
    </style>
</head>

<body>

    <?php echo $navbar; ?>

    <main class="container mt-5 pt-5">
        <div class="profile-banner">
            <div class="profile-name"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($dados['nome']); ?></div>
            <div class="profile-level"><i class="fas fa-star"></i> Cliente</div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="info-card">
                    <h5><i class="fas fa-info-circle"></i> Informações do usuário</h5>
                    <hr>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i><strong>Email:</strong> <?php echo htmlspecialchars($dados['email']); ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-id-card"></i><strong>CPF:</strong> <?php echo htmlspecialchars($dados['cpf']); ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i><strong>Telefone:</strong> <?php echo htmlspecialchars($dados['telefone']); ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i><strong>Endereço:</strong> <?php echo $endereco_formatado; ?>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-credit-card"></i><strong>Forma de pagamento:</strong> À definir
                    </div>
                </div>

                <div class="info-card">
                    <h5><i class="fas fa-shopping-basket"></i> Últimos Pedidos</h5>
                    <hr>
                    
                    <?php if (count($pedidos) > 0): ?>
                        <table class="table text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Data</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pedidos as $ped): ?>
                                <tr>
                                    <td><?php echo $ped['id_vendas']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ped['data_venda'])); ?></td>
                                    <td>R$ <?php echo number_format($ped['valor_total'], 2, ',', '.'); ?></td>
                                    <td><span class="pedido-badge status-concluido">Concluído</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-muted">Você ainda não realizou compras.</p>
                        <div class="text-center">
                            <a href="pagina_produtos.php" class="btn btn-primary btn-sm">Ir para Loja</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="col-md-6 d-flex flex-column justify-content-start text-center">
                <a href="edit_perfil.php" class="profile-btn"><i class="fas fa-edit"></i> Editar Perfil</a>
                <a href="alterar_senha.php" class="profile-btn"><i class="fas fa-lock"></i> Alterar Senha</a>
                <a href="index.php" class="profile-btn bg-danger text-white"><i class="fas fa-sign-out-alt"></i> Sair</a>
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