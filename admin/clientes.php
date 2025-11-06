<!DOCTYPE html>
<html lang="pt">

<head>
  <?php
  include '../Classes/layout.php';
  include '../Classes/admin.php';
  require_once '../Classes/conecta.php';
  echo $head;
  ?>
</head>

<body>
  <?php
  echo $navbar_adm_clientes;

  try {
    $pdo = conecta_bd::getInstance()->getConnection();

    $sql = "SELECT id_cliente, nome, email, senha, endereco, numero, bairro, cep, cidade, estado, cpf 
            FROM cliente
            GROUP BY id_cliente";
    $stmt = $pdo->query($sql);
    $lista_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo "<div class='alert alert-danger'>Erro ao buscar clientes: " . $e->getMessage() . "</div>";
    $lista_clientes = [];
  }
  ?>

  <div style="margin-top: 15px; overflow-y: auto;">
    <table class="table table-striped table-hover text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Senha</th>
          <th>Endereço</th>
          <th>Número</th>
          <th>Bairro</th>
          <th>CEP</th>
          <th>Cidade</th>
          <th>Estado</th>
          <th>CPF</th>
          <th></th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lista_clientes as $cliente): ?>
          <tr>
            <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
            <td><?= htmlspecialchars($cliente['nome']) ?></td>
            <td><?= htmlspecialchars($cliente['email']) ?></td>
            <td><?= htmlspecialchars($cliente['senha']) ?></td>
            <td><?= htmlspecialchars($cliente['endereco']) ?></td>
            <td><?= htmlspecialchars($cliente['numero']) ?></td>
            <td><?= htmlspecialchars($cliente['bairro']) ?></td>
            <td><?= htmlspecialchars($cliente['cep']) ?></td>
            <td><?= htmlspecialchars($cliente['cidade']) ?></td>
            <td><?= htmlspecialchars($cliente['estado']) ?></td>
            <td><?= htmlspecialchars($cliente['cpf']) ?></td>
            <td>
              <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                <div class="container modal-dialog">
                  <div class="modal-content">
                    <div id="ativo" class="modal-header text-black">
                      <h5 class="ativo" id="modalEditarLabel">Editar Cliente</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                      <form class="row g-3" method="POST">
                        <div class="col-md-12">
                          <label for="nomeCliente" class="form-label">Nome</label>
                          <input type="text" class="form-control" id="nome" placeholder="Digite seu novo Nome">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Email</label>
                          <input type="text" class="form-control" id="email" placeholder="Digite seu novo Email">
                        </div>
                        <div class="col-md-12">
                          <label for="nomeCliente" class="form-label">Senha</label>
                          <input type="text" class="form-control" id="senha" placeholder="Digite sua nova Senha">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Endereço</label>
                          <input type="text" class="form-control" id="endereco" placeholder="Digite seu novo Endereço">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Numero da Casa</label>
                          <input type="text" class="form-control" id="numero" placeholder="Digite seu novo Numero">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Bairro</label>
                          <input type="text" class="form-control" id="bairro" placeholder="Digite seu Bairro atual">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Cidade</label>
                          <input type="text" class="form-control" id="cidade" placeholder="Digite a nova Cidade">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">Estado</label>
                          <input type="text" class="form-control" id="estado" placeholder="Digite o Estado atual">
                        </div>
                        <div class="col-md-12">
                          <label for="telefoneCliente" class="form-label">CPF</label>
                          <input type="text" class="form-control" id="cpf" placeholder="Digite seu novo CPF">
                        </div>
                        <button type="submit" style="margin-top: 30px;" class="btn btn-success w-100">Salvar alterações</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            <td style="display: flex; gap: 8px; align-items: center;">
              <button class="btn btn-button" data-bs-toggle="modal" data-bs-target="#modalEditar" style="display: flex; align-items: center; border: none; background: none;">
                <i class="bi bi-pencil"></i>
              </button>

              <form action="PHP/excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');" style="margin: 0;">
                <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                <button type="submit" style="border: none; background: none; display: flex; align-items: center;">
                  <i class="bi bi-x"></i>
                </button>
              </form>
            </td>
          </tr> 
        <?php endforeach; ?>

        <?php if (count($lista_clientes) == 0): ?>
          <tr>
            <td colspan="12">Nenhum cliente cadastrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php
  echo $footer_adm;
  ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>

</html>