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
        .badge-categoria { font-size: 0.8rem; padding: 5px 10px; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
        
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
            <div class="card-body d-flex gap-3 flex-wrap align-items-center">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Buscar produto...">
                </div>
                
                <select class="form-select" style="max-width: 200px;">
                    <option selected>Todas Categorias</option>
                    <option>Hardware</option>
                    <option>Periféricos</option>
                    <option>Computadores</option>
                </select>

                <select class="form-select" style="max-width: 180px;">
                    <option selected>Status: Todos</option>
                    <option class="text-success">Em Estoque</option>
                    <option class="text-warning">Baixo Estoque</option>
                    <option class="text-danger">Esgotado</option>
                </select>
            </div>
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
                                <th class="text-center">Estoque</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $pdo = conecta_bd::getInstance()->getConnection();
                                $stmt = $pdo->query("SELECT * FROM estoque ORDER BY id_produto DESC");
                                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (Exception $e) {
                                $produtos = [];
                            }

                            foreach ($produtos as $prod): 
                                $badgeClass = 'bg-success';
                                if($prod['quantidade'] <= 5) $badgeClass = 'bg-warning text-dark';
                                if($prod['quantidade'] == 0) $badgeClass = 'bg-danger';
                                
                                $img = "img/produtos/" . ($prod['foto'] ?? 'padrao.png');
                                if(!file_exists($img)) $img = "../Cliente/img/imagem_azul.png"; 
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $img ?>" class="img-produto-mini me-3" alt="Foto">
                                        <div>
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($prod['nome_produto']) ?></div>
                                            <div class="small text-muted">Cód: #<?= $prod['id_produto'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border border-secondary badge-categoria"><?= htmlspecialchars(ucfirst($prod['categoria'])) ?></span></td>
                                <td class="fw-bold text-success">R$ <?= number_format($prod['preco_venda'], 2, ',', '.') ?></td>
                                <td class="text-center"><span class="badge <?= $badgeClass ?> rounded-pill"><?= $prod['quantidade'] ?> un</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-primary" title="Editar"><i class="fas fa-edit"></i></button>
                                    <form method="POST" action="PHP/excluir_produto.php" style="display:inline;" onsubmit="return confirm('Excluir produto?');">
                                        <input type="hidden" name="id" value="<?= $prod['id_produto'] ?>">
                                        <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(count($produtos) == 0): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td></tr>
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
                    <form action="PHP/salvar_categoria.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome da Categoria</label>
                            <input type="text" class="form-control" name="nome_categoria" required placeholder="Ex: Monitores, Placas de Vídeo...">
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
                    <form action="PHP/salvar_produto.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Imagem do Produto</label>
                                <div class="upload-area" id="previewArea" onclick="document.getElementById('fileInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Clique para enviar ou arraste</p>
                                </div>
                                <input type="file" id="fileInput" name="foto_produto" accept="image/*" style="display: none;">
                                <small class="text-muted d-block mt-2 text-center">JPG, PNG ou WebP (Max 2MB)</small>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label">Nome do Produto</label>
                                        <input type="text" class="form-control" name="nome" placeholder="Ex: Memória RAM 8GB HyperX" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Categoria</label>
                                        <select class="form-select" name="categoria">
                                            <option value="hardware">Hardware</option>
                                            <option value="perifericos">Periféricos</option>
                                            <option value="computadores">Computadores</option>
                                            <option value="monitores">Monitores</option>
                                            <option value="acessorios">Acessórios</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Quantidade</label>
                                        <input type="number" class="form-control" name="quantidade" value="0" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Preço de Custo (R$)</label>
                                        <input type="text" class="form-control" name="preco_custo" placeholder="0,00">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-success">Preço de Venda (R$)</label>
                                        <input type="text" class="form-control border-success" name="preco_venda" placeholder="0,00" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descrição Detalhada</label>
                                <textarea class="form-control" name="descricao" rows="3" placeholder="Especificações técnicas..."></textarea>
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

      <script src="js/script.js"></script>

</body>
</html>