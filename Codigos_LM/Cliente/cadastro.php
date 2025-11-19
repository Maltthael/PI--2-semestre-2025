<?php 
session_start();

require_once '../Classes/conecta.php';
require_once '../Classes/cliente.php';

$dados = [
    'nome' => '', 'email' => '', 'telefone' => '', 'endereco' => '', 
    'numero' => '', 'bairro' => '', 'cidade' => '', 'estado' => '', 'cep' => '', 'cpf' => ''
];

$alerta_script = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = $_POST; 

    $nome     = $_POST['nome'] ?? '';
    $email    = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha    = $_POST['senha'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $numero   = $_POST['numero'] ?? '';
    $bairro   = $_POST['bairro'] ?? '';
    $cidade   = $_POST['cidade'] ?? '';
    $estado   = $_POST['estado'] ?? '';
    $cep      = $_POST['cep'] ?? '';
    $cpf      = $_POST['cpf'] ?? '';

    try {
        $conecta = conecta_bd::getInstance();
        $cliente = new Cliente($nome, $email, $telefone, $senha, $endereco, $numero, $bairro, $cidade, $estado, $cep, $cpf);
        
        $resultado = $cliente->cadastrar($conecta);

        if ($resultado === true) {
            $alerta_script = "
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Cadastro realizado com sucesso! Clique para entrar.',
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Ir para Login'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'entrar.php';
                    }
                });
            ";
        } elseif (is_string($resultado)) {
            $alerta_script = "
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção',
                    text: '" . addslashes($resultado) . "', // Exibe: 'Email já cadastrado'
                    confirmButtonColor: '#0d6efd'
                });
            ";
        } else {
            $alerta_script = "
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao realizar o cadastro. Tente novamente.',
                    confirmButtonColor: '#0d6efd'
                });
            ";
        }

    } catch (Exception $e) {
        $alerta_script = "
            Swal.fire({
                icon: 'error',
                title: 'Erro de Sistema',
                text: '" . addslashes($e->getMessage()) . "',
                confirmButtonColor: '#0d6efd'
            });
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar-se | LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
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
                    <input type="text" class="form-control" name="nome" placeholder="Nome Completo:" value="<?= htmlspecialchars($dados['nome']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Digite seu email:" value="<?= htmlspecialchars($dados['email']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" name="telefone" placeholder="(XX) 99999-9999" value="<?= htmlspecialchars($dados['telefone']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha" placeholder="Digite sua senha" required>
                </div>
                <div class="col-md-6">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" id="cep" class="form-control" name="cep" maxlength="9" placeholder="Apenas números" value="<?= htmlspecialchars($dados['cep']) ?>" onblur="buscarCEP()" required>
                </div>
                 <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF" value="<?= htmlspecialchars($dados['cpf']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="logradouro" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="logradouro" name="endereco" placeholder="Rua, Avenida..." value="<?= htmlspecialchars($dados['endereco']) ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">N°</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Nº" value="<?= htmlspecialchars($dados['numero']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Centro, Jardim..." value="<?= htmlspecialchars($dados['bairro']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Sua cidade" value="<?= htmlspecialchars($dados['cidade']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="uf" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="uf" name="estado" placeholder="SP" value="<?= htmlspecialchars($dados['estado']) ?>" required>
                </div>

                <div class="col-12 mt-4 text-center">
                    <button type="submit" class="btn-cadastrar btn-entrar">Cadastrar-se</button>    
                </div>
                <div class="col-12 mt-2 text-center">
                    <a class="btn btn-sm btn-link" href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">Não sei meu CEP</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center py-4 footer" style="color: white;">
        <div class="container"><p class="mb-0">&copy; 2025 LM Informática.</p></div>
    </footer>

    <?php if (!empty($alerta_script)): ?>
    <script>
        <?= $alerta_script ?>
    </script>
    <?php endif; ?>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (!empty($alerta_script)): ?>
    <script>
        <?= $alerta_script ?>
    </script>
    <?php endif; ?>

    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); } 
            else { navbar.classList.remove('scrolled'); }
        });

        async function buscarCEP() {
            const cepInput = document.getElementById('cep');
            const cep = cepInput.value.replace(/\D/g, '');

            if (cep.length !== 8) {
                if(cep.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'CEP Inválido',
                        text: 'O CEP deve conter exatamente 8 números.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                return;
            }

            document.getElementById('logradouro').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    Swal.fire('Erro', 'CEP não encontrado na base de dados!', 'error');
                    limparCamposEndereco();
                    return;
                }

                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('uf').value = data.uf;
                document.getElementById('numero').focus();

            } catch (error) {
                console.error(error);
                Swal.fire('Erro', 'Falha ao conectar com o serviço de CEP.', 'error');
                limparCamposEndereco();
            }
        }

        function limparCamposEndereco() {
            document.getElementById('logradouro').value = "";
            document.getElementById('bairro').value = "";
            document.getElementById('cidade').value = "";
            document.getElementById('uf').value = "";
        }
    </script>
</body>
</html>
</body>
</html>