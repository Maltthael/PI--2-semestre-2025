<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"]== "POST"){
    $email = $_POST['email'];
    $name = $_POST['name'];
    $tel = $_POST['telefone'];
    $cpf = $_POST['CPF'];
    $cargo = $_POST['cargo'];
    $sql = "INSERT INTO vendedor (email, name, telefone, CPF, cargo) VALUES
    ('$email', '$name', '$tel', '$cpf', '$cargo' )";

    if (mysqli_query( $conn, $sql)) {
        header(header: "Location: cadastro_funcionario.php");

    } else {
        echo "Erro: ". mysqli_error(mysql: $conn);
    }
}