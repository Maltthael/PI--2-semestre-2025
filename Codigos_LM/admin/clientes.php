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
session_start();
echo $navbar_adm_clientes;

// Exibe mensagens de sessão (sucesso, erro etc.)
if (isset($_SESSION['mensagem'])) {
    $tipo = $_SESSION['tipoMensagem'] ?? 'info';
    echo "<div class='alert alert-$tipo text-center'>{$_SESSION['mensagem']}</div>";
    unset($_SESSION['mensagem'], $_SESSION['tipoMensagem']);
}

try {
    $pdo = conecta_bd::getInstance()->getConnection();

    $sql = "SELECT id_cliente, nome, email, senha, endereco, numero, bairro, cep, cidade, estado, cpf 
            FROM cliente
            ORDER BY nome";
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
          <!-- Botão Editar -->
          <button 
            type="button" 
            class="btn btn-warning btn-sm btn-editar"
            data-id="<?= $cliente['id_cliente'] ?>"
            data-nome="<?= htmlspecialchars($cliente['nome']) ?>"
            data-email="<?= htmlspecialchars($cliente['email']) ?>"
            data-senha="<?= htmlspecialchars($cliente['senha']) ?>"
            data-endereco="<?= htmlspecialchars($cliente['endereco']) ?>"
            data-numero="<?= htmlspecialchars($cliente['numero']) ?>"
            data-bairro="<?= htmlspecialchars($cliente['bairro']) ?>"
            data-cep="<?= htmlspecialchars($cliente['cep']) ?>"
            data-cidade="<?= htmlspecialchars($cliente['cidade']) ?>"
            data-estado="<?= htmlspecialchars($cliente['estado']) ?>"
            data-cpf="<?= htmlspecialchars($cliente['cpf']) ?>"
            data-bs-toggle="modal" 
            data-bs-target="#modalEditar"
          >
            <i class="fas fa-edit"></i> Editar
          </button>

          <!-- Botão Excluir -->
          <form action="PHP/excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');" style="display:inline;">
            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
            <button type="submit" class="btn btn-danger btn-sm">
              <i class="fas fa-trash-alt"></i> Excluir
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

<!-- Modal de Edição -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formEditarCliente" method="POST" action="PHP/editar.php">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLabel">Editar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_cliente" id="edit_id_cliente">

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Nome</label>
              <input type="text" name="nome" id="edit_nome" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Senha</label>
              <input type="text" name="senha" id="edit_senha" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>CPF</label>
              <input type="text" name="cpf" id="edit_cpf" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Endereço</label>
              <input type="text" name="endereco" id="edit_endereco" class="form-control">
            </div>
            <div class="col-md-3">
              <label>Número</label>
              <input type="text" name="numero" id="edit_numero" class="form-control">
            </div>
            <div class="col-md-3">
              <label>Bairro</label>
              <input type="text" name="bairro" id="edit_bairro" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-3">
              <label>CEP</label>
              <input type="text" name="cep" id="edit_cep" class="form-control">
            </div>
            <div class="col-md-5">
              <label>Cidade</label>
              <input type="text" name="cidade" id="edit_cidade" class="form-control">
            </div>
            <div class="col-md-4">
              <label>Estado</label>
              <input type="text" name="estado" id="edit_estado" class="form-control">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php echo $footer_adm; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Preenche o modal com os dados do cliente
document.querySelectorAll('.btn-editar').forEach(btn => {
  btn.addEventListener('click', () => {
    document.getElementById('edit_id_cliente').value = btn.dataset.id;
    document.getElementById('edit_nome').value = btn.dataset.nome;
    document.getElementById('edit_email').value = btn.dataset.email;
    document.getElementById('edit_senha').value = btn.dataset.senha;
    document.getElementById('edit_endereco').value = btn.dataset.endereco;
    document.getElementById('edit_numero').value = btn.dataset.numero;
    document.getElementById('edit_bairro').value = btn.dataset.bairro;
    document.getElementById('edit_cep').value = btn.dataset.cep;
    document.getElementById('edit_cidade').value = btn.dataset.cidade;
    document.getElementById('edit_estado').value = btn.dataset.estado;
    document.getElementById('edit_cpf').value = btn.dataset.cpf;
  });
});

// Envia o formulário de edição via AJAX
document.getElementById('formEditarCliente').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  const response = await fetch(e.target.action, {
    method: 'POST',
    body: formData
  });

  const result = await response.json();

  if (result.status === 'success') {
    alert(result.mensagem);
    location.reload(); // Atualiza a tabela
  } else {
    alert(result.mensagem);
  }
});
</script>

</body>
</html>
