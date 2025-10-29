<?php
    $navbar = '<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand" href="index.html">
      <img src="../Cliente/img/LMinformatica_logo_h (2).svg" alt="Logo" width="200" class="img-fluid">
    </a>

    <!-- BOTÃO MOBILE -->
    <button class="navbar-toggler border-0" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- CONTEÚDO NAVBAR -->
    <div class="collapse navbar-collapse" id="navbarContent">

      <!-- CAMPO DE BUSCA CENTRAL -->
      <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 350px; width: 100%;">
        <input class="form-control rounded-start border-0" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
        <button class="btn btn-light rounded-end border-0" type="submit">Buscar</button>
      </form>

      <!-- LINKS E BOTÕES -->
      <ul class="navbar-nav ms-lg-auto align-items-lg-center mb-2 mb-lg-0 navbar">

        <li class="nav-item">
          <a class="nav-link" href="index.html">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="sobre.html">Sobre Nós</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="servicos.html">Serviços</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contato.html">Contato</a>
        </li>

        <li class="nav-item">
          <a class="nav-link carrinho d-flex align-items-center" href="carrinho.html">
            <img src="../Cliente/img/icone_carrinho.svg" alt="Carrinho" width="22" height="22">
          </a>
        </li>

        <li class="nav-item">
          <a href="entrar.html" class="btn btn-entrar ms-lg-3">
            Entrar
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>';




$navbar_adm = '<nav class="navbar navbar-expand-lg fixed-top navbar-custom">
  <div class="container-fluid">

  
    <a class="navbar-brand" href="index.html">
      <img src="../Cliente/img/LMinformatica_logo_h (2).svg" alt="Logo" width="200" class="img-fluid">
    </a>

   
    <button class="navbar-toggler border-0" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarUser"
      aria-controls="navbarUser" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarUser">

  
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#">Cadastrar Produto</a></li>
            <li><a class="dropdown-item" href="clientes.php">Clientes</a></li>
            <li><a class="dropdown-item" href="relatorios.php">Relatórios</a></li>
            <li><a class="dropdown-item" href="servico.php">Ordem de Servico</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>';
    
    
    
    
    $footer = '<footer class="text-center text-lg-start footer text-white py-4">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-12 col-md-4 mb-4 mb-md-0 text-center text-md-start">
        <a class="navbar-brand" href="index.html">
          <img src="img/LMinformatica_logo_h (2).svg" alt="Logo" width="200" class="img-fluid">
        </a>
      </div>

      <div class="col-12 col-md-4 mb-4 mb-md-0">
        <h5 class="fw-bold mb-3">Links Rápidos</h5>
        <ul class="list-unstyled">
          <li><a href="sobre.html" class="text-white text-decoration-none d-block py-1">Sobre Nós</a></li>
          <li><a href="servicos.html" class="text-white text-decoration-none d-block py-1">Serviços</a></li>
          <li><a href="contato.html" class="text-white text-decoration-none d-block py-1">Contato</a></li>
        </ul>
      </div>

      <div class="col-12 col-md-4">
        <h5 class="fw-bold mb-3">Contato</h5>
        <ul class="list-unstyled mb-0">
          <li class="py-1"><i class="fas fa-phone me-2"></i> (XX) XXXX-XXXX</li>
          <li class="py-1"><i class="fas fa-envelope me-2"></i> contato@lminformatica.com.br</li>
        </ul>
      </div>
    </div>

    <hr class="my-4 bg-light opacity-50">

    <div class="text-center small">
      &copy; 2025 LM Informática. Todos os direitos reservados.
    </div>
  </div>
</footer>
';


$head = '<meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>LM Informática</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>
        <link rel="stylesheet" href=".../Cliente/css/style.css">
        <link rel="stylesheet" href="../Cliente/css/style.css">
        
        <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">';



 $footer_adm = '<footer class="text-center text-lg-start footer text-white py-2">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-12 col-md-4 mb-3 mb-md-0 text-center text-md-start">
        <a class="navbar-brand" href="index.html">
          <img src="../Cliente/img/LMinformatica_logo_h (2).svg" alt="Logo" width="180" class="img-fluid">
        </a>
      </div>

      <div class="text-center small">
        &copy; 2025 LM Informática. Todos os direitos reservados.
      </div>

    </div>
  </div>
</footer>
';










$navbar_adm_relatorio = '<nav class="navbar navbar-expand-lg fixed-top navbar-custom">
  <div class="container-fluid">

 
    <a class="navbar-brand" href="index.html">
      <img src="../Cliente/img/LMinformatica_logo_h (2).svg" alt="Logo" width="200" class="img-fluid">
    </a>

   
    <button class="navbar-toggler border-0" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarUser"
      aria-controls="navbarUser" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarUser">

  
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="dashboard.php">Perfil</a></li>
            <li><a class="dropdown-item" href="clientes.php">Clientes</a></li>
            <li><a class="dropdown-item" id="ativo" href="relatorios.php">Relatorios</a></li>
            <li><a class="dropdown-item" href="servicos.php">Ordem de Servico</a></li>
            <li><a class="dropdown-item" href="../Cliente/entrar.php">Sair</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>';


