<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - LM Informática</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/LMinformatica_logo.png" type="image/png">
    <style>
        body, html {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        main { flex: 1; }

        .page-banner {
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .card-custom {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
        }

        .form-control:focus {
            border-color: #a200b7;
            box-shadow: 0 0 0 2px rgba(162,0,183,0.2);
        }

        .btn-save {
            width: 100%;
            margin-top: 15px;
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9));
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: linear-gradient(90deg, rgba(162,0,183,0.9), rgba(49,15,75,0.9));
        }

        .btn-back {
            width: 100%;
            margin-top: 10px;
            background: rgba(162,0,183,0.1);
            color: #a200b7;
            border: 1px solid #a200b7;
            border-radius: 5px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-back:hover {
            background: rgba(162,0,183,0.2);
            transform: scale(1.02);
        }

        footer {
            background: linear-gradient(90deg, rgba(0,0,128,0.9), rgba(49,15,75,0.9), rgba(162,0,183,0.9));
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <div class="fundo_imagem">
                <a class="navbar-brand home-link" href="index.php">
                    <img src="img/LMinformatica_logo_h (2).svg" alt="Logo">
                </a>
            </div>
        </div>
    </nav>

    <main class="container mt-5 pt-5">
        <div class="page-banner">Alterar Senha</div>
        <div class="card-custom">
            <form>
                <div class="mb-3">
                    <label for="senha-atual" class="form-label">Senha Atual</label>
                    <input type="password" class="form-control" id="senha-atual">
                </div>
                <div class="mb-3">
                    <label for="nova-senha" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="nova-senha">
                </div>
                <div class="mb-3">
                    <label for="confirmar-senha" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="confirmar-senha">
                </div>
                <button type="submit" class="btn-save">Alterar Senha</button>
                <a href="perfil.html" class="btn-back">Voltar ao Perfil</a>
            </form>
        </div>
    </main>

    <footer class="fixed-bottom">
        &copy; 2025 LM Informática. Todos os direitos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
