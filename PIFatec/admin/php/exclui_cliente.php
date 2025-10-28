<?php
include '../Classes/admin.php'; 

if (isset($_GET['id_cliente']) && !empty($_GET['id_cliente'])) {
    
    $cliente = (int)$_GET['id_cliente'];

    try {
        Admin::excluir($cliente);


        header("Location: ../clientes.php?status=excluido");
        exit;

    } catch (PDOException $e) {
        die($e->getMessage());
    }

} else {
    header("Location: ../clientes.php");
    exit;
}
?>