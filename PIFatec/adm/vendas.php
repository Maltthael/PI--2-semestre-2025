<!DOCTYPE html>
<html lang="pt-br">
  <?php
    include '../bt5/classes.php';
  ?>

<?php
echo $head_adm;
?>

<body>
  <?php
  echo $navbar_adm_vendas;
?>

<div class="mt-3 mb-2 d-flex justify-content-end">
  <button type="button" class="btn btn-button d-flex align-items-center gap-2"
          data-bs-toggle="modal" data-bs-target="#AddModal">
    <i class="bi bi-plus-lg"></i> Novo
  </button>
</div>

<div style="overflow-y: auto;">
  <table class="table table-striped table-hover text-center">
    <thead>
      <tr>  
        <th>ID</th>
        <th>Nome</th>
        <th>Quantidade</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>0</td>
        <td>Headset</td>
        <td>8</td>
        <td>R$ 90,00</td>
      </tr>
    </tbody>
  </table>
</div>


<!-- MODAL -->
<div class="modal fade" id="AddModal" tabindex="-1" aria-labelledby="meuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formNovoProduto">
        <div class="modal-header" id="ativo">
          <h5 class="modal-title" id="meuModalLabel">Novo Produto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nomeProduto" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nomeProduto" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="quantidadeProduto" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidadeProduto" name="quantidade" required>
          </div>
          <div class="mb-3">
            <label for="valorProduto" class="form-label">Valor (R$)</label>
            <input type="text" class="form-control" id="valorProduto" name="valor" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>






<?php echo $footer_adm; ?>

<!-- Bootstrap CSS e Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</html>



