<?php
require_once '../../startup/connectBD.php';

session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: ../../public/login.php');
    exit();
}

// if (!isset($_SESSION['email']) || ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master')) {
//     header('Location: ../../login.php');
//     exit();
// }

$sql_usuarios = "SELECT `id_usuario`, `nome_usuario`, `sobrenome_usuario`, `email_usuario`, `tel_usuario`, `senha_usuario`, `tipo_usuario` FROM `usuario`";
$result_usuarios = $mysqli->query($sql_usuarios);

$mensagem = ""; // Variável para armazenar a mensagem

if (isset($_GET['msg'])) {
    $mensagem = htmlspecialchars($_GET['msg']);
}

if (mysqli_num_rows($result_usuarios) > 0) {
    while ($usuario = mysqli_fetch_array($result_usuarios)) {
        $dados_usuarios[] = array(
            'id' => $usuario['id_usuario'],
            'nome' => $usuario['nome_usuario'],
            'sobrenome' => $usuario['sobrenome_usuario'],
            'email' => $usuario['email_usuario'],
            'telefone' => $usuario['tel_usuario'],
            'senha' => $usuario['senha_usuario'],
            'tipo' => $usuario['tipo_usuario']
        );
    }
} else {
    $mensagem = 'Nenhum registro de usuários encontrado.'; // Atribuindo a mensagem à variável
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de serviços</title>
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
        .alert {
            margin: 20px 0;
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
                        <a class="nav-link" href="">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../backBack/sair.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <p class="text-center">USUÁRIOS</p>
</header>
<main class="container">
    <div class="text-center add-button">
        <a href="../usuarioCadastro.php" class="btn btn-outline-secondary">Cadastrar Novo Usuário</a>
    </div>
    
    <?php if (!empty($mensagem)): ?> <!-- Verifica se a mensagem não está vazia -->
        <div class="alert alert-info text-center"><?php echo $mensagem; ?></div> <!-- Exibe a mensagem -->
    <?php endif; ?>

    <form action="../../backBack/delete/delete_usuario.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir os usuários selecionados?');">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" /></th>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Tipo de Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dados_usuarios)): ?> <!-- Verifica se existem dados de usuários -->
                    <?php foreach($dados_usuarios as $usuario): ?>
                        <tr>
                            <td><input type="checkbox" name="id_usuarios[]" value="<?php echo $usuario['id']; ?>" /></td>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['sobrenome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['tipo']); ?></td>
                            <td>
                                <a href="../edit/edit_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-success">Atualizar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Nenhum usuário disponível para exibir.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-danger">Excluir Selecionados</button>
    </form>
</main>

<script>
    document.getElementById('selectAll').onclick = function() {
        var checkboxes = document.getElementsByName('id_usuarios[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
