<?php
require_once('../startup/connectBD.php');

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id_usuario'];
$sql = "SELECT nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, rede_social_usuario, hobbie_usuario, desc_usuario, foto_usuario FROM usuario WHERE id_usuario = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Consulta para os vestidos favoritos
$sql_vestidos = "
    SELECT 
    p.id_portfolio, 
    p.nome_portfolio, 
    p.image, 
    c.id_categoria, 
    c.nome_categoria
    FROM favoritos f
    JOIN portfolio p ON f.portfolio_id_portfolio = p.id_portfolio
    JOIN categoria c ON p.categoria_id_categoria = c.id_categoria
    WHERE f.usuario_id_usuario = ?;";
$stmt_vestidos = mysqli_prepare($mysqli, $sql_vestidos);
mysqli_stmt_bind_param($stmt_vestidos, 'i', $user_id);
mysqli_stmt_execute($stmt_vestidos);
$result_vestidos = mysqli_stmt_get_result($stmt_vestidos);

$vestidos_favoritos = [];
while ($row = mysqli_fetch_assoc($result_vestidos)) {
    $vestidos_favoritos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
#editarperfil {
    margin: 5px;
    color: #fff;
    transition: transform 0.3s ease; /* Transição suave */
}

#editarperfil:hover {
    transform: scale(1.1); /* Aumenta 10% quando o mouse passa por cima */
}
.themes-title{
    font-size: 20px;
    position: relative;
    top: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}
    </style>
</head>
<body id="perfil">
    <script src="js/topo.js"></script>
    
    <main id="mainperfil">
        <section id="principalperfil">
            <div id="nomePerfil">
                <!-- Exibe a foto de perfil -->
                <div id="fotoPerfil">
                    <?php if ($user['foto_usuario']): ?>
                        <img src="../backBack/upload/<?php echo htmlspecialchars($user['foto_usuario']); ?>" id="ftperfil" alt="Foto de Perfil" width="100%">
                    <?php else: ?>
                        <img src="images/perfil.png" id="ftperfil" alt="Foto de Perfil Padrão" width="100%">
                    <?php endif; ?>
                </div>

                <!-- Exibe o nome completo do usuário -->
                <div id="namePerfil">
                    <?php echo htmlspecialchars($user['nome_usuario']) . ' ' . htmlspecialchars($user['sobrenome_usuario']); ?>
                    <a href="#" data-bs-toggle="modal" id="editarperfil" data-bs-target="#updateModal">
    <span class="material-symbols-outlined">edit</span>
</a>
                    </div>
            </div>
                <p class="themes-title">Meus Favoritos</p>

            <div class="favs"><div class="img-fav">
            <?php if (!empty($vestidos_favoritos)): ?>
    <?php foreach ($vestidos_favoritos as $vestido): ?>
        <?php 
            // Verifica a categoria e define o valor do parâmetro 'nome'
            $nome_categoria = $vestido['nome_categoria'];
            $nome_param = ''; // Inicializa a variável

            if ($nome_categoria == 'Vestidos de Noiva') {
                $nome_param = 'vestido';
            }elseif($nome_categoria == 'Buquês'){
                $nome_param = 'buques';
            }elseif($nome_categoria == 'Decoração'){
                $nome_param = 'temas';
            } elseif ($nome_categoria == 'Paletas de Cores') {
                $nome_param = 'paleta';
            }
        ?>
        <div class="box-fav">
            <img src="../backBack/upload/<?php echo htmlspecialchars($vestido['image']); ?>" alt="<?php echo htmlspecialchars($vestido['nome_portfolio']); ?>">
            <div class="buttons-fav">
                <button class="btn-fav">
                    <a id="a-fav" href="descricao.php?id=<?php echo $vestido['id_portfolio']; ?>&nome=<?php echo $nome_param; ?>">
                        DETALHES
                    </a>
                </button>
                <form action="../backBack/delete/delete_favorito.php" method="POST">
                    <input type="hidden" name="portfolio_id" value="<?php echo htmlspecialchars($vestido['id_portfolio']); ?>">
                    <button type="submit" class="btn-remover">REMOVER</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhum vestido salvo como favorito.</p>
<?php endif; ?>
</div>
            </div>
        </section>
    </main>
                    <!-- Modal de atualização de perfil -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../backBack/update/updateUsuario.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Atualizar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campos de atualização -->
                    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($user_id); ?>">
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo htmlspecialchars($user['nome_usuario']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sobrenome" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" name="sobrenome" value="<?php echo htmlspecialchars($user['sobrenome_usuario']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email_usuario']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" name="telefone" value="<?php echo htmlspecialchars($user['tel_usuario']); ?>">
                    </div>
                    <!-- <div class="mb-3">
                        <label for="rede_social" class="form-label">Rede Social</label>
                        <input type="text" class="form-control" name="rede_social" value="<?php echo htmlspecialchars($user['rede_social_usuario']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="hobbie" class="form-label">Hobbie</label>
                        <input type="text" class="form-control" name="hobbie" value="<?php echo htmlspecialchars($user['hobbie_usuario']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao"><?php echo htmlspecialchars($user['desc_usuario']); ?></textarea>
                    </div> -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto de Perfil</label>
                        <input type="file" class="form-control" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/footer.js"></script>
</body>
</html>
