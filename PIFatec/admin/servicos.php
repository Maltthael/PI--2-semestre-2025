<!DOCTYPE html>
<html lang="pt">
<head>
    <?php
        include '../Classes/layout.php';
        require_once '../Classes/conecta.php';
        echo $head;
    ?>
    
</head>

<body>
    
  <?php
   echo $navbar_adm_clientes;

  try{

    $pdo = conecta_bd::getInstance()->getConnection();

    $sql = "SELECT id_ordem, titulo, acao, prazo, fk_cliente_id_cliente 
            FROM ordem_servico
            ORDER BY titulo";

    $stmt = $pdo->query($sql);
    $lista_ordem = $stmt->fetchAll();
    
  } catch (Exception $e) {
      echo "Erro ao buscar ordens de serviço: " . $e->getMessage();
      $lista_ordem = [];
    }


  ?>
<div style="margin-top: 15px; overflow-y: auto;">
<table class="table table-striped table-hover text-center">
  <thead>
    <tr>  
      <th>ID</th>
      <th>Titulo</th>
      <th>Ação</th>
      <th>Prazo</th>
      <th>Proprietario</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($lista_ordem as $ordem):
    ?>
        <tr>
          <td><?php echo htmlspecialchars($ordem['id_ordem']); ?></td>
          <td><?php echo htmlspecialchars($ordem['titulo']); ?></td>
          <td><?php echo htmlspecialchars($ordem['acao']); ?></td>
          <td><?php echo htmlspecialchars($ordem['prazo']); ?></td>
          <td><?php echo htmlspecialchars($ordem['fk_cliente_id_cliente']); ?></td>
          <td class="text-center align-middle">
                <?php
                echo $botao_tabela_clientes;
                ?>
          </td>
        </tr>
    <?php
    endforeach;

    if (count($lista_ordem) == 0):
    ?>
        <tr>
            <td colspan="8">Nenhuma ordem de serviço cadastrada.</td>
        </tr>
    <?php
    endif;
    ?>
</tbody>
  </table>
</div>
</div>
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>

</html>

