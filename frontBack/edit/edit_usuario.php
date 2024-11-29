<?php
require_once('../../startup/connectBD.php');
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Preparar a declaração
    $query = "SELECT * FROM usuario WHERE id_usuario = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
        } else {
            echo 'Usuário não encontrado.';
            exit();
        }

        $stmt->close();
    } else {
        echo 'Erro ao preparar a consulta.';
        exit();
    }
} else {
    echo 'ID inválido.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Editar Usuário</title>
    <style>
        #main-login, #main-edit {
            width: 100%;
            min-height: 500px;
            height: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #form-container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .form-login, .form-edit {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">
                <img src="../../images/Logo-removebg-preview.png" alt="Logo" height="70px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" href="../../public/home.html">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../list/listPortfa.php">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../list/listCategoris.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../list/listUser.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../backBack/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <p class="text-center">EDIÇÃO DE PORTFÓLIO</p>
</header>

<main id="main-edit">
    <div id="form-container">
        <form id="editForm" action="../../backBack/update/updateUser.php" method="post" class="form-edit">
            <h3>Editar Usuário</h3>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id_usuario']); ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user['nome_usuario']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="sobrenome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo htmlspecialchars($user['sobrenome_usuario']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['tel_usuario']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email_usuario']); ?>" required>
                <div id="emailError" class="text-danger mt-2" style="display:none;"></div>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" value="<?php echo htmlspecialchars($user['senha_usuario']); ?>" required style="display:none;">
                <button type="button" id="alterarSenhaBtn" class="btn btn-link">Alterar Senha</button>
            </div>


            <div class="mb-3">
                <label for="user_level" class="form-label">Nível de Acesso</label>
                <select class="form-select" id="user_level" name="user_level" required>
                    <option value="" disabled selected>Selecione o nível de acesso</option>
                    <option value="adm" <?php echo ($user['tipo_usuario'] == 'adm') ? 'selected' : ''; ?>>Admin</option>
                    <option value="usuario" <?php echo ($user['tipo_usuario'] == 'usuario') ? 'selected' : ''; ?>>Usuário</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-secondary" id="submitBtn">
                    Atualizar <i class="bi bi-check2-square"></i>
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
    document.getElementById('alterarSenhaBtn').addEventListener('click', function() {
        var senhaField = document.getElementById('senha');
        senhaField.style.display = 'block';  // Exibir o campo de senha
        this.style.display = 'none';         // Esconder o botão "Alterar Senha"
    });


    document.getElementById('email').addEventListener('blur', function() {
        var email = this.value;
        var emailError = document.getElementById('emailError');
        var submitBtn = document.getElementById('submitBtn');

        if (email) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../verificaEmail.php', true);
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
        }
    });
</script>
</body>
</html>
