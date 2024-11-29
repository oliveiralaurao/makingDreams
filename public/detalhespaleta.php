<?php
require_once '../startup/connectBD.php'; 

// Consulta para buscar as paletas de cores
$sql_paletas = "SELECT id_portfolio, nome_portfolio, desc_portfolio, image FROM innerportfolio WHERE nome_categoria = 'Paletas de Cores'";
$result_paletas = $mysqli->query($sql_paletas);

$dados_paletas = [];

if ($result_paletas && $result_paletas->num_rows > 0) {
    while ($paleta = $result_paletas->fetch_assoc()) {
        $dados_paletas[] = $paleta;
    }
} else {
    echo "Nenhuma paleta de cores encontrada.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes Paleta</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="body-detalhes-paleta">
    <script src="js/topo.js"></script>
    <button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>

    <section class="section-paleta">
        <section class="gallery-paleta">
            <h1 class="gallery-title">Paleta de cores</h1>
            <p class="descricao-secao-paleta">A paleta de cores é essencial para que haja harmonia na decoração.</p>

            <?php if (!empty($dados_paletas)): ?>
                <?php foreach ($dados_paletas as $index => $paleta): ?>
                    <?php if ($index % 3 == 0): // Início de uma nova linha a cada 3 itens ?>
                        <div class="gallery-row-paleta">
                    <?php endif; ?>
                    
                    <div class="paleta-item">
                    <a href="descricao.php?id=<?php echo $paleta['id_portfolio']; ?>&nome=paleta">

                        <img src="../backBack/upload/<?php echo $paleta['image']; ?>" 
                             alt="<?php echo htmlspecialchars($paleta['nome_portfolio']); ?>" class="gallery-image-paleta">
                        <p class="tipo-paleta"><?php echo htmlspecialchars($paleta['nome_portfolio']); ?></p>
                    </a>
                    </div>

                    <?php if ($index % 3 == 2 || $index == count($dados_paletas) - 1): // Fim da linha ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma paleta de cores encontrada.</p>
            <?php endif; ?>
        </section>
    </section>
</body>
</html>
