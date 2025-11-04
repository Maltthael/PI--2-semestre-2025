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
   echo $navbar_adm_servicos;
  ?>
<div style="margin-top: 15px; overflow-y: auto;">
<table class="table table-striped table-hover text-center">
  <thead>
    <tr>  
      <th>ID</th>
      <th>Titulo</th>
      <th>Proprietario</th>
      <th>Prazo</th>
      <th>Status</th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>0</td>
      <td>Troca Placa Mae</td>
      <td>Lucas Brina</td>
       <td>18/09/2025</td>
       <td>Em andamento</td>
      <td class="text-center align-middle">
          <?php
            echo $botao_tabela_servico;
          ?>
      </td>
    </tr>
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

