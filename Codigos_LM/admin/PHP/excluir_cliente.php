<?php

require_once '../../Classes/conecta.php';
require_once '../../Classes/admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cliente'])) {
    try {
        Admin::excluir($_POST['id_cliente']);
        $_SESSION['mensagem'] = "Cliente excluído com sucesso.";
        $_SESSION['tipoMensagem'] = "success";
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        $_SESSION['tipoMensagem'] = "danger";
    }
}

header("Location: ../clientes.php");
exit;

?>