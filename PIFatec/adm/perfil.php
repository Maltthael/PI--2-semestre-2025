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
   echo $navbar_adm_perfil;
  ?>
  
<center>
    <div>
        <div class="container-clearfix" style="background-color: #e085ec ; width: 35%; height: 435px;">
            <form>
                <br><br>
                <label class="form-label">Nome
                <input class="form-control text-center" id="disabledInput" type="text" placeholder="Admin" disabled>
                <br>
                <label class="form-label">Senha
                <input title="Alterar Senha" class="form-control text-center" type="password" placeholder="*****************"> 
                <br>
                <label class="form-label">Email
                <input title="Alterar Email" class="form-control text-center" id="disabledInput" type="text" placeholder="admin@gmail.com.br">
                <br>
                <button class="btn btn-success">Salvar</button>
            </form>
        </div>
    </div>
</center>

  

  <?php
    echo $footer_adm;
  ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2e0e9e6c2.js" crossorigin="anonymous"></script>
</body>

</html>