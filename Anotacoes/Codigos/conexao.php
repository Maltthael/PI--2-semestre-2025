<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "bd-pi2";



$conn = mysqli_connect(hostname: $host, username: $user, password: $pass, database: $db);


if(!$conn) {
    die("Erro de conexão: ". mysqli_connect_error());
}
?>
