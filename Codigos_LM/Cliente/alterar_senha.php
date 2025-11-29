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
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $id_usuario = $_SESSION['usuario_id']; 

    if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
        $mensagem = "<div class='alert alert-danger'>Preencha todos os campos.</div>";
    } 
    elseif ($nova_senha !== $confirma_senha) {
        $mensagem = "<div class='alert alert-danger'>A nova senha e a confirmação não conferem.</div>";
    } 
    elseif (strlen($nova_senha) < 6) {
        $mensagem = "<div class='alert alert-danger'>A nova senha deve ter no mínimo 6 caracteres.</div>";
    } 
    else {
        
        if (Cliente::verificarSenhaAtual($conn, $id_usuario, $senha_atual)) {
            
            if (Cliente::alterarSenha($conn, $id_usuario, $nova_senha)) {
                $mensagem = "<div class='alert alert-success'>Senha alterada com sucesso!</div>";
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro técnico ao atualizar senha.</div>";
            }
        } else {
            $mensagem = "<div class='alert alert-danger'>A senha atual está incorreta.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        body, html {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        main { flex: 1; }

        .page-banner {
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .card-custom {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
        }

        .form-control:focus {
            border-color: #a200b7;
            box-shadow: 0 0 0 2px rgba(162,0,183,0.2);
        }

        .btn-save {
            width: 100%;
            margin-top: 15px;
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9));
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: linear-gradient(90deg, rgba(162,0,183,0.9), rgba(49,15,75,0.9));
        }

        .btn-back {
            width: 100%;
            margin-top: 10px;
            background: rgba(162,0,183,0.1);
            color: #a200b7;
            border: 1px solid #a200b7;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-back:hover {
            background: rgba(162,0,183,0.2);
            transform: scale(1.02);
        }

        footer {
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php echo $navbar; ?>

    <main class="container mt-5 pt-5">
        <div class="page-banner">Alterar Senha</div>
        
        <div style="max-width: 500px; margin: 0 auto;">
            <?php echo $mensagem; ?>
        </div>

        <div class="card-custom">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="senha-atual" class="form-label">Senha Atual</label>
                    <input type="password" class="form-control" id="senha-atual" name="senha_atual" required>
                </div>
                <div class="mb-3">
                    <label for="nova-senha" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="nova-senha" name="nova_senha" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar-senha" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="confirmar-senha" name="confirma_senha" required>
                </div>
                
                <button type="submit" class="btn-save">Alterar Senha</button>
                
                <a href="perfil_cliente.php" class="btn-back">Voltar ao Perfil</a>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>