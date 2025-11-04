

<!DOCTYPE html>
<html lang="pt-br">

<head>
     <?php
    include 'bt5/classes.php';
    echo $head;
    ?>
        
</head>

<body>
    <?php
        echo $navbar;
    ?>

    <div class="centraliza">
        <div class="fundo-cadastro">
            <h3 style="text-align: center; margin-bottom: 30px; color: #333; ;">Cadastrar-se</h3>
            <form class="row g-3" method="POST" action="php/cadastro.php">
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Nome</label>
                    <input type="email" class="form-control" placeholder="Nome Completo" name="nome">
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Digite seu email" name="email">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Senha</label>
                    <input type="password" class="form-control" placeholder="Digite sua senha" name="senha">
                </div>
                <div class="col-6">
                    <label for="inputAddress" class="form-label">Endereço</label>
                    <input type="text" class="form-control" placeholder="Digite seu endereço" id="logradouro" name="endereco">
                </div>
                <div class="col-3">
                    <label for="inputAddress" class="form-label">N°</label>
                    <input type="text" class="form-control" placeholder="Numero" id="numero" name="numero">
                </div>
                <div class="col-4">
                    <label for="inputAddress" class="form-label">Bairro</label>
                    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro">
                </div>
                <div class="col-3">
                    <label for="inputAddress" class="form-label">Cidade</label>
                    <input type="text" class="form-control" placeholder="Cidade" id="cidade" name="cidade">
                </div>
                <div class="col-2">
                    <label for="inputAddress" class="form-label">Estado</label>
                    <input type="text" class="form-control" placeholder="UF" id="uf" name="estado">
                </div>
                <div class="col-6">
                    <label for="inputAddress" class="form-label">CEP</label>
                    <input type="text" id="cep" class="form-control" placeholder="Digite seu CEP (Apenas números)" name="cep" onblur="buscarCEP()">
                </div>

                <div class="col-6">
                    <label for="inputAddress" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Digite seu CPF" name="cpf">
                </div>
                <div style="margin-top: 20px; text-align: center;">
                    <a href="entrar.html">
                    <button type="submit" class="btn-cadastrar btn-entrar">Cadastrar-se</button>
                    </a>
                </div>
                <div style="margin-top: 20px; text-align: center;">
                    <button class="btn btn-primary">
                        <a style='color: white' href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">Nao sei meu CEP</a>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

 
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



<script>
    async function buscarCEP() {
      const cep = document.getElementById('cep').value.replace(/\D/g, ''); // remove não dígitos

      if (cep.length !== 8) {
        alert('CEP inválido! Digite um CEP com 8 números.');
        return;
      }

      try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
          alert('CEP não encontrado!');
          return;
        }

        // Preenche os campos
        document.getElementById('logradouro').value = data.logradouro || '';
        document.getElementById('bairro').value = data.bairro || '';
        document.getElementById('cidade').value = data.localidade || '';
        document.getElementById('uf').value = data.uf || '';

      } catch (error) {
        alert('Erro ao consultar o CEP. Tente novamente.');
        console.error(error);
      }
    }
  </script>

  <?php
    echo $footer;
  ?>
