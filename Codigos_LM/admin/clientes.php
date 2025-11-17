<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php
  include '../Classes/layout.php';
  // include '../Classes/admin.php'; // Descomente se usar métodos dessa classe
  require_once '../Classes/conecta.php';
  echo $head;
  ?>
  <style>
    .avatar-initial {
      width: 40px;
      height: 40px;
      background-color: #e9ecef;
      color: #495057;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.1rem;
      margin-right: 15px;
    }

    .table-hover tbody tr:hover {
      background-color: #f8f9fa;
      transition: 0.2s;
    }

    .card-header {
      background-color: white;
      border-bottom: 1px solid #eee;
      padding: 1.5rem;
    }
  </style>
</head>

<body>
  <?php
  echo $navbar_adm_clientes;

  try {
    $pdo = conecta_bd::getInstance()->getConnection();
    $sql = "SELECT * FROM cliente GROUP BY id_cliente";
    $stmt = $pdo->query($sql);
    $lista_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo "<div class='alert alert-danger m-4'>Erro ao buscar clientes: " . $e->getMessage() . "</div>";
    $lista_clientes = [];
  }
  ?>

  <div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-0 fw-bold text-dark">Gerenciar Clientes</h2>
        <p class="text-muted">Visualize e gerencie a base de clientes da LM Informática.</p>
      </div>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Clientes</h5>

        <div class="input-group" style="width: 300px;">
          <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
          <input type="text" id="inputBusca" class="form-control bg-light border-start-0" placeholder="Buscar por nome ou email...">
        </div>
      </div>

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
              <?php foreach ($lista_clientes as $cliente):
                $inicial = strtoupper(substr($cliente['nome'], 0, 1));
              ?>
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar-initial shadow-sm bg-primary text-white">
                        <?= $inicial ?>
                      </div>
                      <div>
                        <div class="fw-bold text-dark"><?= htmlspecialchars($cliente['nome']) ?></div>
                        <div class="small text-muted">ID: #<?= $cliente['id_cliente'] ?></div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex flex-column">
                      <span class="text-dark"><i class="far fa-envelope me-1 text-muted"></i> <?= htmlspecialchars($cliente['email']) ?></span>
                      <span class="small text-muted mt-1"><i class="fas fa-phone-alt me-1"></i> <?= htmlspecialchars($cliente['telefone'] ?? '') ?></span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex flex-column">
                      <span class="fw-medium"><?= htmlspecialchars($cliente['cidade']) ?> - <?= htmlspecialchars($cliente['estado']) ?></span>
                      <span class="small text-muted"><?= htmlspecialchars($cliente['bairro']) ?></span>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($cliente['cpf']) ?></span>
                  </td>
                  <td class="text-center">
                    <span class="badge bg-success-subtle text-success rounded-pill">Ativo</span>
                  </td>
                  <td class="text-end pe-4">
                    <div class="btn-group">
                      <button class="btn btn-sm btn-outline-secondary btn-visualizar"
                        title="Ver Detalhes"
                        data-bs-toggle="modal"
                        data-bs-target="#modalVisualizar"
                        data-nome="<?= htmlspecialchars($cliente['nome']) ?>"
                        data-email="<?= htmlspecialchars($cliente['email']) ?>"
                        data-cpf="<?= htmlspecialchars($cliente['cpf']) ?>"
                        data-endereco="<?= htmlspecialchars($cliente['endereco']) ?>"
                        data-numero="<?= htmlspecialchars($cliente['numero']) ?>"
                        data-bairro="<?= htmlspecialchars($cliente['bairro']) ?>"
                        data-cep="<?= htmlspecialchars($cliente['cep']) ?>"
                        data-cidade="<?= htmlspecialchars($cliente['cidade']) ?>"
                        data-estado="<?= htmlspecialchars($cliente['estado']) ?>">
                        <i class="fas fa-eye"></i>
                      </button>

                      <button class="btn btn-sm btn-outline-primary"
                        title="Editar"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar"
                        data-id="<?= $cliente['id_cliente'] ?>"
                        data-nome="<?= htmlspecialchars($cliente['nome']) ?>"
                        data-email="<?= htmlspecialchars($cliente['email']) ?>"
                        data-telefone="<?= htmlspecialchars($cliente['telefone'] ?? '') ?>"
                        data-cpf="<?= htmlspecialchars($cliente['cpf']) ?>"
                        data-cep="<?= htmlspecialchars($cliente['cep']) ?>"
                        data-endereco="<?= htmlspecialchars($cliente['endereco']) ?>"
                        data-numero="<?= htmlspecialchars($cliente['numero']) ?>"
                        data-bairro="<?= htmlspecialchars($cliente['bairro']) ?>"
                        data-cidade="<?= htmlspecialchars($cliente['cidade']) ?>"
                        data-estado="<?= htmlspecialchars($cliente['estado']) ?>">
                        <i class="fas fa-pencil-alt"></i>
                      </button>

                      <form action="PHP/excluir.php" method="POST" onsubmit="return confirm('Tem certeza?');" style="display: inline;">
                        <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (count($lista_clientes) == 0): ?>
                <tr>
                  <td colspan="6" class="text-center py-5">
                    <img src="../Cliente/img/empty.svg" alt="" width="100" class="mb-3 opacity-50">
                    <p class="text-muted">Nenhum cliente encontrado.</p>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-white py-3">
        <nav aria-label="Navegação">
          <ul class="pagination justify-content-end mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalVisualizar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title fw-bold text-secondary"><i class="fas fa-id-card me-2"></i>Ficha do Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-4">
            <div class="avatar-initial mx-auto bg-secondary text-white shadow" style="width: 60px; height: 60px; font-size: 1.5rem;">
              <i class="fas fa-user"></i>
            </div>
            <h5 class="mt-2 mb-0 fw-bold" id="viewNome">Nome do Cliente</h5>
            <p class="text-muted small" id="viewEmail">email@exemplo.com</p>
          </div>

          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
              <span class="text-muted">CPF</span>
              <span class="fw-medium" id="viewCpf">000.000.000-00</span>
            </li>
            <li class="list-group-item px-0">
              <span class="text-muted d-block mb-1">Endereço Completo</span>
              <span class="fw-medium d-block" id="viewEndereco">Rua Exemplo, 123</span>
              <span class="small text-muted" id="viewBairroCidade">Bairro - Cidade/UF</span>
              <span class="small text-muted d-block" id="viewCep">CEP: 00000-000</span>
            </li>
          </ul>
        </div>
        <div class="modal-footer bg-light border-0 justify-content-center">
          <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i>Editar Cliente</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <form action="PHP/editar.php" method="POST">
          <div class="modal-body bg-light">
            <input type="hidden" name="id_cliente" id="editId">

            <h6 class="text-primary mb-3 border-bottom pb-2">Dados Pessoais</h6>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label class="form-label fw-bold">Nome Completo</label>
                <input type="text" class="form-control" name="nome" id="editNome" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" name="email" id="editEmail" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="editTelefone" placeholder="(XX) 99999-9999">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">CPF</label>
                <input type="text" class="form-control" name="cpf" id="editCpf" required>
              </div>
            </div>

            <h6 class="text-primary mb-3 border-bottom pb-2">Endereço</h6>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fw-bold">CEP</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="cep" id="editCep" maxlength="9">
                  <button class="btn btn-outline-secondary" type="button" id="btnBuscarCep">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
                <small class="text-muted" id="msgCep"></small>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Endereço (Rua)</label>
                <input type="text" class="form-control bg-white" name="endereco" id="editEndereco">
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold">Número</label>
                <input type="text" class="form-control" name="numero" id="editNumero">
              </div>
              <div class="col-md-5">
                <label class="form-label fw-bold">Bairro</label>
                <input type="text" class="form-control bg-white" name="bairro" id="editBairro">
              </div>
              <div class="col-md-5">
                <label class="form-label fw-bold">Cidade</label>
                <input type="text" class="form-control bg-white" name="cidade" id="editCidade">
              </div>
              <div class="col-md-2">
                <label class="form-label fw-bold">UF</label>
                <input type="text" class="form-control bg-white" name="estado" id="editEstado" maxlength="2">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/script.js"></script>

</body>
</html> 