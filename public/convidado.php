<?php
require_once('../startup/connectBD.php');

if (isset($_GET['id'])) {
    $id_user = intval($_GET['id']); // Pode ser o ID do usuário ou uma string codificada

    // Consulta para obter os presentes do usuário
    $sql_presente = "SELECT `nome_presente`, `link_presente` FROM `lista_de_presentes` WHERE `usuario_id_usuario` = ?";
    $stmt = mysqli_prepare($mysqli, $sql_presente);
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    mysqli_stmt_execute($stmt);
    $result_presente = mysqli_stmt_get_result($stmt);

    $dados_presente = [];
    while ($paleta = mysqli_fetch_assoc($result_presente)) {
        $dados_presente[] = $paleta;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convidado</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        
    </style>
</head>
<body id="body-convidado">
    <script src="js/topoconvidado.js"></script>
    <!-- <nav class="nav-a">
        MEUS PRESENTES
    </nav> -->
    <main id="main- convidado"></main>
    <section class="presentes-container">
        <div class="presentes-content">
            <div id="div-imagem-convidado">
                <div id="div-marrom-convidado"></div>
                <img src="images/vestido8.jpg" alt="Presente com flores" class="presentes-imagem">
            </div>
            <div class="presentes-texto" id="presentes-texto">
                <h2 id="h2-convidado">Lista de presentes</h2>
                <p id="p-meuspresentes">Aqui você encontrará algumas sugestões de presentes que escolhemos com muito carinho para celebrar este momento especial. Fique à vontade para escolher o presente que desejar e, ao adquiri-lo, não se esqueça de confirmá-lo para que outros convidados saibam que já foi escolhido. Agradecemos de coração por compartilhar essa data tão importante conosco!</p>
            </div>
            
       
        </div>
        <div class="lista-presentes">
        <ul id="lista-presentes-ul" class="present-list">
            <?php if (!empty($dados_presente)): ?>
                <?php foreach ($dados_presente as $presente): ?>
                    <li class="present-item">
                    <div class="present-details">
                        <strong><?php echo htmlspecialchars($presente['nome_presente']); ?></strong>
                        <a href="<?php echo htmlspecialchars($presente['link_presente']); ?>" target="_blank" class="present-link">Ver Presente</a>
                </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Nenhum presente encontrado.</li>
            <?php endif; ?>
        </ul>
            </div>
        
    </section>
    <script src="js/footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
