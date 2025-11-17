<?php

$mensagem_edita_dados_adm = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $nova_senha = $_POST['senha'];
    
    
    $mensagem_edita_dados_adm = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Dados atualizados com sucesso!
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                 </div>";
}

?>