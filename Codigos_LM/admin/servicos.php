<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    session_start();
    include '../Classes/layout.php';
    require_once '../Classes/conecta.php';
    echo $head;
    ?>
    <style>
        .service-icon {
            width: 45px;
            height: 45px;
            background-color: #f1f3f5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #2c3e50;
            margin-right: 15px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php echo $navbar_adm; ?>

    <?php
    try {
        $pdo = conecta_bd::getInstance()->getConnection();

        $busca = $_GET['busca'] ?? '';

        $sql = "SELECT os.id_ordem, os.titulo, os.prazo, os.status, os.fk_cliente_id_cliente, c.nome AS nome_cliente 
                FROM ordem_servico os 
                LEFT JOIN cliente c ON os.fk_cliente_id_cliente = c.id_cliente";

        if (!empty($busca)) {
            $sql .= " WHERE c.nome LIKE :busca OR os.titulo LIKE :busca";
        }

        $sql .= " ORDER BY os.prazo ASC";

        $stmt = $pdo->prepare($sql);

        if (!empty($busca)) {
            $stmt->bindValue(':busca', "%$busca%");
        }

        $stmt->execute();
        $lista_os = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt_clientes = $pdo->query("SELECT id_cliente, nome FROM cliente ORDER BY nome ASC");
        $lista_clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $lista_os = [];
        $lista_clientes = [];
    }
    ?>

    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold text-dark">Ordens de Serviço</h2>
                <p class="text-muted">Gerencie as ordens conforme seu banco de dados.</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNovaOS">
                <i class="fas fa-plus-circle"></i> Nova Ordem de Serviço
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-1">Total OS</h6>
                        <h3 class="fw-bold mb-0"><?= count($lista_os) ?></h3>
                        <small class="text-warning"><i class="fas fa-clipboard-list me-1"></i> Registradas</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold">Lista de Serviços</h5>

                <form method="GET" action="" class="d-flex gap-2" style="max-width: 400px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="busca" class="form-control border-start-0"
                            placeholder="Buscar cliente ou serviço..."
                            value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>

                    <?php if (!empty($_GET['busca'])): ?>
                        <a href="servicos.php" class="btn btn-light border" title="Limpar Filtros">
                            <i class="fas fa-times text-danger"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID / Título do Serviço</th>
                                <th>Cliente</th>
                                <th>Prazo</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($lista_os) > 0): ?>
                                <?php foreach ($lista_os as $os):
                                    $data_prazo = new DateTime($os['prazo']);
                                    $hoje = new DateTime();
                                    $atrasado = $hoje > $data_prazo;
                                    $texto_prazo = $data_prazo->format('d/m/Y H:i');
                                ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="service-icon"><i class="fas fa-tools"></i></div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($os['titulo']) ?></div>
                                                    <div class="small text-muted">OS #<?= str_pad($os['id_ordem'], 4, '0', STR_PAD_LEFT) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-user-circle text-muted me-1"></i>
                                            <?= htmlspecialchars($os['nome_cliente'] ?? 'N/A') ?>
                                        </td>
                                        <td>
                                            <span class="<?= $atrasado ? 'text-danger fw-bold' : 'text-dark' ?>">
                                                <?= $texto_prazo ?>
                                            </span>
                                            <?php if ($atrasado): ?><br><small class="text-danger">Atrasado</small><?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info text-dark bg-opacity-25 border border-info">
                                                <?= strtoupper($os['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light text-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdicaoOS"
                                                data-id="<?= $os['id_ordem'] ?>"
                                                data-titulo="<?= htmlspecialchars($os['titulo']) ?>"
                                                data-cliente="<?= $os['fk_cliente_id_cliente'] ?>"
                                                data-prazo="<?= date('d-m-y\H:i', strtotime($os['prazo'])) ?>"
                                                data-status="<?= $os['status'] ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <form action="../Classes/admin.php" method="POST" style="display:inline;"
                                                onsubmit="confirmarExclusao(event, 'OS #<?= $os['id_ordem'] ?>')">
                                                <input type="hidden" name="action" value="excluir_ordem">
                                                <input type="hidden" name="id_ordem" value="<?= $os['id_ordem'] ?>">
                                                <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Nenhuma ordem de serviço encontrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovaOS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold"><i class="fas fa-file-medical me-2"></i>Nova Ordem de Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../Classes/admin.php" method="POST">
                        <input type="hidden" name="action" value="salvar_ordem">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Título / Descrição do Serviço</label>
                                <input type="text" class="form-control" name="titulo" placeholder="Ex: Formatação PC Gamer" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Cliente</label>
                                <select class="form-select" name="id_cliente" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    <?php foreach ($lista_clientes as $cli): ?>
                                        <option value="<?= $cli['id_cliente'] ?>"><?= htmlspecialchars($cli['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Prazo de Entrega</label>
                                <input type="datetime-local" class="form-control" name="prazo" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status Inicial</label>
                                <select class="form-select" name="status" required>
                                    <option value="aberto">Aberto</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer bg-light mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Salvar OS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdicaoOS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Editar Ordem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../Classes/admin.php" method="POST">
                        <input type="hidden" name="action" value="editar_ordem">
                        <input type="hidden" name="id_ordem" id="edit_id_ordem">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" name="titulo" id="edit_titulo" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Cliente</label>
                                <select class="form-select" name="id_cliente" id="edit_id_cliente" required>
                                    <?php foreach ($lista_clientes as $cli): ?>
                                        <option value="<?= $cli['id_cliente'] ?>"><?= htmlspecialchars($cli['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prazo</label>
                                <input type="datetime-local" class="form-control" name="prazo" id="edit_prazo" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status" required>
                                    <option value="aberto">Aberto</option>
                                    <option value="em_andamento">Em Andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-light mt-3 pb-0">
                            <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>

</body>

</html>