<?php
require_once '../startup/connectBD.php'; 

// Consulta para Vestidos de Noiva
$sql_vestidos = "SELECT * FROM fotos WHERE nome_categoria = 'Vestidos de Noiva';";
$result_vestidos = $mysqli->query($sql_vestidos);
$dados_vestidos = [];

if ($result_vestidos && mysqli_num_rows($result_vestidos) > 0) {
    while ($vestido = mysqli_fetch_array($result_vestidos)) {
        $dados_vestidos[] = array(
            'id_portfolio' => $vestido['id_portfolio'],
            'nomeP' => $vestido['nome_portfolio'],
            'descricao' => $vestido['desc_portfolio'],
            'image' => $vestido['image'],
            'categoria' => $vestido['categoria_id_categoria'],
            'nome' => $vestido['nome_categoria'],
            'desc' => $vestido['desc_categoria']
        );
    }
} else {
    $mensagem_vestidos = 'Nenhum vestido encontrado.';
}

// Consulta para Ternos de Noivo
$sql_ternos = "SELECT * FROM fotos WHERE nome_categoria = 'Ternos para Noivo';";
$result_ternos = $mysqli->query($sql_ternos);
$dados_ternos = [];

if ($result_ternos && mysqli_num_rows($result_ternos) > 0) {
    while ($terno = mysqli_fetch_array($result_ternos)) {
        $dados_ternos[] = array(
            'id_portfolio' => $terno['id_portfolio'],
            'nomeP' => $terno['nome_portfolio'],
            'descricao' => $terno['desc_portfolio'],
            'image' => $terno['image'],
            'categoria' => $terno['categoria_id_categoria'],
            'nome' => $terno['nome_categoria'],
            'desc' => $terno['desc_categoria']
        );
    }
} else {
    $mensagem_ternos = 'Nenhum terno encontrado.';
}

// Consulta para Madrinhas e Padrinhos
$sql_madrinhas = "SELECT * FROM fotos WHERE nome_categoria IN ('Roupas para Madrinhas', 'Roupas para Padrinhos');";
$result_madrinhas = $mysqli->query($sql_madrinhas);
$dados_madrinhas = [];

if ($result_madrinhas && mysqli_num_rows($result_madrinhas) > 0) {
    while ($madrinha = mysqli_fetch_array($result_madrinhas)) {
        $dados_madrinhas[] = array(
            'id_portfolio' => $madrinha['id_portfolio'],
            'nomeP' => $madrinha['nome_portfolio'],
            'descricao' => $madrinha['desc_portfolio'],
            'image' => $madrinha['image'],
            'categoria' => $madrinha['categoria_id_categoria'],
            'nome' => $madrinha['nome_categoria'],
            'desc' => $madrinha['desc_categoria']
        );
    }
} else {
    $mensagem_madrinhas = 'Nenhum traje de madrinha ou padrinho encontrado.';
}

// Consulta para Daminhas
$sql_daminhas = "SELECT * FROM fotos WHERE nome_categoria = 'Daminhas de Honra';";
$result_daminhas = $mysqli->query($sql_daminhas);
$dados_daminhas = [];

if ($result_daminhas && mysqli_num_rows($result_daminhas) > 0) {
    while ($daminha = mysqli_fetch_array($result_daminhas)) {
        $dados_daminhas[] = array(
            'id_portfolio' => $daminha['id_portfolio'],
            'nomeP' => $daminha['nome_portfolio'],
            'descricao' => $daminha['desc_portfolio'],
            'image' => $daminha['image'],
            'categoria' => $daminha['categoria_id_categoria'],
            'nome' => $daminha['nome_categoria'],
            'desc' => $daminha['desc_categoria']
        );
    }
} else {
    $mensagem_daminhas = 'Nenhum traje de daminha encontrado.';
}

// Consulta para Pajens
$sql_pajens = "SELECT * FROM fotos WHERE nome_categoria = 'Pajens';";
$result_pajens = $mysqli->query($sql_pajens);
$dados_pajens = [];

