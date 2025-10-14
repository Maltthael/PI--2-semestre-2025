<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"]== "POST"){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cep = $_POST['CEP'];
    $sql = "INSERT INTO cliente (email, username, password, CEP) VALUES
    ('$email', '$username', '$password', '$cep')";

    if (mysqli_query( $conn, $sql)) {
        header(header: "Location: cadastro_cliente.php");

    } else {
        echo "Erro: ". mysqli_error(mysql: $conn);
    }
}