$navbar_adm_clientes  = '<nav class="navbar navbar-expand-lg fixed-top navbar-custom">
  <div class="container-fluid">

    <a class="navbar-brand" href="index.html">
      <img src="../Cliente/img/LMinformatica_logo_h (2).svg" alt="Logo" width="200" class="img-fluid">
    </a>

    <button class="navbar-toggler border-0" type="button"
      data-bs-toggle="collapse" data-bs-target="#navbarUser"
      aria-controls="navbarUser" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarUser">

      <!-- FORMULÁRIO DE BUSCA -->
      <form class="d-flex align-items-center ms-auto me-3" role="search">
        <input class="form-control me-2" style="width: 400px:" type="search" placeholder="Faça sua pesquisa aqui" aria-label="Search">
        <button class="btn btn-button" style="color: white" type="submit">Buscar</button>
      </form>

      <!-- MENU DO USUÁRIO -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
              class="bi bi-person-fill" viewBox="0 0 16 16">
              <path
                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" id="ativo" href="clientes.php">Clientes</a></li>
            <li><a class="dropdown-item" href="relatorios.php">Relatorios</a></li>
            <li><a class="dropdown-item" href="servicos.php">Ordem de Servico</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav>';


$botao_tabela_clientes = '<button class="btn btn-button" data-bs-toggle="modal" data-bs-target="#modalEditar">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
    </svg>
  </button>

 
  <button class="btn btn-button" data-bs-toggle="modal" data-bs-target="#modalExcluir">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
      <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
    </svg>
  </button>
</td>



<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="container modal-dialog">
    <div class="modal-content">
      <div id="ativo" class="modal-header text-white">
        <h5 class="ativo" id="modalEditarLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="POST">
          <div class="col-md-12">
            <label for="nomeCliente" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Telefone</label>
            <input type="text" class="form-control id="telefoneCliente" placeholder="Digite o telefone">
            </div>
          <div class="col-md-12">
            <label for="nomeCliente" class="form-label">Nome</label>
            <input type="text" id="cep" class="form-control" placeholder="Digite seu CEP (Apenas números)" name="cep" onblur="buscarCEP()">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="logragouro" placeholder="Endereço">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Numero</label>
            <input type="text" class="form-control" id="numero" placeholder="Numero">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" placeholder="bairro">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" placeholder="Cidade">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="uf" placeholder="Numero">
          </div>
          <button type="submit" style="margin-top: 30px;" class="btn btn-success w-100">Salvar alterações</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalExcluirLabel">Confirmar exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Tem certeza de que deseja excluir este cliente?</p>
        <button type="button" class="btn btn-danger">Excluir</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

';






$botao_tabela_servico = '<button title="Editar" class="btn btn-button" data-bs-toggle="modal" data-bs-target="#modalEditar">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
      <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
    </svg>
  </button>

 
  <button title="Concluir" class="btn btn-button" data-bs-toggle="modal" data-bs-target="#modalExcluir">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg>
  </button>
</td>



<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="container modal-dialog">
    <div class="modal-content">
      <div id="ativo" class="modal-header text-white">
        <h5 class="ativo" id="modalEditarLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="POST">
          <div class="col-md-12">
            <label for="nomeCliente" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nomeCliente" placeholder="Digite o nome">
          </div>
          <div class="col-md-12">
            <label for="telefoneCliente" class="form-label">Telefone</label>
            <input type="text" class="form-control id="telefoneCliente" placeholder="Digite o telefone">
            </div>
          <div class="col-md-12">
            <label for="DigiteCEP" class="form-label">Digite seu CEP</label>
            <input type="text" id="cep" class="form-control" placeholder="Digite seu CEP (Apenas números)" name="cep" onblur="buscarCEP()">
          </div>
          <div class="col-md-12">
            <label for="Endereço" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="logragouro" placeholder="Endereço">
          </div>
          <div class="col-md-12">
            <label for="Número" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" placeholder="Número">
          </div>
          <div class="col-md-12">
            <label for="Bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" placeholder="bairro">
          </div>
          <div class="col-md-12">
            <label for="Cidade" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="cidade" placeholder="Cidade">
          </div>
          <div class="col-md-12">
            <label for="CPF" class="form-label">CPF</label>
            <input type="text" class="form-control" id="uf" placeholder="CPF">
          </div>
          <button type="submit" style="margin-top: 30px;" class="btn btn-success w-100">Salvar alterações</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalExcluirLabel">Confirmar exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center">
        <p>Tem certeza de que deseja excluir este cliente?</p>
        <button type="button" class="btn btn-danger">Excluir</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

';


?>


