<?php
require_once '../startup/connectBD.php'; 

// Fetch categories for each section
$categories = ['Decoração', 'Estilos', 'Bolo', 'Lembrancinhas'];
$dados_temas = [];

foreach ($categories as $category) {
    $sql_temas = "SELECT id_categoria, nome_categoria, desc_categoria FROM temas WHERE nome_categoria = '$category';";
    $result_temas = $mysqli->query($sql_temas);

    if ($result_temas && mysqli_num_rows($result_temas) > 0) {
        while ($tema = mysqli_fetch_array($result_temas)) {
            $dados_temas[$category][] = array(
                'id' => $tema['id_categoria'],
                'nome' => $tema['nome_categoria'],
                'desc' => $tema['desc_categoria']
            );
        }
    } else {
        $dados_temas[$category] = 'Nenhum tema encontrado.';
    }
}

$categoriesimages = ['26', '30', '31', '36'];
$dados_image = [];

foreach ($categoriesimages as $category_id) {
    $sql_temas = "SELECT id_portfolio, image, nome_portfolio FROM portfolio WHERE categoria_id_categoria = '$category_id';";
    $result_temas = $mysqli->query($sql_temas);

    if ($result_temas && mysqli_num_rows($result_temas) > 0) {
        while ($foto = mysqli_fetch_array($result_temas)) {
            $dados_image[$category_id][] = array(
                'id' => $foto['id_portfolio'],
                'nome' => $foto['nome_portfolio'],
                'image' => $foto['image']
            );
        }
    } else {
        $dados_image[$category_id] = 'Nenhuma foto encontrada.';
    }
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

<body class="body-detalhes-temas">
    <script src="js/topo.js"></script>
    <button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>

    <?php foreach ($categories as $index => $category): ?>
        <section class="section-temas">
            <section class="gallery-temas">
                <h1 class="gallery-title"><?php echo $category; ?></h1>
                <p class="descricao-secao-temas"><?php 
                    if (!empty($dados_temas[$category]) && is_array($dados_temas[$category])) {
                        echo $dados_temas[$category][0]['desc']; 
                    } else {
                        echo 'Nenhuma descrição disponível.';
                    }
                ?></p>
                <div class="gallery-row-temas">
                    <?php
                    if (isset($categoriesimages[$index]) && !empty($dados_image[$categoriesimages[$index]]) && is_array($dados_image[$categoriesimages[$index]])) {
                        foreach ($dados_image[$categoriesimages[$index]] as $foto) {
                            ?>
                            <div class="roupa-item">
                            <a href="descricao.php?id=<?php echo $foto['id']; ?>&nome=temas">
                                <img src="../backBack/upload/<?php echo strtolower(str_replace(' ', '_', $foto['image'])); ?>" 
                                    alt="<?php echo $foto['nome']; ?>" class="gallery-image-temas">
                                <p class="tipo-temas"><?php echo $foto['nome']; ?></p>
                        </a>
                            </div>

                            <?php
                        }
                    } else {
                        echo '<p>' . (is_array($dados_image[$categoriesimages[$index]]) ? 'Nenhuma foto encontrada.' : $dados_image[$categoriesimages[$index]]) . '</p>';
                    }
                    ?>
                </div>
            </section>
        </section>
    <?php endforeach; ?>
</body>
</html>
