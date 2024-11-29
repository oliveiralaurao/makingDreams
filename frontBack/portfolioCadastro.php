<?php
require_once('../startup/connectBD.php');
include('../backBack/cadastro/portfolio.php');

session_start();

if (!isset($_SESSION['email']) || (!($_SESSION['tipo_usuario'] === 'adm' || $_SESSION['tipo_usuario'] === 'dev'))) {
    header('Location: ../public/login.php');
    exit();
}

$sql_categorias = "SELECT `id_categoria`, `nome_categoria`, `desc_categoria` FROM `categoria`";
$result_categorias = $mysqli->query($sql_categorias);

if ($result_categorias && mysqli_num_rows($result_categorias) > 0) {
    while ($categoria = mysqli_fetch_array($result_categorias)) {
        $dados_categorias[] = array(
            'id' => $categoria['id_categoria'],
            'nome' => $categoria['nome_categoria'],
            'descricao' => $categoria['desc_categoria']
        );
    }
} else {
    $mensagem = 'Nenhum registro de categorias encontrado.';
}

if (isset($_POST['nome_portfolio'], $_POST['desc_portfolio'], $_FILES['image'], $_POST['categoria_id_categoria'])) {
    cadastra_portfolio($mysqli, $_POST['nome_portfolio'], $_POST['desc_portfolio'], $_FILES['image'], $_POST['categoria_id_categoria']);
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
    <title>Cadastro de Portfólio</title>
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
    <p class="text-center">CADASTRO DE PORTFÓLIOS</p>
</header>

<main id="main-login">
    <div id="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="form-login">
            <h3>Novo Portfólio</h3>

            <div class="mb-3">
                <label for="nome_portfolio" class="form-label">Nome do Portfólio</label>
                <input type="text" class="form-control" id="nome_portfolio" name="nome_portfolio" required>
            </div>

            <div class="mb-3">
                <label for="desc_portfolio" class="form-label">Descrição</label>
                <textarea class="form-control" id="desc_portfolio" name="desc_portfolio" rows="3" required></textarea>
            </div>

            

            <div class="mb-3">
                <label for="image" class="form-label">Imagem do Portfólio</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <div class="mb-3">
                <label for="categoria_id_categoria" class="form-label">Categoria</label>
                <select class="form-control" id="categoria_id_categoria" name="categoria_id_categoria" required>
                    <?php if (!empty($dados_categorias)): ?>
                        <?php foreach ($dados_categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                <?php echo htmlspecialchars($categoria['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Nenhuma categoria encontrada</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-secondary">
                    Finalizar Cadastro <i class="bi bi-check2-square"></i>
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+967JBw1Pj0I3GkF7h7o7AOvwf0bo" crossorigin="anonymous"></script>
</body>
</html>
