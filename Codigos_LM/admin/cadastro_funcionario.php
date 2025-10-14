<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Cadastro Funcionario</h1>
     <form method="POST" action="incluir_vendedor.php">
        <input type="email" name="email" placeholder="Digite seu e-mail" required> <br><br>
        <input type="text" name="name" placeholder="Digite seu nome" required> <br><br>
        <input type="text" name="telefone" placeholder="Digite seu telefone" required> <br><br>
        <input type="text" name="cargo" placeholder="Cargo" required> <br><br>
        <input type="text" name="CPF" placeholder="CPF" required> <br><br>
        <button type="submit">Cadastrar</button>
    </form>

      <a href="index.php">Voltar para o menu principal</a>
</body>
</html>