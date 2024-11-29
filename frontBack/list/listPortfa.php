<?php
require_once '../../startup/connectBD.php';

session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}

$mensagem = "";

// Filtrar mensagem GET
if (isset($_GET['message'])) {
    $mensagem = htmlspecialchars($_GET['message']);
}

// Consultar categorias disponíveis
$sql_categories = "SELECT DISTINCT nome_categoria FROM innerportfolio";
$result_categories = $mysqli->query($sql_categories);

// Filtrar portfólios por categoria (se selecionada)
$selected_category = "";
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $selected_category = htmlspecialchars($_GET['categoria']);
    $sql_portfolios = "SELECT * FROM innerportfolio WHERE nome_categoria = ?";
    $stmt = $mysqli->prepare($sql_portfolios);
    $stmt->bind_param("s", $selected_category);
    $stmt->execute();
    $result_portfolios = $stmt->get_result();
} else {
    $sql_portfolios = "SELECT * FROM innerportfolio";
    $result_portfolios = $mysqli->query($sql_portfolios);
}

// Verificar se há resultados
if ($result_portfolios && mysqli_num_rows($result_portfolios) > 0) {
    while ($portfolio = mysqli_fetch_array($result_portfolios)) {
        $dados_portfolios[] = array(
            'id' => $portfolio['id_portfolio'],
            'nome' => $portfolio['nome_portfolio'],
            'descricao' => $portfolio['desc_portfolio'],
            'imagem' => $portfolio['image'],
            'categoria' => $portfolio['nome_categoria']
        );
    }
} else {
    $mensagem = 'Nenhum registro de portfólio encontrado.';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Portfólios</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        header {
            margin-bottom: 20px;
        }
        main {
            width: 100%;
            min-height: 500px;
            height: auto;

        }
        .table {
            margin-top: 20px;
            width: 100%;
            min-height: 100px;
            height: auto;
        }
        .add-button {
            margin-bottom: 20px;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" href="../../public/home.html">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listPortfa.php">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listCategoris.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listUser.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../backBack/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <p class="text-center">PORTFÓLIOS</p>
</header>
<main class="container">

    <!-- Filtro por Categoria -->
    <div class="container">
        <form method="GET" class="form-inline mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="categoria" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Filtrar por Categoria --</option>
                        <?php if ($result_categories && mysqli_num_rows($result_categories) > 0): ?>
                            <?php while ($category = mysqli_fetch_array($result_categories)): ?>
                                <option value="<?php echo htmlspecialchars($category['nome_categoria']); ?>" 
                                    <?php if ($selected_category == $category['nome_categoria']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($category['nome_categoria']); ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="text-center add-button">
        <a href="../portfolioCadastro.php" class="btn btn-outline-secondary">Cadastrar Novo Portfólio</a>
    </div>

    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-info text-center">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($dados_portfolios)): ?>
        <form action="../../backBack/delete/delete_portfolio.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir os portfólios selecionados?');">
            <div class="table-responsive"> <!-- Adicionado para responsividade -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Selecionar</th>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Imagem</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados_portfolios as $portfolio): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="id_portfolio[]" value="<?php echo htmlspecialchars($portfolio['id']); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($portfolio['id']); ?></td>
                                <td><?php echo htmlspecialchars($portfolio['nome']); ?></td>
                                <td><?php echo htmlspecialchars($portfolio['descricao']); ?></td>
                                <td>
                                    <?php if ($portfolio['imagem']): ?>
                                        <img src="../../backBack/upload/<?php echo htmlspecialchars($portfolio['imagem']); ?>" alt="Imagem" width="100">
                                    <?php else: ?>
                                        Sem Imagem
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($portfolio['categoria']); ?></td>
                                <td>
                                    <a href="../edit/edit_portfolio.php?id=<?php echo $portfolio['id']; ?>" class="btn btn-success">Atualizar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
        </form>
    <?php else: ?>
        <p class="text-center text-danger"><?php echo $mensagem; ?></p>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
