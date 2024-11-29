<?php
require_once '../../startup/connectBD.php';
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}

$mensagem = "";
$dados_categorias = []; // Inicialize o array

if (isset($_GET['msg'])) {
    $mensagem = htmlspecialchars($_GET['msg']);
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    <p class="text-center">CATEGORIAS</p>
</header>
<main class="container">
    <div class="text-center add-button">
        <a href="../categoriaCadastro.php" class="btn btn-outline-secondary">Cadastrar Nova Categoria</a>
    </div>
    <div class="text">
    <?php if (!empty($mensagem)) { echo '<p class="alert alert-info text-center">' . $mensagem . '</p>'; } ?>
</div>
    <?php if (!empty($dados_categorias)): ?>
        <form action="../../backBack/delete/delete_categoria.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir as categorias selecionadas?');">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados_categorias as $categoria): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="id_categoria[]" value="<?php echo htmlspecialchars($categoria['id']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['nome']); ?></td>
                            <td><?php echo htmlspecialchars($categoria['descricao']); ?></td>
                            <td>
                                <a href="../edit/edit_categoria.php?id=<?php echo $categoria['id']; ?>" class="btn btn-success">Atualizar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            

            <button type="submit" class="btn btn-danger">Excluir Selecionadas</button>
        </form>
    <?php else: ?>
        <p class="text-center text-danger"><?php echo $mensagem; ?></p>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.querySelectorAll('input[name="id_categoria[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
</body>
</html>
