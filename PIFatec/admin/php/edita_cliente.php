<?php
require_once '../Classes/admin.php';  

$cliente = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        Admin::atualizar($_POST);
        header("Location: clientes.php?status=editado");
        exit;

    } catch (PDOException $e) {
        $erro_update = $e->getMessage();
        $cliente = $_POST; 
    }
}

?>
