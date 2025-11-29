<?php
session_start();
require_once '../Classes/conecta.php';
require_once '../Classes/layout.php';
require_once '../Classes/cliente.php'; 

$conn = conecta_bd::getInstance()->getConnection();
$mensagem_feedback = "";

$dados_usuario = ['nome' => '', 'email' => '', 'telefone' => ''];
$esta_logado = false;

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['usuario_tipo'] === 'cliente') {
    $esta_logado = true;
    $id_cliente = $_SESSION['usuario_id'];
    
    $dados = Cliente::buscarDadosPorId($conn, $id_cliente);
    if ($dados) {
        $dados_usuario = $dados;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$esta_logado) {
        $mensagem_feedback = "<div class='alert alert-warning'>Você precisa fazer <b>Login</b> para abrir um chamado.</div>";
    } else {
        $assunto = $_POST['assunto'];
        $servico = $_POST['servico'];
        
        if (Cliente::abrirOrdemServico($conn, $id_cliente, $assunto, $servico)) {
            $mensagem_feedback = "<div class='alert alert-success'>Ordem de Serviço aberta com sucesso!</div>";
        } else {
            $mensagem_feedback = "<div class='alert alert-danger'>Erro ao abrir Ordem de Serviço.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contato.css">
    <link rel="stylesheet" href="css/vendas.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
</head>

<body>
    <?php echo $navbar; ?>
    
    <section class="contact-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Fale Conosco</h1>
                    <p class="lead">Abra um chamado técnico e acompanhe pelo seu perfil</p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-main py-5">
        <div class="container">
            
            <?php if (!empty($mensagem_feedback)) echo $mensagem_feedback; ?>

            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="contact-card">
                        <h2 class="section-title mb-4">Informações de Contato</h2>
                        
                        <div class="contact-info">
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="info-content">
                                    <h4>Endereço</h4>
                                    <p>Rua José Nelson Guiray, 447 - Jardim Apolo<br>Araras/SP</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                                <div class="info-content">
                                    <h4>Telefone</h4>
                                    <p>(19) 98939-1398 (WhatsApp)</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                                <div class="info-content">
                                    <h4>Email</h4>
                                    <p>lmtecnologia1100@outlook</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="social-links mt-5">
                            <h4 class="mb-3">Redes Sociais</h4>
                            <div class="d-flex gap-3">
                                <a href="https://www.facebook.com/profile.php?id=61567172393826&sk=about" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/lminformatica100" class="social-icon"><i class="fab fa-instagram"></i></a>
                                <a href="https://api.whatsapp.com/send/?phone=19989391398&text&type=phone_number&app_absent=0t" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h2 class="section-title mb-4">Abrir Ordem de Serviço</h2>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?php echo htmlspecialchars($dados_usuario['nome']); ?>" 
                                       <?php echo $esta_logado ? 'readonly' : ''; ?> required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($dados_usuario['email']); ?>" 
                                           <?php echo $esta_logado ? 'readonly' : ''; ?> required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="tel" class="form-control" id="telefone" name="telefone" 
                                           value="<?php echo htmlspecialchars($dados_usuario['telefone']); ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="assunto" class="form-label">Assunto</label>
                                <select class="form-select" id="assunto" name="assunto" required>
                                    <option value="" selected disabled>Selecione um assunto</option>
                                    <option value="Orçamento">Orçamento</option>
                                    <option value="Dúvida Técnica">Dúvida Técnica</option>
                                    <option value="Manutenção">Solicitar Manutenção</option>
                                    <option value="Garantia">Garantia</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="servico" class="form-label">Serviço</label>
                                <select class="form-select" id="servico" name="servico" required>
                                    <option value="" selected disabled>Selecione o equipamento</option>
                                    <option value="Notebook">Notebook</option>
                                    <option value="Desktop">Desktop (PC)</option>
                                    <option value="Impressora">Impressora</option>
                                    <option value="Periféricos">Periféricos</option>
                                    <option value="Outros">Outro</option>
                                </select>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Abrir Chamado</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 footer" style="color: white;">
        <div class="container">
            <p class="mb-0">&copy; 2025 LM Informática. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>