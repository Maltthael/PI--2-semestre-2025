<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/vendas.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
</head>

<body>
    <?php
        include 'bt5/classes.php';
        echo $navbar;
    ?>
   
   <div class="container my-4">
  <div class="p-4 border rounded shadow-sm bg-white mt-4" style="margin-top: 80px;">
    <h2 class="mb-4 text-center">Seu Carrinho</h2>

    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table">
          <tr>
            <th>Produto</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Subtotal</th>
            <th>Remover</th>
          </tr>
        </thead>
        <tbody id="carrinho-items">
          <tr>
            <td><img src="img/imagem_azul.png" width="60" alt="Produto" /></td>
            <td>Mouse Gamer RGB</td>
            <td>R$ 150,00</td>
            <td>
              <input type="number" value="1" min="1" class="form-control" style="width: 80px;" />
            </td>
            <td class="subtotal">R$ 150,00</td>
            <td><button class="btn btn-danger btn-sm remover-item">Remover</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end">
      <h4>Total: <span id="total">R$ 150,00</span></h4>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <a href="#" class="btn btn-success">Finalizar Compra</a>
    </div>
  </div>
</div>


    <div class="d-flex justify-content-end mt-3">
      <a href="#" class="btn btn-success">Finalizar Compra</a>
    </div>
  </div>
</div>

<?php
    echo $footer;
?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>