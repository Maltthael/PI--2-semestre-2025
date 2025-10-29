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

    $sql = "SELECT id, nome, email, senha, endereco, numero, bairro, cep, cidade, estado, cpf 
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
        <td><?= htmlspecialchars($cliente['id']) ?></td>
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
          <form action="PHP/excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
            <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
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

 <?php
    echo $footer_adm;
  ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>
</html>
