<?php
session_start();
require_once '../Classes/conecta.php';
require_once '../Classes/admin.php'; 
include '../Classes/layout.php';
include '../Classes/alertas.php';


if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../Cliente/entrar.php");
    exit;
}

$adm_nome = $_SESSION['usuario_nome'] ?? 'Administrador Principal';
$adm_email = $_SESSION['usuario_email'] ?? 'adminLM@gmail.com';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php echo $head; ?>
    <style>
        .profile-header {
            background: linear-gradient(90deg, #2c3e50, #4ca1af);
            height: 150px;
            border-radius: 10px 10px 0 0;
            position: relative;
            margin-bottom: 60px;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid #fff;
            position: absolute;
            bottom: -40px;
            left: 40px;
            background-color: #fff;
            object-fit: cover;
        }
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <?php echo $navbar_adm; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <?php echo $mensagem_edita_dados_adm; ?>

                <div class="card card-custom mb-4">
                    <div class="profile-header">
                        <img src="../Cliente/img/LMinformatica_logo.png" alt="Admin" class="profile-img">
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-8 offset-md-3">
                                <h2 class="mt-2"><?php echo htmlspecialchars($adm_nome); ?></h2>
                                <p class="text-muted">Gerente Geral / Administrador do Sistema</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-custom">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4><i class="fas fa-user-edit me-2 text-primary"></i>Editar Informações</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nome" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($adm_nome); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail de Acesso</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($adm_email); ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="senha" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Deixe em branco para não alterar">
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="confirmar_senha" placeholder="Confirme a senha">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permissões</label>
                                <div class="p-2 bg-light border rounded">
                                    <span class="badge bg-success me-1">Acesso Total</span>
                                    <span class="badge bg-primary me-1">Gerenciar Clientes</span>
                                    <span class="badge bg-info text-dark">Relatórios</span>
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2">Cancelar</button>
                                <button type="submit" class="btn btn-primary px-4">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


</body>
</html>