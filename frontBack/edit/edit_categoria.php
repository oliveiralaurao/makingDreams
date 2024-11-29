<?php
require_once('../../startup/connectBD.php');
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $query = "SELECT * FROM categoria WHERE id_categoria = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $category = $result->fetch_assoc();
        } else {
            echo 'Categoria não encontrada.';
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
    <title>Editar Categoria</title>
    <style>
        #main-edit {
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
        .form-edit {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
        }
        .form-edit h3 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 500;
        }
        .form-edit .btn {
            font-weight: 500;
        }
        .form-edit .form-label {
            font-weight: 600;
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
    <p class="text-center">EDIÇÃO DE CATEGORIAS</p>
</header>

<main id="main-edit">
    <div id="form-container">
        <form action="../../backBack/update/updateCategoria.php" method="post" class="form-edit">
            <h3>Editar Categoria</h3>

            <input type="hidden" name="id_categoria" value="<?php echo htmlspecialchars($category['id_categoria']); ?>">

            <div class="mb-3">
                <label for="nome_categoria" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" value="<?php echo htmlspecialchars($category['nome_categoria']); ?>" required>
            </div>
            <div id="categoriaError" class="text-danger mt-1" style="display: none;"></div>

            <div class="mb-3">
                <label for="desc_categoria" class="form-label">Descrição</label>
                <textarea class="form-control" id="desc_categoria" name="desc_categoria" rows="3" required><?php echo htmlspecialchars($category['desc_categoria']); ?></textarea>
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
        document.getElementById('nome_categoria').addEventListener('blur', function() {
        var categoria = this.value;
        var categoriaError = document.getElementById('categoriaError');
        var submitBtn = document.getElementById('submitBtn');

        if (categoria) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../verificaCategoria.php', true);
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
