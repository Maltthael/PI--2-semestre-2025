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

   try{

    $pdo = conecta_bd::getInstance()->getConnection();

    $sql = "SELECT id_cliente, nome, email, senha, endereco, numero, bairro, cep, cidade, estado, cpf 
            FROM cliente
            ORDER BY nome";

    $stmt = $pdo->query($sql);
    $lista_clientes = $stmt->fetchAll();
    
  } catch (Exception $e) {
      echo "Erro ao buscar clientes: " . $e->getMessage();
      $lista_clientes = [];
    }

    
  ?>


<div style="margin-top: 15px; overflow-y: auto;">
<table class="table table-striped table-hover text-center">
  <thead>
    <tr>  
      <th>ID</th>
      <th>Nome</th>
      <th>email</th>
      <th>senha</th>
      <th>endereco</th>
      <th>numero</th>
      <th>bairro</th>
      <th>cep</th>
      <th>cidade<th>
      <th>estado</th>
      <th>cpf</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($lista_clientes as $cliente):
    ?>
        <tr>
          <td><?php echo htmlspecialchars($cliente['id_cliente']); ?></td>
          <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
          <td><?php echo htmlspecialchars($cliente['email']); ?></td>
          <td><?php echo htmlspecialchars($cliente['senha']); ?></td>
          <td><?php echo htmlspecialchars($cliente['endereco']); ?></td>
          <td><?php echo htmlspecialchars($cliente['numero']); ?></td>
          <td><?php echo htmlspecialchars($cliente['bairro']); ?></td>
          <td><?php echo htmlspecialchars($cliente['cep']); ?></td>
          <td><?php echo htmlspecialchars($cliente['cidade']); ?></td>
          <td></td>
          <td><?php echo htmlspecialchars($cliente['estado']); ?></td>
          <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
          <td class="text-center align-middle">
                <?php
                echo $botao_tabela_clientes;
                ?>
          </td>
        </tr>

    <?php
    endforeach;

    if (count($lista_clientes) == 0):
    ?>
        <tr>
            <td colspan="8">Nenhum cliente cadastrado.</td>
        </tr>
    <?php
    endif;
    ?>

  

  <?php
    
  ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>

</html>

