<!DOCTYPE html>
<html lang="pt">
<head>
    <?php
        include '../bt5/classes.php';
        echo $head_adm;
    ?>
    
</head>

<body>
    
  <?php
   echo $navbar_adm_clientes;
  ?>
<div style="margin-top: 15px; overflow-y: auto;">
<table class="table table-striped table-hover text-center">
  <thead>
    <tr>  
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>CEP</th>
      <th>Logradouro</th>
      <th>Número</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>0</td>
      <td>Lucas</td>
      <td>Brina</td>
      <td>19 997060181</td>
      <td>13606690</td>
      <td>Rua Forindo Pericles Romanzini</td>
      <td>295</td>
      <td class="text-center align-middle">
          <?php
            echo $botao_tabela_clientes;
          ?>
      </td>
    </tr>

    <?php





    ?>
</tbody>
  </table>
</div>
</div>
  

  <?php
    echo $footer_adm;
  ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>

</html>

