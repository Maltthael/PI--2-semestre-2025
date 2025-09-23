<?php
include "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu principal</title>
</head>
<body>
    <h1>Cadastrar cliente</h1>
    <form method="POST" action="incluir_cliente.php">
        <input type="email" name="email" placeholder="Digite seu e-mail" required> <br><br>
         <input type="text" name="username" placeholder="Digite seu nome" required> <br><br>
          <input type="password" name="password" placeholder="Digite sua senha" required> <br><br>
          <input type="text" name="CEP" placeholder="CEP" required> <br><br>
          <button type="submit">Cadastrar</button>
    </form>
    <br>
    <a href="index.php">Voltar para o menu principal</a>
</body>
</html>