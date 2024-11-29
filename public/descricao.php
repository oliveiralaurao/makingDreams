<?php
require_once '../startup/connectBD.php';
session_start();
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['pagina_anterior'] = $_SERVER['REQUEST_URI']; // Salva a URL atual
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['nome'])) {

    $id = intval($_GET['id']);
    $id_user = $_SESSION['id_usuario'] ?? null;

    $tipo = $_GET['nome'];

    if ($tipo == 'vestido') {
        $sql = "SELECT * FROM fotos WHERE id_portfolio = $id;";
    } elseif ($tipo == 'temas') {
        $sql = "SELECT * FROM fototema WHERE id_portfolio = $id;";
    } elseif ($tipo == 'paleta') {
        $sql = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `nome_categoria` FROM `innerportfolio` WHERE innerportfolio.nome_categoria = 'Paletas de Cores' AND id_portfolio = $id;";
    } elseif ($tipo == 'buques') {
        $sql = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `nome_categoria` FROM `innerportfolio` WHERE innerportfolio.nome_categoria = 'Buquês' AND id_portfolio = $id;";
    } else {
        $mensagem = 'Tipo de pesquisa desconhecido.';
        $vestido = null;
    }

    if (isset($sql)) {
        $result = $mysqli->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $vestido = mysqli_fetch_array($result);
        } else {
            $mensagem = 'Registro não encontrado.';
            $vestido = null;
        }
    }
} else {
    $mensagem = 'ID ou tipo de pesquisa não foi passado.';
    $vestido = null;
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'favorito_adicionado') {
        echo '<div class="alert alert-success">Adicionado aos favoritos com sucesso!</div>';
    } elseif ($_GET['msg'] == 'erro_adicionar_favorito') {
        echo '<div class="alert alert-danger">Ocorreu um erro ao adicionar aos favoritos.</div>';
    } elseif ($_GET['msg'] == 'parametros_invalidos') {
        echo '<div class="alert alert-warning">Parâmetros inválidos.</div>';
    }
}

$favorito_sql = "SELECT * FROM favoritos WHERE usuario_id_usuario = $id_user AND portfolio_id_portfolio = {$vestido['id_portfolio']};";
$favorito_result = $mysqli->query($favorito_sql);

$is_favorito = $favorito_result && mysqli_num_rows($favorito_result) > 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descrição do Vestido</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="body-descricao-vestido">
<script src="js/topo.js"></script>
<button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>

<div class="container-descricao">
    <?php if ($vestido): ?>
        <div class="imagem-vestido">
            <img src="../backBack/upload/<?php echo $vestido['image']; ?>" alt="<?php echo $vestido['nome_portfolio']; ?>">
        </div>
        <div class="texto-descricao">
            <h2 class="titulo-descricao"><?php echo $vestido['nome_portfolio']; ?></h2>
            <p class="paragrafo-descricao"><?php echo $vestido['desc_portfolio']; ?></p>
        </div>
    <?php else: ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>
</div>

<div class="favoritos-icon">
    <?php if ($id_user): ?>
        <button 
            class="btn-favorito" 
            title="Adicionar aos Favoritos" 
            onclick="toggleFavorito(<?php echo $id_user; ?>, <?php echo $vestido['id_portfolio']; ?>, this)"
        >
            <?php if ($is_favorito): ?>
                <i class="bi bi-heart-fill"></i>
            <?php else: ?>
                <span class="material-symbols-outlined">favorite</span>
            <?php endif; ?>
        </button>
    <?php else: ?>
        <p>Faça <a href="login.php">login</a> para adicionar aos favoritos.</p>
    <?php endif; ?>
</div>
<script>
    function toggleFavorito(userId, portfolioId, button) {
    const formData = new FormData();
    formData.append('usuario_id', userId);
    formData.append('portfolio_id', portfolioId);

    fetch('../backBack/cadastro/favorito.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(data => {
        const icon = button.querySelector('i, span');
        if (data.trim() === 'added') {
            // Atualiza para "favoritado"
            icon.classList.replace('material-symbols-outlined', 'bi-heart-fill');
            icon.textContent = ''; // ícone de favorito preenchido
        } else if (data.trim() === 'removed') {
            // Atualiza para "não favoritado"
            icon.classList.replace('bi-heart-fill', 'material-symbols-outlined');
            icon.textContent = 'favorite'; // ícone de não favorito
        } else {
            alert('Erro ao processar sua solicitação.');
        }
    })
    .catch(error => console.error('Erro:', error));
}


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/footer.js"></script>
</body>
</html>
