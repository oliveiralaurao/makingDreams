document.addEventListener('DOMContentLoaded', function() {
    if (!document.querySelector('header')) {
        var headerContent = `
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="../images/Logo-removebg-preview.png" alt="Logo" height="90px">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="home.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-linkk" href="portifolio.php">Portfólio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-linkk" href="sobre.html">Quem somos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-linkk" href="contato.php">Contato</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Perfil <i class="bi bi-caret-down-fill"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="login.php">Login/Cadastro</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="checklist.php">Checklist</a></li>
                                    <li><a class="dropdown-item" href="meuspresentes.php">Meus Presentes</a></li>
                                    <li><a class="dropdown-item" href="perfil.php">Meu Perfil</a></li>
                                    <li><a class="dropdown-item" href="../backBack/sair.php">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        `;
        document.body.insertAdjacentHTML('afterbegin', headerContent);
    }
});
