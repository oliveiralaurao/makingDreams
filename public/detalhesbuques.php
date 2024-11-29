<?php
require_once '../startup/connectBD.php'; 

// Consulta para buscar os buquês
$sql_buques = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `categoria_id_categoria` FROM `portfolio` WHERE categoria_id_categoria = 19;";
$result_buques = $mysqli->query($sql_buques);

$dados_buques = [];

if ($result_buques && $result_buques->num_rows > 0) {
    while ($buque = $result_buques->fetch_assoc()) {
        $dados_buques[] = $buque;
    }
} else {
    echo "Nenhum buquê encontrado.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Buquês</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="body-detalhes-buques">
    <script src="js/topo.js"></script>
    <button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>

    <section class="section-buques">
        <section class="gallery-buques">
            <h1 class="gallery-title">Buquês</h1>
            <p class="descricao-secao-buques">
                Buquê é uma palavra de origem Francesa e trata-se de um arranjo de flores usado pela noiva no dia do casamento. 
                A ideia principal do buquê de noiva é simbolizar a vida, indicando fertilidade.
            </p>

            <?php if (!empty($dados_buques)): ?>
                <?php foreach ($dados_buques as $index => $buque): ?>
                    <?php if ($index % 3 == 0): // Início de uma nova linha a cada 3 itens ?>
                        <div class="gallery-row-buques">
                    <?php endif; ?>
                    
                    <div class="buques-item">
                    <a href="descricao.php?id=<?php echo $buque['id_portfolio']; ?>&nome=buques">

                        <img src="../backBack/upload/<?php echo strtolower(str_replace(' ', '_', $buque['image'])); ?>" 
                             alt="<?php echo htmlspecialchars($buque['nome_portfolio']); ?>" class="gallery-image-buques">
                        <p class="tipo-buques"><?php echo htmlspecialchars($buque['nome_portfolio']); ?></p>
                    </a>
                    </div>

                    <?php if ($index % 3 == 2 || $index == count($dados_buques) - 1): // Fim da linha ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum buquê encontrado.</p>
            <?php endif; ?>
        </section>
    </section>
</body>
</html>
