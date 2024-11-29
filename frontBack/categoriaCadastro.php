<?php
require_once('../startup/connectBD.php');
include('../backBack/cadastro/categoria.php');

session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === 'adm' || $_SESSION['tipo_usuario'] === 'dev'))) {
    header('Location: ../public/login.php');
    exit();
}


if (isset($_POST['nome_categoria'], $_POST['descricao_categoria'])) {
    cadastra_categoria($mysqli, $_POST['nome_categoria'], $_POST['descricao_categoria']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cadastro de Categoria</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../images/Logo-removebg-preview.png" alt="Logo" height="70px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" href="../public/home.html">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list/listPortfa.php">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list/listCategoris.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list/listUser.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../backBack/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <p class="text-center">CADASTRO DE CATEGORIAS</p>
</header>

<main id="main-login">
    <div id="form-container">
        <form action="" method="post" class="form-login">
            <h3>Nova Categoria</h3>

            <div class="mb-3">
                <label for="nome_categoria" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" required>
                
            </div>
            <div id="categoriaError" class="text-danger mt-1" style="display: none;"></div>

            <div class="mb-3">
                <label for="descricao_categoria" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao_categoria" name="descricao_categoria" rows="3" required></textarea>
            </div>
            <div class="text">
                <?php if (isset($mensagem)) { echo $mensagem; } ?>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-secondary" id="submitBtn">
                    Finalizar Cadastro <i class="bi bi-check2-square"></i>
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+967JBw1Pj0I3GkF7h7o7AOvwf0bo" crossorigin="anonymous"></script>
    <script>
        document.getElementById('nome_categoria').addEventListener('blur', function() {
        var categoria = this.value;
        var categoriaError = document.getElementById('categoriaError');
        var submitBtn = document.getElementById('submitBtn');

        if (categoria) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../verificaCategoria.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        categoriaError.style.display = 'block';
                        categoriaError.innerText = 'Já existe essa categoria.';
                        submitBtn.disabled = true;
                    } else {
                        categoriaError.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                }
            };
            xhr.send('categoria=' + encodeURIComponent(categoria));
        } else {
            categoriaError.style.display = 'none';
            submitBtn.disabled = false; 
        }
    });

    </script>
</body>
</html>
