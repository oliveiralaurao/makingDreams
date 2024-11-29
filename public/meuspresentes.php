<?php

require_once('../startup/connectBD.php');
include('../backBack/cadastro/presente.php');

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
} else {
    $id_user = $_SESSION['id_usuario'];

    // Corrigindo a query SQL para incluir o ID do usuário
    $sql_presente = "SELECT `id_presente`, `nome_presente`, `link_presente` FROM `lista_de_presentes` WHERE `usuario_id_usuario` = '$id_user';";
    $result_presente = $mysqli->query($sql_presente);

    $dados_presente = [];

    if ($result_presente && $result_presente->num_rows > 0) {
        while ($paleta = $result_presente->fetch_assoc()) {
            $dados_presente[] = $paleta;
        }
    } 
    if (isset($_POST['adicionar-presente'], $_POST['adicionar-link'])) {
       
    
        cadastra_presente($mysqli, $_POST['adicionar-presente'], $_POST['adicionar-link'], $id_user);
    }
}

$link_compartilhamento = "https://lldev.com.br/makingDreams/public/convidado.php?id=" . $id_user;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Presentes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .link-compartilhamento {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 20px auto;
}

.input-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

#link-compartilhamento {
    flex-grow: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-copy {
    padding: 8px 12px;
    border: none;
    background-color: #734043;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-copy:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body id="body-meuspresentes">
    <script src="js/topo.js"></script>
    <section class="presentes-container">
        <div class="presentes-content">
            <div id="div-imagem">
                <div id="div-marrom"></div>
                <img src="images/buque4.jpg" alt="Presente com flores" class="presentes-imagem">
            </div>
            <div class="presentes-texto">
                <h2 id="h2-meuspresentes">Lista de presentes</h2>
                <p id="p-meuspresentes">O presente é muito importante, você deve escolher e pensar cuidadosamente. Aqui é o seu espaço para fazer uma lista dos melhores presentes que gostaria de ganhar das pessoas que você ama!</p>
                <div class="link-compartilhamento">
    <p>Compartilhe sua lista de presentes:</p>
    <div class="input-group">
        <input type="text" value="<?php echo htmlspecialchars($link_compartilhamento); ?>" readonly onclick="this.select()" id="link-compartilhamento">
        <button onclick="copiarLink()" class="btn-copy">Copiar</button>
    </div>
</div>

            </div>
        </div>

        <div class="presentes-form">
            <div id="div-h3-presentes"><h3 id="h3-meuspresentes">Adicione aqui seus presentes</h3></div>
            <div class="input-container">
                <form id="form-meuspresentes" action="" method="POST">
                    <input type="text" name="adicionar-presente" placeholder="Adicionar presente" id="adicionar-presente">
                    <input type="text" name="adicionar-link" placeholder="Adicionar link" id="adicionar-link" class="adicionar-presente">
                    <button id="btn-add" type="submit">+</button>
                </form>
            </div>
            
            <div class="lista-presentes">
    <ul id="lista-presentes-ul" class="present-list">
        <?php if (!empty($dados_presente)): ?>
            <?php foreach ($dados_presente as $presente): ?>
                <li class="present-item">
                    <div class="present-details">
                        <strong class="present-name"><?php echo htmlspecialchars($presente['nome_presente']); ?></strong>
                        <a href="<?php echo htmlspecialchars($presente['link_presente']); ?>" target="_blank" class="present-link">Ver Presente</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="no-presents">Nenhum presente encontrado.</li>
        <?php endif; ?>
    </ul>
</div>

        </div>
    </section>
    <script src="js/footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function copiarLink() {
    const link = document.getElementById("link-compartilhamento");
    link.select();
    link.setSelectionRange(0, 99999); // Para dispositivos móveis
    document.execCommand("copy");

    // Alerta de confirmação
}

    </script>
</body>
</html>
