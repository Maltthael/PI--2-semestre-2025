<?php 
session_start();

require_once '../Classes/conecta.php';
require_once '../Classes/cliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recebendo os dados do formulário (Incluindo Telefone)
    $nome     = $_POST['nome'] ?? '';
    $email    = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? ''; // <--- NOVO
    $senha    = $_POST['senha'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $numero   = $_POST['numero'] ?? '';
    $bairro   = $_POST['bairro'] ?? '';
    $cidade   = $_POST['cidade'] ?? '';
    $estado   = $_POST['estado'] ?? '';
    $cep      = $_POST['cep'] ?? '';
    $cpf      = $_POST['cpf'] ?? '';

    // conexão
   $conecta = conecta_bd::getInstance();
     
    // 2. Instanciando o Cliente (ATENÇÃO: A ordem aqui deve bater com sua Classe Cliente.php)
    // Estou assumindo que você vai adicionar o telefone depois do email na sua classe.
    $cliente = new Cliente($nome, $email, $telefone, $senha, $endereco, $numero, $bairro, $cidade, $estado, $cep, $cpf);

    // Chama o método cadastrar e passa a conexão
    $resultado = $cliente->cadastrar($conecta);

    // Verifica o retorno
    if ($resultado === true) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='entrar.php';</script>";
    } elseif ($resultado === false) {
        echo "<script>alert('Falha no cadastro!');</script>";
    } else {
        // mostra mensagem de erro
        echo "<script>alert('$resultado');</script>";
    }

    $msg="";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
</head>

<body>
    <nav class="navbar navbar-custom navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid ">
            <div class="fundo_imagem">
                <a class="navbar-brand home-link " href="index.html">
                    <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200">
                </a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" style="color: white;" href="sobre.html">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" style="color: white;" href="servicos.html">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" style="color: white;" href="contato.html">Contato</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="centraliza">
        <div class="fundo-cadastro">
            <h3 style="text-align: center; margin-bottom: 30px; color: #333;">Cadastrar-se</h3>
            
            <form class="row g-3" method="POST" action="">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" placeholder="Nome Completo" name="nome" required>
                </div>
                
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Digite seu email" name="email" id="email" required>
                </div>
                
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" placeholder="(XX) 99999-9999" name="telefone" id="telefone" required>
                </div>

                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Senha</label>
                    <input type="password" class="form-control" placeholder="Digite sua senha" name="senha" required>
                </div>

                <div class="col-md-6">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" id="cep" class="form-control" placeholder="Apenas números" name="cep" maxlength="9" onblur="buscarCEP()" required>
                </div>
                
                 <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" placeholder="Digite seu CPF" name="cpf" required>
                </div>

                <div class="col-md-6">
                    <label for="logradouro" class="form-label">Endereço</label>
                    <input type="text" class="form-control" placeholder="Rua, Avenida..." id="logradouro" name="endereco" required>
                </div>
                
                <div class="col-md-2">
                    <label for="numero" class="form-label">N°</label>
                    <input type="text" class="form-control" placeholder="Nº" id="numero" name="numero" required>
                </div>
                
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro" required>
                </div>
                
                <div class="col-md-6">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" placeholder="Cidade" id="cidade" name="cidade" required>
                </div>
                
                <div class="col-md-6">
                    <label for="uf" class="form-label">Estado</label>
                    <input type="text" class="form-control" placeholder="UF" id="uf" name="estado" required>
                </div>

                <div class="col-12 mt-4 text-center">
                    <button type="submit" class="btn-cadastrar btn-entrar">Cadastrar-se</button>    
                </div>
                <div class="col-12 mt-2 text-center">
                    <a class="btn btn-sm btn-link" href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">
                        Não sei meu CEP
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center py-4 footer" style="color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="fundo_imagem">
                        <a class="navbar-brand home-link" href="index.html">
                            <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Links Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a class="nav-link active" href="sobre.html">Sobre Nós</a></li>
                        <li><a class="nav-link" href="servicos.html">Serviços</a></li>
                        <li><a class="nav-link" href="contato.html">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contato</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> (XX) XXXX-XXXX</li>
                        <li><i class="fas fa-envelope me-2"></i> contato@lminformatica.com.br</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Efeito de scroll na navbar
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Função de Buscar CEP
        async function buscarCEP() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length !== 8) {
                // Se o campo estiver vazio, não perturba o usuário com alerta, só retorna
                if(cep.length > 0) alert('CEP inválido! Digite 8 números.');
                return;
            }

            try {
                // Feedback visual simples
                document.getElementById('logradouro').value = "...";
                
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    alert('CEP não encontrado!');
                    document.getElementById('logradouro').value = "";
                    return;
                }

                document.getElementById('logradouro').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('uf').value = data.uf || '';
                document.getElementById('numero').focus();

            } catch (error) {
                alert('Erro ao consultar o CEP.');
                console.error(error);
                document.getElementById('logradouro').value = "";
            }
        }
    </script>
</body>
</html>