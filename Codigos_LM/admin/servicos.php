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
        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <?php echo $navbar_adm; ?>

    <?php
    // Lógica PHP para buscar dados (Simulada/Preparada)
    try {
        $pdo = conecta_bd::getInstance()->getConnection();
        // Query unindo Ordem de Serviço com Cliente para mostrar o nome dele
        $sql = "SELECT os.id_ordem, os.titulo, os.prazo, os.acao, c.nome AS nome_cliente 
                FROM ordem_servico os 
                LEFT JOIN cliente c ON os.fk_cliente_id_cliente = c.id_cliente
                ORDER BY os.prazo ASC"; // Ordena pelos prazos mais urgentes
        $stmt = $pdo->query($sql);
        $lista_os = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $lista_os = [];
        // Em produção, você pode remover esse echo ou tratar melhor o erro
    }
    ?>

    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold text-dark">Ordens de Serviço</h2>
                <p class="text-muted">Acompanhe o andamento dos reparos e manutenções.</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNovaOS">
                <i class="fas fa-plus-circle"></i> Nova Ordem de Serviço
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-1">Pendentes</h6>
                        <h3 class="fw-bold mb-0">12</h3>
                        <small class="text-warning"><i class="fas fa-clock me-1"></i> Aguardando aprovação</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-1">Em Andamento</h6>
                        <h3 class="fw-bold mb-0">8</h3>
                        <small class="text-primary"><i class="fas fa-tools me-1"></i> Na bancada</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-1">Concluídos (Mês)</h6>
                        <h3 class="fw-bold mb-0">45</h3>
                        <small class="text-success"><i class="fas fa-check-circle me-1"></i> Pronto para retirada</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-1">Atrasados</h6>
                        <h3 class="fw-bold mb-0">2</h3>
                        <small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Atenção necessária</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-dark">Todos</button>
                    <button class="btn btn-sm btn-outline-secondary">Abertos</button>
                    <button class="btn btn-sm btn-outline-secondary">Finalizados</button>
                </div>
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Buscar por OS, cliente...">
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Serviço / Descrição</th>
                                <th>Cliente</th>
                                <th>Prazo</th>
                                <th>Prioridade</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($lista_os) > 0): ?>
                                <?php foreach ($lista_os as $os): 
                                    // Formatação de data
                                    $data_prazo = new DateTime($os['prazo']);
                                    $hoje = new DateTime();
                                    $dias_restantes = $hoje->diff($data_prazo)->days;
                                    $atrasado = $hoje > $data_prazo;
                                ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="service-icon">
                                                <i class="fas fa-laptop-medical"></i> </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($os['titulo']) ?></div>
                                                <div class="small text-muted">OS #<?= str_pad($os['id_ordem'], 4, '0', STR_PAD_LEFT) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-medium"><?= htmlspecialchars($os['nome_cliente'] ?? 'Cliente não identificado') ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="<?= $atrasado ? 'text-danger fw-bold' : 'text-dark' ?>">
                                                <?= $data_prazo->format('d/m/Y') ?>
                                            </span>
                                            <small class="text-muted">
                                                <?= $atrasado ? 'Atrasado' : $dias_restantes . ' dias restantes' ?>
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark bg-opacity-25 border border-warning">Média</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">Em Análise</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php echo $botao_tabela_servico; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="service-icon"><i class="fas fa-microchip"></i></div>
                                            <div>
                                                <div class="fw-bold text-dark">Troca de Processador</div>
                                                <div class="small text-muted">OS #0045</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Lucas Brina</td>
                                    <td>
                                        <span class="text-success fw-bold">20/11/2025</span><br>
                                        <small class="text-muted">3 dias restantes</small>
                                    </td>
                                    <td><span class="badge bg-danger bg-opacity-10 text-danger border border-danger">Alta</span></td>
                                    <td class="text-center"><span class="badge bg-info text-dark rounded-pill">Na Bancada</span></td>
                                    <td class="text-end pe-4"><?php echo $botao_tabela_servico; ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <nav>
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovaOS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold"><i class="fas fa-file-medical me-2"></i>Nova Ordem de Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Cliente</label>
                                <div class="input-group">
                                    <select class="form-select">
                                        <option selected>Selecione o cliente...</option>
                                        <option>Lucas Brina</option>
                                        <option>Rafael Cerqueira</option>
                                    </select>
                                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i> Novo</button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Equipamento</label>
                                <input type="text" class="form-control" placeholder="Ex: Notebook Dell G15">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número de Série</label>
                                <input type="text" class="form-control" placeholder="Opcional">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Problema Relatado</label>
                                <textarea class="form-control" rows="2" placeholder="O que o cliente disse?"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tipo de Serviço</label>
                                <select class="form-select">
                                    <option>Manutenção Preventiva</option>
                                    <option>Troca de Peça</option>
                                    <option>Formatação</option>
                                    <option>Diagnóstico</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Prioridade</label>
                                <select class="form-select">
                                    <option class="text-success">Baixa</option>
                                    <option class="text-warning" selected>Média</option>
                                    <option class="text-danger">Alta</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Prazo</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer bg-light mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Abrir OS</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo $footer_adm; ?>

</body>
</html>