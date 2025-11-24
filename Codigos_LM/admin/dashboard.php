<?php
session_start();
require_once '../Classes/conecta.php';
include '../Classes/layout.php';

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../Cliente/entrar.php");
    exit;
}

try {
    $pdo = conecta_bd::getInstance()->getConnection();

    $clientes_total = $pdo->query("SELECT COUNT(*) FROM cliente")->fetchColumn();

    $produtos_total = $pdo->query("SELECT COUNT(*) FROM estoque")->fetchColumn();

    $os_abertas = $pdo->query("SELECT COUNT(*) FROM ordem_servico WHERE status NOT IN ('concluido', 'cancelado')")->fetchColumn();

    $hoje = date('Y-m-d');
    $os_atrasadas = $pdo->query("SELECT COUNT(*) FROM ordem_servico WHERE prazo < '$hoje' AND status NOT IN ('concluido', 'cancelado')")->fetchColumn();

    $sql_proximas = "SELECT os.*, c.nome as nome_cliente 
                     FROM ordem_servico os 
                     JOIN cliente c ON os.fk_cliente_id_cliente = c.id_cliente
                     WHERE os.status NOT IN ('concluido', 'cancelado')
                     ORDER BY os.prazo ASC LIMIT 5";
    $proximas_os = $pdo->query($sql_proximas)->fetchAll(PDO::FETCH_ASSOC);

    $estoque_baixo = $pdo->query("SELECT nome_produto, quantidade FROM estoque WHERE quantidade < 5 ORDER BY quantidade ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $clientes_total = $produtos_total = $os_abertas = $os_atrasadas = 0;
    $proximas_os = [];
    $estoque_baixo = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php echo $head; ?>
    <style>
        .card-kpi {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            overflow: hidden;
        }
        .card-kpi:hover {
            transform: translateY(-5px);
        }
        .kpi-icon {
            font-size: 2.5rem;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        .card-title-kpi {
            font-size: 0.9rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .card-value-kpi {
            font-size: 2rem;
            font-weight: 700;
        }
        .bg-gradient-blue { background: linear-gradient(45deg, #4099ff, #73b4ff); color: white; }
        .bg-gradient-green { background: linear-gradient(45deg, #2ed8b6, #59e0c5); color: white; }
        .bg-gradient-yellow { background: linear-gradient(45deg, #FFB64D, #ffcb80); color: white; }
        .bg-gradient-red { background: linear-gradient(45deg, #FF5370, #ff869a); color: white; }
        
        .table-custom th { background-color: #f8f9fa; border-top: none; }
    </style>
</head>

<body>
    
    <?php echo $navbar_adm; ?>

    <div class="container mt-4 mb-5">
        
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="fw-bold text-dark">Dashboard Geral</h3>
                <p class="text-muted">Visão geral do sistema</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card card-kpi bg-gradient-blue h-100">
                    <div class="card-body">
                        <h6 class="card-title-kpi">Total Clientes</h6>
                        <h2 class="card-value-kpi"><?php echo $clientes_total; ?></h2>
                        <i class="fas fa-users kpi-icon"></i>
                        <small>Cadastrados no sistema</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-kpi bg-gradient-green h-100">
                    <div class="card-body">
                        <h6 class="card-title-kpi">Produtos</h6>
                        <h2 class="card-value-kpi"><?php echo $produtos_total; ?></h2>
                        <i class="fas fa-box-open kpi-icon"></i>
                        <small>Itens em estoque</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-kpi bg-gradient-yellow h-100">
                    <div class="card-body">
                        <h6 class="card-title-kpi">Serviços Ativos</h6>
                        <h2 class="card-value-kpi"><?php echo $os_abertas; ?></h2>
                        <i class="fas fa-tools kpi-icon"></i>
                        <small>Ordens em andamento</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-kpi bg-gradient-red h-100">
                    <div class="card-body">
                        <h6 class="card-title-kpi">Atrasados</h6>
                        <h2 class="card-value-kpi"><?php echo $os_atrasadas; ?></h2>
                        <i class="fas fa-exclamation-triangle kpi-icon"></i>
                        <small>Precisam de atenção!</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-clock text-primary me-2"></i>Próximos Prazos (OS)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Cliente</th>
                                        <th>Serviço</th>
                                        <th>Prazo</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($proximas_os) > 0): ?>
                                        <?php foreach($proximas_os as $os): 
                                            $data_prazo = date('d/m/Y', strtotime($os['prazo']));
                                            $badge = 'bg-secondary';
                                            if($os['status'] == 'pendente') $badge = 'bg-warning text-dark';
                                            if($os['status'] == 'em_andamento') $badge = 'bg-info text-dark';
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?php echo htmlspecialchars($os['nome_cliente']); ?></td>
                                            <td><?php echo htmlspecialchars($os['titulo']); ?></td>
                                            <td><?php echo $data_prazo; ?></td>
                                            <td><span class="badge <?php echo $badge; ?>"><?php echo ucfirst($os['status']); ?></span></td>
                                            <td>
                                                <a href="servicos.php" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="5" class="text-center py-4 text-muted">Nenhuma ordem pendente.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-battery-quarter text-danger me-2"></i>Estoque Baixo</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php if(count($estoque_baixo) > 0): ?>
                                <?php foreach($estoque_baixo as $prod): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($prod['nome_produto']); ?></h6>
                                        <small class="text-danger fw-bold">Repor estoque!</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill fs-6"><?php echo $prod['quantidade']; ?> un</span>
                                </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-center py-4 text-muted">Estoque está saudável!</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="card-footer bg-white text-center border-0 pb-3">
                         <a href="produtos.php" class="btn btn-sm btn-link text-decoration-none">Ver todo estoque &rarr;</a>
                    </div>
                </div>
            </div>

        </div> </div> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['alert']) && !empty($_SESSION['alert'])) {
        echo "<script>
            Swal.fire({
                icon: '{$_SESSION['alert']['icon']}',
                title: '{$_SESSION['alert']['title']}',
                text: '{$_SESSION['alert']['message']}',
                confirmButtonColor: '#0d6efd'
            });
        </script>";
        unset($_SESSION['alert']);
    }
    ?>

</body>
</html>
