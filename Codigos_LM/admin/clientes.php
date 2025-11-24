<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
    session_start();
    include '../Classes/layout.php';
    echo $head;
    ?>
    <style>
        .avatar-initial {
            width: 40px; height: 40px; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: bold; 
            font-size: 1.1rem; 
            margin-right: 15px;
        }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
    </style>
</head>

<body>

    <?php echo $navbar_adm; ?>

    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold text-dark">Gerenciar Clientes</h2>
                <p class="text-muted">Visualize, edite ou remova clientes cadastrados.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="inputBusca" class="form-control border-start-0" placeholder="Buscar por nome, email ou CPF...">
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Cliente</th>
                                <th>Contato</th>
                                <th>Localização</th>
                                <th>CPF</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-spinner fa-spin me-2"></i> Carregando clientes...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalVisualizar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user me-2"></i>Detalhes do Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-initial bg-primary text-white mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 id="viewNome" class="fw-bold mb-0"></h4>
                        <p id="viewEmail" class="text-muted"></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>CPF:</strong> <span id="viewCpf"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Endereço:</strong> <span id="viewEndereco" class="text-end"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Bairro/Cidade:</strong> <span id="viewBairroCidade" class="text-end"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>CEP:</strong> <span id="viewCep"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i>Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../Classes/admin.php" method="POST">
                        <input type="hidden" name="action" value="editar_cliente">
                        <input type="hidden" name="id_cliente" id="editId">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" name="nome" id="editNome" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CPF</label>
                                <input type="text" class="form-control" name="cpf" id="editCpf" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" name="telefone" id="editTelefone">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CEP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cep" id="editCep">
                                    <button class="btn btn-outline-secondary" type="button" id="btnBuscarCep"><i class="fas fa-search"></i></button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="endereco" id="editEndereco">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="numero" id="editNumero">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control" name="bairro" id="editBairro">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" name="cidade" id="editCidade">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Estado</label>
                                <input type="text" class="form-control" name="estado" id="editEstado">
                            </div>
                        </div>
                        
                        <div class="modal-footer bg-light mt-4 px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
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
            confirmButtonText: 'Ok'
        });
    </script>
    <?php unset($_SESSION['alert']); endif; ?>
    
    <script src="js/script.js"></script>
</body>
</html>