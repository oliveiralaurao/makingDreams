<?php
require_once('../startup/connectBD.php');
include('../backBack/cadastro/usuario.php');

session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === 'adm' || $_SESSION['tipo_usuario'] === 'dev'))) {
    header('Location: ../public/login.php');
    exit();
}

$mensagem = ""; // Variável para armazenar a mensagem

if (isset($_GET['msg'])) {
    $mensagem = htmlspecialchars($_GET['msg']);
}

if (isset($_POST['nomeCompleto'], $_POST['sobrenome'], $_POST['email'], $_POST['telefone'], $_POST['inputPassword6'], $_POST['inputPassword7'])) {
    $rede_social = isset($_POST['rede_social']) ? $_POST['rede_social'] : '';
    $hobbie = isset($_POST['hobbie']) ? $_POST['hobbie'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $foto = isset($_POST['foto']) ? $_POST['foto'] : '';

    cadastra($mysqli, $_POST['nomeCompleto'], $_POST['sobrenome'], $_POST['email'], $_POST['telefone'], $_POST['inputPassword6'], $_POST['inputPassword7'], $rede_social, $hobbie, $descricao, $foto);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cadastro</title>
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
    <p class="text-center">CADASTRO DE USUÁRIOS</p>
</header>

<main id="main-login">
    <div id="form-container">
        <form action="" method="post" class="form-login" enctype="multipart/form-data" onsubmit="return validarSenha()">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <h3>Novo Cadastro</h3>

            <div class="mb-3">
                <label for="nomeCompleto" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto" required>
            </div>

            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div id="emailError" class="text-danger mt-1" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required>
            </div>

            <div class="mb-3">
                <label for="inputPassword6" class="form-label">Senha</label>
                <input type="password" class="form-control" id="inputPassword6" name="inputPassword6" required>
            </div>

            <div class="mb-3">
                <label for="inputPassword7" class="form-label">Repetir Senha</label>
                <input type="password" class="form-control" id="inputPassword7" name="inputPassword7" required>
            </div>
            
            <?php if (!empty($mensagem)): ?> 
                <div class="alert alert-warning text-center"><?php echo $mensagem; ?></div> <!-- Exibe a mensagem -->
            <?php endif; ?>

            <div id="mensagem-erro" class="alert alert-warning text-center" style="display: none;">
                <!-- Mensagem de erro -->
            </div>

            <div class="d-grid">
                <input type="submit" class="btn btn-secondary" id="submitBtn" value="Finalizar Cadastro">
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    // Valida se as senhas são iguais
    function validarSenha() {
        const senha1 = document.getElementById("inputPassword6").value;
        const senha2 = document.getElementById("inputPassword7").value;
        const mensagemErro = document.getElementById("mensagem-erro");

        if (senha1 !== senha2) {
            mensagemErro.style.display = "block";
            mensagemErro.innerHTML = "As senhas não coincidem. Por favor, tente novamente.";
            return false; 
        }

        mensagemErro.style.display = "none";
        return true; 
    }

    document.getElementById('email').addEventListener('blur', function() {
        var email = this.value;
        var emailError = document.getElementById('emailError');
        var submitBtn = document.getElementById('submitBtn');

        if (email) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../verificaEmail.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        emailError.style.display = 'block';
                        emailError.innerText = 'Este e-mail já está em uso.';
                        submitBtn.disabled = true;
                    } else {
                        emailError.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email));
        } else {
            emailError.style.display = 'none';
            submitBtn.disabled = false; 
        }
    });
</script>
</body>
</html>
