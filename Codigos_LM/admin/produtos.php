<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
    session_start();
    include '../Classes/layout.php';
    // require_once '../Classes/conecta.php'; // Conexão com banco
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
        /* Área de Upload Customizada */
        .upload-area {
            border: 2px dashed #ced4da;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: 0.3s;
        }
        .upload-area:hover {
            border-color: #a200b7;
            background-color: #f1e6f5;
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
            <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalProduto">
                <i class="fas fa-plus"></i> Adicionar Produto
            </button>
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
                    <option>Monitores</option>
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
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="../Cliente/img/imagem_azul.png" class="img-produto-mini me-3" alt="Produto">
                                        <div>
                                            <div class="fw-bold text-dark">Placa de Vídeo RTX 4060</div>
                                            <div class="small text-muted">Cód: #GPU-4060</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary badge-categoria">Hardware</span></td>
                                <td class="fw-bold text-success">R$ 2.199,00</td>
                                <td class="text-center"><span class="badge bg-success rounded-pill">15 un</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="../Cliente/img/imagem_azul.png" class="img-produto-mini me-3" alt="Produto">
                                        <div>
                                            <div class="fw-bold text-dark">Processador Intel Core i5 12400F</div>
                                            <div class="small text-muted">Cód: #CPU-I512</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary badge-categoria">Hardware</span></td>
                                <td class="fw-bold text-success">R$ 899,00</td>
                                <td class="text-center"><span class="badge bg-warning text-dark rounded-pill">3 un</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="../Cliente/img/imagem_azul.png" class="img-produto-mini me-3" alt="Produto">
                                        <div>
                                            <div class="fw-bold text-dark">Mouse Gamer Redragon Cobra</div>
                                            <div class="small text-muted">Cód: #PER-RED01</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-purple bg-opacity-10 text-dark border badge-categoria" style="background-color:#e6e6fa;">Periféricos</span></td>
                                <td class="fw-bold text-success">R$ 129,90</td>
                                <td class="text-center"><span class="badge bg-danger rounded-pill">0 un</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-primary"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                                <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Clique para enviar ou arraste</p>
                                    <input type="file" id="fileInput" name="foto_produto" accept="image/*" style="display: none;">
                                </div>
                                <small class="text-muted d-block mt-2 text-center">JPG, PNG ou WebP (Max 2MB)</small>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-12">