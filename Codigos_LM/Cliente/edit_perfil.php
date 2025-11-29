<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: entrar.php");
    exit;
}

require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/cliente.php';

$conn = conecta_bd::getInstance()->getConnection();
$id_cliente = $_SESSION['usuario_id'];
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados_novos = [
        'nome'      => $_POST['nome'],
        'email'     => $_POST['email'],
        'telefone'  => $_POST['telefone'],
        'endereco'  => $_POST['endereco'],
        'numero'    => $_POST['numero'],
        'bairro'    => $_POST['bairro'],
        'cidade'    => $_POST['cidade'],
        'estado'    => $_POST['estado'],
        'cep'       => $_POST['cep']
    ];

    if (Cliente::atualizarDados($conn, $id_cliente, $dados_novos)) {
        $_SESSION['usuario_nome'] = $dados_novos['nome'];
        $mensagem = "<div class='alert alert-success'>Dados atualizados com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar dados.</div>";
    }
}

$dados = Cliente::buscarDadosPorId($conn, $id_cliente);

if (!$dados) {
    echo "Erro ao carregar dados.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        body, html { min-height: 100%; display: flex; flex-direction: column; background-color: #f5f5f5; }
        main { flex: 1; }
        .page-banner {
            background: linear-gradient(90deg, rgba(0,0,128,0.9) 0%, rgba(49,15,75,0.9) 50%, rgba(162,0,183,0.9) 100%);
            height: 120px; display: flex; justify-content: center; align-items: center;
            color: white; font-size: 1.8rem; font-weight: bold; border-radius: 8px; margin-bottom: 30px; text-align: center;
        }
        .card-custom { background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 30px; }
        .form-control:focus { border-color: #a200b7; box-shadow: 0 0 0 2px rgba(162,0,183,0.2); }
        .btn-save {
            width: 100%; margin-top: 15px; background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9));
            color: white; border: none; border-radius: 5px; padding: 12px; font-weight: bold; transition: all 0.3s ease;
        }
        .btn-save:hover {
            background: linear-gradient(90deg, rgba(162,0,183,0.9), rgba(49,15,75,0.9)); transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        footer {
            background: linear-gradient(90deg, rgba(0,0,128,0.9) 0%, rgba(49,15,75,0.9) 50%, rgba(162,0,183,0.9) 100%);
            color: white; padding: 20px 0; text-align: center;
        }
    </style>
</head>
<body>

    <?php echo $navbar; ?>

    <main class="container mt-5 pt-5">
        <div class="page-banner">Editar Perfil</div>
        
        <?php echo $mensagem; ?>

        <div class="card-custom">
            <form method="POST" action="">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($dados['nome']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($dados['email']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cpf" class="form-label">CPF (Não editável)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control bg-light" id="cpf" value="<?php echo htmlspecialchars($dados['cpf']); ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($dados['telefone']); ?>">
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 text-secondary">Endereço de Entrega</h5>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" value="<?php echo htmlspecialchars($dados['cep']); ?>">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="endereco" class="form-label">Rua / Logradouro</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo htmlspecialchars($dados['endereco']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="<?php echo htmlspecialchars($dados['numero']); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo htmlspecialchars($dados['bairro']); ?>">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo htmlspecialchars($dados['cidade']); ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="estado" class="form-label">Estado (UF)</label>
                        <input type="text" class="form-control" id="estado" name="estado" value="<?php echo htmlspecialchars($dados['estado']); ?>" maxlength="2">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="perfil_cliente.php" class="btn btn-outline-secondary mt-3 w-50">Voltar</a>
                    <button type="submit" class="btn-save w-50">Salvar Alterações</button>
                </div>

            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            &copy; 2025 LM Informática. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            var cep = this.value.replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {

                    var loading = document.getElementById('loading-cep');
                    if(loading) loading.style.display = 'block';

                    document.getElementById('endereco').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('estado').value = "...";

                    var script = document.createElement('script');
                    
                    window.meu_callback = function(conteudo) {
                        if (!("erro" in conteudo)) {
                            document.getElementById('endereco').value = (conteudo.logradouro);
                            document.getElementById('bairro').value = (conteudo.bairro);
                            document.getElementById('cidade').value = (conteudo.localidade);
                            document.getElementById('estado').value = (conteudo.uf);
                            
                            document.getElementById('numero').focus();
                        } else {
                            limparFormularioCep();
                            alert("CEP não encontrado.");
                        }
                        if(loading) loading.style.display = 'none';
                    };

                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                    document.body.appendChild(script);

                } else {
                    limparFormularioCep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limparFormularioCep();
            }
        });

        function limparFormularioCep() {
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('estado').value=("");
            
            var loading = document.getElementById('loading-cep');
            if(loading) loading.style.display = 'none';
        }
    </script>
</body>
</html>