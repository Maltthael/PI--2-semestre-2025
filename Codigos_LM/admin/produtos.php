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
        .img-produto-mini {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 2px;
        }

        .badge-categoria {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .upload-area {
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: 0.3s;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: #a200b7;
            background-color: #f1e6f5;
        }

        .upload-area img {
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <?php echo $navbar_adm; ?>

    <div class="container-fluid p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold text-dark">Estoque de Produtos</h2>
                <p class="text-muted">Gerencie hardware, periféricos e computadores.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalCategoria">
                    <i class="fas fa-tags"></i> Nova Categoria
                </button>
                <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalProduto">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <form method="GET" action="" class="card-body d-flex gap-3 flex-wrap align-items-center">

                <div class="input-group" style="max-width: 300px;">
                    <button class="input-group-text bg-white border-end-0" type="submit"><i class="fas fa-search text-muted"></i></button>
                    <input type="text" name="busca" class="form-control border-start-0" placeholder="Buscar produto..." value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
                </div>

                <select class="form-select" name="filtro_categoria" style="max-width: 200px;" onchange="this.form.submit()">
                    <option value="">Todas Categorias</option>
                    <?php
                    try {
                        $pdo = conecta_bd::getInstance()->getConnection();
                        $cats = $pdo->query("SELECT * FROM categorias ORDER BY nome_categoria ASC")->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($cats as $c) {
                            $selected = (isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] == $c['id_categoria']) ? 'selected' : '';
                            echo "<option value='{$c['id_categoria']}' $selected>{$c['nome_categoria']}</option>";
                        }
                    } catch (Exception $e) {
                    }
                    ?>
                </select>

                <select class="form-select" name="filtro_status" style="max-width: 180px;" onchange="this.form.submit()">
                    <option value="">Status: Todos</option>
                    <option value="disponivel" <?= (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'disponivel') ? 'selected' : '' ?>>Disponível</option>
                    <option value="esgotado" <?= (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'esgotado') ? 'selected' : '' ?>>Esgotado</option>
                    <option value="descontinuado" <?= (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'descontinuado') ? 'selected' : '' ?>>Descontinuado</option>
                </select>

                <?php if (!empty($_GET['busca']) || !empty($_GET['filtro_categoria']) || !empty($_GET['filtro_status'])): ?>
                    <a href="produtos.php" class="btn btn-light text-muted" title="Limpar Filtros"><i class="fas fa-times"></i></a>
                <?php endif; ?>

            </form>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produto</th>
                                <th>Categoria</th>
                                <th>Preço Venda</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Estoque</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $sql = "SELECT e.*, c.nome_categoria 
                                        FROM estoque e 
                                        INNER JOIN categorias c ON e.fk_id_categoria = c.id_categoria";

                                $where = [];
                                $params = [];
                                if (!empty($_GET['busca'])) {
                                    $where[] = "e.nome_produto LIKE ?";
                                    $params[] = "%" . $_GET['busca'] . "%";
                                }
                                if (!empty($_GET['filtro_categoria'])) {
                                    $where[] = "e.fk_id_categoria = ?";
                                    $params[] = $_GET['filtro_categoria'];
                                }
                                if (!empty($_GET['filtro_status'])) {
                                    $where[] = "e.status = ?";
                                    $params[] = $_GET['filtro_status'];
                                }
                                if (count($where) > 0) {
                                    $sql .= " WHERE " . implode(" AND ", $where);
                                }
                                $sql .= " ORDER BY e.id_produto DESC";

                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($params);
                                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (Exception $e) {
                                $produtos = [];
                                echo "<tr><td colspan='6'>Erro: " . $e->getMessage() . "</td></tr>";
                            }

                            foreach ($produtos as $prod):
                                $corEstoque = 'bg-success';
                                if ($prod['quantidade'] <= 5) $corEstoque = 'bg-warning text-dark';
                                if ($prod['quantidade'] == 0) $corEstoque = 'bg-danger';

                                $corStatus = ($prod['status'] == 'disponivel') ? 'bg-success' : (($prod['status'] == 'esgotado') ? 'bg-danger' : 'bg-dark');

                                $filename = $prod['foto'] ?? 'padrao.png';

                                $caminho_visualizacao = "img/produtos/" . $filename;

                                $caminho_absoluto = __DIR__ . '/img/produtos/' . $filename;

                                if (file_exists($caminho_absoluto) && !is_dir($caminho_absoluto)) {
                                    $full_img_url = $caminho_visualizacao;
                                } else {
                                    $full_img_url = "../Cliente/img/imagem_azul.png";
                                }
                            ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $full_img_url ?>" class="img-produto-mini me-3" alt="Foto">
                                            <div>
                                                <div class="fw-bold text-dark"><?= htmlspecialchars($prod['nome_produto']) ?></div>
                                                <div class="small text-muted">Cód: #<?= $prod['id_produto'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border border-secondary badge-categoria">
                                            <?= htmlspecialchars(ucfirst($prod['nome_categoria'])) ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">R$ <?= number_format($prod['preco_venda'], 2, ',', '.') ?></td>

                                    <td class="text-center">
                                        <span class="badge <?= $corStatus ?> bg-opacity-75 rounded-1">
                                            <?= ucfirst($prod['status']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge <?= $corEstoque ?> rounded-pill">
                                            <?= $prod['quantidade'] ?> un
                                        </span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-light text-primary"
                                            title="Editar"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdicao"
                                            data-id="<?= $prod['id_produto'] ?>"
                                            data-nome="<?= htmlspecialchars($prod['nome_produto']) ?>"
                                            data-categoria-id="<?= $prod['fk_id_categoria'] ?>"
                                            data-custo="<?= number_format($prod['preco_custo'], 2, ',', '.') ?>"
                                            data-venda="<?= number_format($prod['preco_venda'], 2, ',', '.') ?>"
                                            data-quantidade="<?= $prod['quantidade'] ?>"
                                            data-status="<?= $prod['status'] ?>"
                                            data-descricao="<?= htmlspecialchars($prod['descricao']) ?>"
                                            data-foto="<?= htmlspecialchars($filename) ?>"
                                            data-full-url="<?= $full_img_url ?>"> <i class="fas fa-edit"></i>
                                        </button>

                                        <form method="POST" action="../Classes/admin.php" style="display:inline;"
                                            onsubmit="confirmarExclusao(event, '<?= addslashes($prod['nome_produto']) ?>')">
                                            <input type="hidden" name="action" value="excluir_produto">
                                            <input type="hidden" name="id" value="<?= $prod['id_produto'] ?>">
                                            <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (count($produtos) == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
                                        <p>Nenhum produto encontrado com esses filtros.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCategoria" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold"><i class="fas fa-tags me-2"></i>Nova Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form action="../Classes/admin.php" method="POST">
                        <input type="hidden" name="action" value="salvar_categoria">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome da Categoria</label>
                            <input type="text" class="form-control" name="nome_categoria" required placeholder="Ex: Monitores...">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProduto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold"><i class="fas fa-box me-2"></i>Cadastrar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form action="../Classes/admin.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="salvar_produto">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Imagem do Produto</label>
                                <div class="upload-area" id="previewArea" onclick="document.getElementById('fileInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Clique para enviar</p>
                                </div>
                                <input type="file" id="fileInput" name="foto_produto" accept="image/*" style="display: none;">
                            </div>

                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label">Nome do Produto</label>
                                        <input type="text" class="form-control" name="nome" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Categoria</label>
                                        <select class="form-select" name="categoria_id" required>
                                            <option value="" selected disabled>Selecione...</option>
                                            <?php
                                            if (!isset($cats)) {
                                                try {
                                                    $cats = $pdo->query("SELECT * FROM categorias ORDER BY nome_categoria ASC")->fetchAll(PDO::FETCH_ASSOC);
                                                } catch (Exception $e) {
                                                }
                                            }
                                            foreach ($cats as $c) {
                                                echo "<option value='{$c['id_categoria']}'>{$c['nome_categoria']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Quantidade</label>
                                        <input type="number" class="form-control" name="quantidade" value="0" min="0">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Preço de Custo (R$)</label>
                                        <input type="text" class="form-control" name="preco_custo">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-success">Preço de Venda (R$)</label>
                                        <input type="text" class="form-control border-success" name="preco_venda" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descrição Detalhada</label>
                                <textarea class="form-control" name="descricao" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light mt-3 px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success px-4">Salvar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdicao" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-pen-to-square me-2"></i>Editar Produto: <span id="edicao-nome-produto-title"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEdicaoProduto" action="../Classes/admin.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="editar_produto">
                        <input type="hidden" name="id_produto" id="edicao-id-produto">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Imagem do Produto</label>
                                <div class="upload-area" id="previewAreaEdicao" onclick="document.getElementById('fileInputEdicao').click()">
                                    <img id="edicao-foto-atual" src="" alt="Foto Atual" class="img-fluid rounded shadow-sm">
                                </div>
                                <input type="file" id="fileInputEdicao" name="nova_foto_produto" accept="image/*" style="display: none;">
                                <small class="text-muted d-block mt-2 text-center">Deixe vazio para manter a foto atual.</small>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label">Nome do Produto</label>
                                        <input type="text" class="form-control" name="nome" id="edicao-nome" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Categoria</label>
                                        <select class="form-select" name="categoria_id" id="edicao-categoria" required>
                                            <option value="" disabled>Selecione...</option>
                                            <?php
                                            if (!isset($cats)) {
                                                try {
                                                    $cats = $pdo->query("SELECT * FROM categorias ORDER BY nome_categoria ASC")->fetchAll(PDO::FETCH_ASSOC);
                                                } catch (Exception $e) {
                                                }
                                            }
                                            foreach ($cats as $c) {
                                                echo "<option value='{$c['id_categoria']}'>{$c['nome_categoria']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Quantidade</label>
                                        <input type="number" class="form-control" name="quantidade" id="edicao-quantidade" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Preço de Custo (R$)</label>
                                        <input type="text" class="form-control" name="preco_custo" id="edicao-custo">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-success">Preço de Venda (R$)</label>
                                        <input type="text" class="form-control border-success" name="preco_venda" id="edicao-venda" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Status do Produto</label>
                                        <select class="form-select" name="status" id="edicao-status" required>
                                            <option value="disponivel">Disponível</option>
                                            <option value="esgotado">Esgotado</option>
                                            <option value="descontinuado">Descontinuado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descrição Detalhada</label>
                                <textarea class="form-control" name="descricao" id="edicao-descricao" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light mt-3 px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning text-dark px-4">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_SESSION['alert'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['alert']['icon'] ?>',
                title: '<?= $_SESSION['alert']['title'] ?>',
                text: '<?= $_SESSION['alert']['message'] ?>',
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Ok, Entendido!'
            });
        </script>
    <?php unset($_SESSION['alert']);
    endif; ?>

    <script src="js/script.js"></script>

    <script>
        function confirmarExclusao(event, nomeItem) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Tem certeza?',
                text: `Você está prestes a excluir: "${nomeItem}". Essa ação não pode ser desfeita!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>