<?php
require_once('../../startup/connectBD.php');
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $query = "SELECT * FROM portfolio WHERE id_portfolio = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $portfolio = $result->fetch_assoc();
        } else {
            echo 'Portfólio não encontrado.';
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

$sql_categorias = "SELECT `id_categoria`, `nome_categoria` FROM `categoria`";
$result_categorias = $mysqli->query($sql_categorias);

if ($result_categorias && mysqli_num_rows($result_categorias) > 0) {
    while ($categoria = mysqli_fetch_array($result_categorias)) {
        $dados_categorias[] = array(
            'id' => $categoria['id_categoria'],
            'nome' => $categoria['nome_categoria']
        );
    }
} else {
    $dados_categorias = []; // Garante que a variável existe
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
    <title>Editar Portfólio</title>
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
    <p class="text-center">EDIÇÃO DE PORTFÓLIO</p>
</header>

<main id="main-edit">
    <div id="form-container">
        <form action="../../backBack/update/updatePortfolio.php" method="post" enctype="multipart/form-data" class="form-edit">
            <h3>Editar Portfólio</h3>

            <input type="hidden" name="id_portfolio" value="<?php echo htmlspecialchars($portfolio['id_portfolio']); ?>">

            <div class="mb-3">
                <label for="nome_portfolio" class="form-label">Nome do Portfólio</label>
                <input type="text" class="form-control" id="nome_portfolio" name="nome_portfolio" value="<?php echo htmlspecialchars($portfolio['nome_portfolio']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="desc_portfolio" class="form-label">Descrição</label>
                <textarea class="form-control" id="desc_portfolio" name="desc_portfolio" rows="3" required><?php echo htmlspecialchars($portfolio['desc_portfolio']); ?></textarea>
            </div>

            

            <div class="mb-3">
                <label for="categoria_id_categoria" class="form-label">Categoria</label>
                <select class="form-control" id="categoria_id_categoria" name="categoria_id_categoria" required>
                    <?php foreach ($dados_categorias as $categoria): ?>
                        <option value="<?php echo htmlspecialchars($categoria['id']); ?>" <?php echo $categoria['id'] == $portfolio['categoria_id_categoria'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Imagem Atual</label>
                <?php if ($portfolio['image']): ?>
                    <img src="../../backBack/upload/<?php echo htmlspecialchars($portfolio['image']); ?>" alt="Imagem do Portfólio" width="150">
                <?php else: ?>
                    <p>Sem imagem disponível.</p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="new_image" class="form-label">Atualizar Imagem</label>
                <input type="file" class="form-control" id="new_image" name="new_image">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-secondary">
                    Atualizar <i class="bi bi-check2-square"></i>
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

      