<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$botao_login = '
<li class="nav-item">
    <a href="entrar.php" class="btn-entrar btn btn-black ms-lg-3">Entrar</a>
</li>';

$item_cadastro = '<li class="nav-item"><a class="nav-link active" href="cadastro.php">Cadastrar</a></li>';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && !empty($_SESSION['usuario_nome'])) {
    
    $primeiro_nome = explode(' ', $_SESSION['usuario_nome'])[0];

    $link_perfil = ($_SESSION['usuario_tipo'] === 'admin') ? '../admin/dashboard.php' : 'perfil_cliente.php';
    
    $botao_login = '
    <li class="nav-item dropdown ms-lg-3">
        <a class="nav-link dropdown-toggle btn btn-outline-light text-dark bg-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 20px; border-radius: 20px; font-weight: bold;">
            <i class="fas fa-user me-1"></i> ' . htmlspecialchars($primeiro_nome) . '
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="' . $link_perfil . '"><i class="fas fa-id-card me-2"></i>Meu Perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../Classes/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
        </ul>
    </li>';

    $item_cadastro = '';
}

$navbar = '
<nav class="navbar navbar-custom navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <div class="fundo_imagem">
            <a class="navbar-brand home-link" href="index.php">
                <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="220">
            </a>
        </div>
        
        <button class="navbar-toggler ms-auto border-0 d-lg-none" type="button" 
                data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex my-2 my-lg-0 mx-lg-auto" style="max-width: 350px; width: 100%;">
                <input class="form-control rounded-start border-0 comeco" type="search" placeholder="Pesquisar">
                <button class="btn btn-light rounded-end border-0 final" type="submit">Buscar</button>
            </form>
            
            <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0"> 
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                
                ' . $item_cadastro . '
                
                <li class="nav-item"><a class="nav-link active" href="sobre.php">Sobre Nós</a></li>
                <li class="nav-item"><a class="nav-link active" href="servicos.php">Serviços</a></li>
                <li class="nav-item"><a class="nav-link active" href="contato.php">Contato</a></li>
                <li class="nav-item">
                    <a class="nav-link carrinho" href="carrinho.php">
                        <img src="img/icone_carrinho.svg" alt="Carrinho">
                    </a>
                </li>
                
                ' . $botao_login . '
                
            </ul>
        </div>
    </div>
</nav>';



$css_admin = '
<style>
    /* Ajuste do corpo da página para não ficar escondido atrás da sidebar */
    body {
        padding-left: 280px;
        background-color: #f8f9fa;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    /* Estilo da Sidebar */
    .sidebar-admin {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 280px;
        background: linear-gradient(180deg, #1a1a1a 0%, #2c3e50 100%);
        color: white;
        padding-top: 20px;
        z-index: 1050;
        box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 20px;
    }

    .admin-profile {
        display: flex;
        align-items: center;
        padding: 15px 25px;
        background-color: rgba(255,255,255,0.05);
        margin-bottom: 10px;
    }
    
    .nav-link-admin {
        padding: 15px 30px;
        color: #adb5bd;
        text-decoration: none;
        display: block;
        font-size: 1.05rem;
        transition: all 0.3s;
        border-left: 5px solid transparent;
    }

    .nav-link-admin:hover, .nav-link-admin.active {
        background-color: rgba(255,255,255,0.1);
        color: white;
        border-left-color: #00b7a2; /* Cor destaque (verde água do gráfico) */
    }

    .nav-link-admin i {
        margin-right: 10px;
        width: 25px;
        text-align: center;
    }

    .logout-btn {
        margin-top: auto; /* Empurra para o final */
        background-color: #dc3545;
        color: white;
        text-align: center;
        padding: 15px;
        text-decoration: none;
        transition: 0.3s;
    }
    .logout-btn:hover { background-color: #c82333; color: white; }

    /* Responsividade para Mobile: Sidebar some e vira menu hambúrguer se necessário (opcional) */
    @media (max-width: 768px) {
        .sidebar-admin { width: 100%; height: auto; position: relative; }
        body { padding-left: 0; }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
';

if (session_status() === PHP_SESSION_NONE) session_start();

$nome_completo = $_SESSION['usuario_nome'] ?? 'Administrador';

$partes_nome = explode(' ', trim($nome_completo));
$primeiro_nome = $partes_nome[0];

$sidebar_content = '
<div class="sidebar-admin">
    <div class="sidebar-header">
        <img src="../Cliente/img/LMinformatica_logo.png" alt="LM Info" width="160" class="img-fluid">
    </div>

    <div class="admin-profile">
        <i class="fas fa-user-circle fa-2x me-3"></i>
        <div style="line-height: 1.2;">
            <small class="d-block text-light" style="opacity: 0.7;">Bem-vindo,</small>
            <strong class="text-white">' . htmlspecialchars($primeiro_nome) . '</strong>
        </div>
    </div>

    <nav class="nav flex-column mt-2">
        <a href="dashboard.php" class="nav-link-admin">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="produtos.php" class="nav-link-admin">
            <i class="fas fa-box-open"></i> Produtos
        </a>
        <a href="clientes.php" class="nav-link-admin">
            <i class="fas fa-users"></i> Clientes
        </a>
        <a href="servicos.php" class="nav-link-admin">
            <i class="fas fa-tools"></i> Ordens de Serviço
        </a>
        <a href="relatorios.php" class="nav-link-admin">
            <i class="fas fa-chart-pie"></i> Relatórios
        </a>
        <a href="perfil.php" class="nav-link-admin">
            <i class="fas fa-user-cog"></i> Meu Perfil
        </a>
    </nav>

    <a href="../Cliente/index.php" class="logout-btn">
        <i class="fas fa-sign-out-alt me-2"></i> Sair do Perfil
    </a>
</div>
';

$navbar_adm           = $css_admin . $sidebar_content;
$navbar_adm_relatorio = $css_admin . $sidebar_content;
$navbar_adm_clientes  = $css_admin . $sidebar_content;

$head = '<meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>LM Informática</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
         <link rel="icon" href="../Cliente/img/LMinformatica_logo.png" type="image/png">';

$footer = '<footer class="text-center text-lg-start footer text-white py-4">
  <div class="container">
    <div class="text-center small">&copy; 2025 LM Informática. Todos os direitos reservados.</div>
  </div>
</footer>';

$footer_adm = '<footer class="text-center py-4 text-muted border-top">
    <small>&copy; 2025 LM Informática - Painel Administrativo</small>
</footer>';

$botao_tabela_clientes = '
<div class="btn-group" role="group">
    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditar">
        <i class="bi bi-pencil-fill"></i>
    </button>
    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalExcluir">
        <i class="bi bi-trash-fill"></i>
    </button>
</div>
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Editar Cliente</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">Formulário aqui...</div></div></div>
</div>
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white"><h5 class="modal-title">Excluir</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">Confirmar exclusão?</div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Não</button><button class="btn btn-danger">Sim</button></div></div></div>
</div>';

$botao_tabela_servico = '
<div class="btn-group" role="group">
    <button title="Editar" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class="bi bi-pencil-fill"></i></button>
    <button title="Concluir" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalExcluir"><i class="bi bi-check-lg"></i></button>
</div>';
