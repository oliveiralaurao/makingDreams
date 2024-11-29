
<?php include '../backBack/conexaoFront/consultas.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Completo</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
    
    </style>
</head>
<body>
<script src="./js/topo.js"></script>
<main id="main-portfolio">
  <div class="slider">
 
 
    <div class="list">
 
        <div class="item">
          <img src="./images/banner.png" alt="">
 
            <div class="content">
                <div class="title">EXPLORE NOSSOS   </div>
                <div class="type">PORTFÓLIOS</div>
                <div class="description">
                    Explore uma coleção encantadora de roupas, incluindo vestidos de noiva, madrinhas, padrinhos e daminhas, que exalam elegância e estilo. Inspire-se com ideias criativas de decoração que transformarão seu evento em uma celebração única. Descubra paletas de cores harmoniosas para realçar cada detalhe e encante-se com buquês florais que refletem sua personalidade. Cada categoria é cuidadosamente curada para ajudar a tornar seus sonhos uma realidade.                </div>
            </div>
        </div>
 
        <div class="item">
          <img src="./images/DSC_2896.jpg" alt="">
 
            <div class="content">
                <div class="title">REALIZANDO</div>
                <div class="type">SONHOS</div>
                <div class="description">
                    Cada casamento que planejamos é uma história de amor que ganha vida. Combinamos criatividade e expertise para criar celebrações memoráveis, repletas de detalhes únicos e personalizados. Explore nosso portfólio e veja como podemos transformar seus sonhos em uma experiência inesquecível.                </div>
            </div>
        </div>
 
        <div class="item">
          <img src="./images/DSC_2795.jpg" alt="">
 
            <div class="content">
                <BR></BR>
                <div class="title">HISTÓRIAS</div>
                <div class="type">MEMORÁVEIS</div>
                <div class="description">
                    Acreditamos que cada casamento deve contar uma história, e nosso compromisso é fazer com que a sua seja contada da forma mais autêntica e emocionante possível. Combinamos estilo, elegância e inovação para criar momentos inesquecíveis que refletem sua personalidade e valores.                </div>
            </div>
        </div>
 
        <div class="item">
            <img src="./images/DSC_2836.jpg" alt="">
 
            <div class="content">
                <div class="title">ESTILO</div>
                <div class="type">ÚNICO</div>
                <div class="description">
                    Do conceito à execução, cada etapa do planejamento é cuidadosamente pensada para refletir a essência de cada casal. Nossa equipe se dedica a criar ambientes encantadores e experiências que vão além do esperado. Descubra como nossos projetos unem sofisticação e originalidade em cada detalhe.                </div>
            </div>
        </div>
    </div>
    <div class="thumbnail">
        <div class="item">
            <img src="./images/imagem.jfif" alt="">
        </div>
        <div class="item">
            <img src="./images/DSC_2780.jpg" alt="">
        </div>
        <div class="item">
            <img src="./images/DSC_2901.jpg" alt="">
        </div>
        <div class="item">
            <img src="./images/DSC_2807.jpg" alt="">
        </div>
    </div>
    
</div>
    </section>

    <section class="gallery">
        <a href="detalhesroupas.php">
            <h2 class="gallery-title">Galeria de Roupas <i class="bi bi-box-arrow-in-up-right" style="font-size: 18px;"></i></h2>
        </a>
        <div class="gallery-row">
            <?php if (!empty($dados_galeria)): ?>
                <?php foreach($dados_galeria as $dados): ?>
                    <a href="descricao.php?id=<?php echo $dados['id_portfolio']; ?>&nome=vestido">

                    <img src="../backBack/upload/<?php echo htmlspecialchars($dados['image']); ?>" alt="<?php echo htmlspecialchars($dados['nomeP']); ?>" class="gallery-image">
                </a>
                    <?php endforeach; ?>
            <?php else: ?>
                <p><?php echo $mensagem_galeria; ?></p>
            <?php endif; ?>
        </div>
    </section>

<section class="themes">
        <a href="detalhestemas.php">
            <h2 class="themes-title">Temas e inspirações de decoração <i class="bi bi-box-arrow-in-up-right" style="font-size: 18px;"></i></h2>
        </a>    <div class="themes-row">
        <?php if (!empty($dados_temas)): ?>
            <?php foreach($dados_temas as $tema): ?>
                <a href="descricao.php?id=<?php echo $tema['id_portfolio']; ?>&nome=temas">

                <img src="../backBack/upload/<?php echo htmlspecialchars($tema['image']); ?>" alt="<?php echo htmlspecialchars($tema['nomeP']); ?>" class="themes-image">
            </a>
                <?php endforeach; ?>
        <?php else: ?>
            <p><?php echo $mensagem_temas; ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="palette">
    <a href="detalhespaleta.php">
        <h2 class="palette-title">Paleta de Cores <i class="bi bi-box-arrow-in-up-right" style="font-size: 18px;"></i></h2>
    </a>
    <div class="palette-row">
        <?php if (!empty($dados_paletas)): ?>
            <?php foreach($dados_paletas as $paleta): ?>
                <a href="descricao.php?id=<?php echo $paleta['id_portfolio']; ?>&nome=paleta">

                <img src="../backBack/upload/<?php echo htmlspecialchars($paleta['image']); ?>" alt="<?php echo htmlspecialchars($paleta['nomeP']); ?>" class="palette-image">
            </a>
                <?php endforeach; ?>
        <?php else: ?>
            <p><?php echo $mensagem_paletas; ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="buques">
    <a href="detalhesbuques.php">
        <h2 class="buques-title">Buquês <i class="bi bi-box-arrow-in-up-right" style="font-size: 18px;"></i></h2>
    </a>
    <div class="buques-row">
        <?php if (!empty($dados_buques)): ?>
            <?php foreach($dados_buques as $buque): ?>
                <a href="descricao.php?id=<?php echo $buque['id_portfolio']; ?>&nome=buques">

                <img src="../backBack/upload/<?php echo htmlspecialchars($buque['image']); ?>" alt="<?php echo htmlspecialchars($buque['nomeP']); ?>" class="buques-image">
            </a>
                <?php endforeach; ?>
        <?php else: ?>
            <p><?php echo $mensagem_buques; ?></p>
        <?php endif; ?>
    </div>
</section>
</main>
<script src="js/script.js"></script>
<script src="js/footer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

