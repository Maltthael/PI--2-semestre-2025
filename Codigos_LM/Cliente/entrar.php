<?php 
session_start();

require_once '../Classes/conecta.php';
require_once '../Classes/Login.php'; 
include '../Classes/layout.php';

$erro = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $login = new Login();

    if ($login->autenticar($email, $senha)) {
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $erro = "Email ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LM Informática - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
</head>

<body>
    <?php echo $navbar; ?>

    <?php if (!empty($erro)) { ?>
    <div id="msgErro" class="alert alert-danger text-center" style="position: fixed; top: 80px; left: 50%; transform: translateX(-50%); z-index: 1000; width: 80%; max-width: 500px;">
        <?= htmlspecialchars($erro) ?>
    </div>

    <script>
        const msg = document.getElementById("msgErro");
        
        setTimeout(() => {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 500); 
        }, 3000);
    </script>
    <?php } ?>


    <form method="POST" action="">
        <div class="centraliza">
            <div class="fundo">
                <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Login</h2>
                
                <div class="form-group">
                    <input type="email" name="email" class="form-control" style="border-radius: 5px;" placeholder="Email" required>
                </div>
                
                <div class="form-group">
                    <input type="password" name="senha" class="form-control" style="border-radius: 5px;" placeholder="Senha" required>
                </div>
                
                <button type="submit" class="btn-login">Entrar</button>
                
                <div style="margin-top: 20px; text-align: center;">
                    <a href="cadastro.php">
                        <button type="button" class="btn-cadastrar">Cadastrar-se</button>
                    </a>
                </div>
            </div>
        </div>
    </form>
       
    
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
                        <li class="nav-item">
                            <a class="nav-link active" href="sobre.html">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="servicos.html">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contato.html">Contato</a>
                        </li>
                        <li>
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
</body>

</html>