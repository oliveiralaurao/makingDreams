<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- <style>
    #main-contato{
        background-color: blue;
    }
</style> -->
</head>
<body class="pag-contato">
    <script src="js/topo.js"></script>
    <!-- <nav class="nav-a text-center py-3">
        <h1>Contato</h1>
    </nav> -->
    <main id="main-contato">
        <div class="container container-contato">
            <div class="row" id="row-contato">
                <div class="col-md-8" id="div1">
                    <div class="texto mb-4">
                        <h3>Entre em contato conosco!</h3>
                        <p id="p-contato">Gostaríamos muito de ouvir de você! Se tiver alguma dúvida, sugestão ou feedback, entre em contato conosco usando uma das opções abaixo. Estamos aqui para ajudar a tornar a sua experiência de planejamento de casamento ainda mais inspiradora.</p>
                        <article>    
                        <p><i class="bi bi-telephone"></i>(18) 99770-7859</p>
                            <p><i class="bi bi-envelope-heart"></i>@makingdreams</p></article>
                    </div>
                </div>
                <div class="col-md-4" id="form-contato">
                    <form class="formulario-contato" action="../backBack/envia_contato.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">SEU NOME:</label>
                            <input type="text" id="nome" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-MAIL:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="mensagem" class="form-label">MENSAGEM:</label>
                            <textarea id="mensagem" name="mensagem" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">ENVIAR</button>
                    </form>
                    
                </div>
            </div>
           
        </div>
    </main>
    <div class="modal fade" id="mensagemModal" tabindex="-1" aria-labelledby="mensagemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensagemModalLabel">Resultado do Envio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : ''; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Se houver uma mensagem, abrir o modal automaticamente
        var mensagem = "<?php echo isset($_GET['msg']) ? $_GET['msg'] : ''; ?>";
        if (mensagem) {
            var myModal = new bootstrap.Modal(document.getElementById('mensagemModal'));
            myModal.show();
        }
    </script>
        <script src="js/footer.js"></script>

</body>
</html>
 