if ($result_pajens && mysqli_num_rows($result_pajens) > 0) {
    while ($pajen = mysqli_fetch_array($result_pajens)) {
        $dados_pajens[] = array(
            'id_portfolio' => $pajen['id_portfolio'],
            'nomeP' => $pajen['nome_portfolio'],
            'descricao' => $pajen['desc_portfolio'],
            'image' => $pajen['image'],
            'categoria' => $pajen['categoria_id_categoria'],
            'nome' => $pajen['nome_categoria'],
            'desc' => $pajen['desc_categoria']
        );
    }
} else {
    $mensagem_pajens = 'Nenhum traje de pajem encontrado.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes temas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<script>
    
</script>
    <script src="js/topo.js"></script>
<body class="body-detalhes-roupas">
<button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>

    <section class="section-roupas">
        <!-- Vestidos de Noiva -->
        <section class="gallery-roupas">
            <h1 class="gallery-title">Vestido de Noiva</h1>
            <p class="descricao-secao-roupas">O vestido de noiva é a peça central de qualquer casamento, projetado para refletir a personalidade e o estilo da noiva.</p>
            <div class="gallery-row-roupas">
                <?php
                if (!empty($dados_vestidos)) {
                    $counter = 0;
                    foreach ($dados_vestidos as $vestido) {
                        if ($counter > 0 && $counter % 3 == 0) {
                            echo '</div><div class="gallery-row-roupas">';
                        }
                        ?>
                        <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $vestido['id_portfolio']; ?>&nome=vestido">
                                <img src="../backBack/upload/<?php echo $vestido['image']; ?>" alt="<?php echo $vestido['nomeP']; ?>" class="gallery-image-roupas">
                                <p class="tipo-roupa"><?php echo $vestido['nomeP']; ?></p>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    }
                } else {
                    echo '<p>Nenhum vestido encontrado.</p>';
                }
                ?>
            </div>
        </section>

        <br>
        <br>

        <!-- Ternos de Noivo -->
        <section class="gallery-roupas">
            <h1 class="gallery-title">Terno de Noivo</h1>
            <p class="descricao-secao-roupas">O terno do noivo é uma escolha essencial para dar uma presença marcante no grande dia.</p>
            <div class="gallery-row-roupas">
                <?php
                if (!empty($dados_ternos)) {
                    $counter = 0;
                    foreach ($dados_ternos as $terno) {
                        if ($counter > 0 && $counter % 3 == 0) {
                            echo '</div><div class="gallery-row-roupas">';
                        }
                        ?>
                        <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $terno['id_portfolio']; ?>&nome=vestido">
                                <img src="../backBack/upload/<?php echo $terno['image']; ?>" alt="<?php echo $terno['nomeP']; ?>" class="gallery-image-roupas">
                                <p class="tipo-roupa"><?php echo $terno['nomeP']; ?></p>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    }
                } else {
                    echo '<p>Nenhum terno encontrado.</p>';
                }
                ?>
            </div>
        </section>

        <br>
        <br>

        <!-- Madrinhas e Padrinhos -->
        <section class="gallery-roupas">
            <h1 class="gallery-title">Madrinha e Padrinho</h1>
            <p class="descricao-secao-roupas">O traje de madrinhas e padrinhos são escolhas essenciais para criar um visual elegante e harmônico que complemente o terno do casal.</p>
            <div class="gallery-row-roupas">
                <?php
                if (!empty($dados_madrinhas)) {
                    $counter = 0;
                    foreach ($dados_madrinhas as $madrinha) {
                        if ($counter > 0 && $counter % 3 == 0) {
                            echo '</div><div class="gallery-row-roupas">';
                        }
                        ?>
                        <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $madrinha['id_portfolio']; ?>&nome=vestido">
                                <img src="../backBack/upload/<?php echo $madrinha['image']; ?>" alt="<?php echo $madrinha['nomeP']; ?>" class="gallery-image-roupas">
                                <p class="tipo-roupa"><?php echo $madrinha['nomeP']; ?></p>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    }
                } else {
                    echo '<p>Nenhum traje de madrinha ou padrinho encontrado.</p>';
                }
                ?>
            </div>
        </section>

        <br>
        <br>

        <!-- Daminhas -->
        <section class="gallery-roupas">
            <h1 class="gallery-title">Daminhas</h1>
            <p class="descricao-secao-roupas">As daminhas trazem encanto e graça ao casamento, com trajes que complementam o estilo do evento.</p>
            <div class="gallery-row-roupas">
                <?php
                if (!empty($dados_daminhas)) {
                    $counter = 0;
                    foreach ($dados_daminhas as $daminha) {
                        if ($counter > 0 && $counter % 3 == 0) {
                            echo '</div><div class="gallery-row-roupas">';
                        }
                        ?>
                        <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $daminha['id_portfolio']; ?>&nome=vestido">
                                <img src="../backBack/upload/<?php echo $daminha['image']; ?>" alt="<?php echo $daminha['nomeP']; ?>" class="gallery-image-roupas">
                                <p class="tipo-roupa"><?php echo $daminha['nomeP']; ?></p>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    }
                } else {
                    echo '<p>Nenhum traje de daminha encontrado.</p>';
                }
                ?>
            </div>
        </section>

        <br>
        <br>

        <!-- Pajens -->
        <section class="gallery-roupas">
            <h1 class="gallery-title">Pajens</h1>
            <p class="descricao-secao-roupas">Os pajens têm um papel especial, com trajes que refletem a formalidade do casamento e a alegria da ocasião.</p>
            <div class="gallery-row-roupas">
                <?php
                if (!empty($dados_pajens)) {
                    $counter = 0;
                    foreach ($dados_pajens as $pajen) {
                        if ($counter > 0 && $counter % 3 == 0) {
                            echo '</div><div class="gallery-row-roupas">';
                        }
                        ?>
                        <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $pajen['id_portfolio']; ?>&nome=vestido">
                                <img src="../backBack/upload/<?php echo $pajen['image']; ?>" alt="<?php echo $pajen['nomeP']; ?>" class="gallery-image-roupas">
                                <p class="tipo-roupa"><?php echo $pajen['nomeP']; ?></p>
                            </a>
                        </div>
                        <?php
                        $counter++;
                    }
                } else {
                    echo '<p>Nenhum traje de pajem encontrado.</p>';
                }
                ?>
            </div>
        </section>
    </section>
    <script src="js/footer.js"></script>
</body>

</html>
