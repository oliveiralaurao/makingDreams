<?php
require_once('startup/connectBD.php');
session_start();

if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] !== 'adm' && $_SESSION['tipo_usuario'] !== 'dev') {
    header('Location: public/login.php');
    exit();
}

$query_categorias = "SELECT * from categorias_total";
$result_categorias = mysqli_query($mysqli, $query_categorias);
$row_categorias = mysqli_fetch_assoc($result_categorias);
$total_categorias = $row_categorias['total_categorias'];

$query_portfolios = "SELECT * from portfolios_total";
$result_portfolios = mysqli_query($mysqli, $query_portfolios);
$row_portfolios = mysqli_fetch_assoc($result_portfolios);
$total_portfolios = $row_portfolios['total_portfolios'];

$query_usuarios = "SELECT * FROM usuarios_total";
$result_usuarios = mysqli_query($mysqli, $query_usuarios);
$row_usuarios = mysqli_fetch_assoc($result_usuarios);
$total_usuarios = $row_usuarios['total_usuarios'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ínicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="theme-color" content="#000000">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="images/Logo-removebg-preview.png" alt="Logo" height="70px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="public/home.html">Site</a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="frontBack/list/listPortfa.php">Portfólio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="frontBack/list/listCategoris.php">Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="frontBack/list/listUser.php">Úsuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="backBack/sair.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <p class="text-center">ÍNICIO</p>
    </header>
    <main class="container border border-1">
        <div class="row m-4">
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                        Portfólio
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?php echo $total_portfolios; ?></p>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                        Categorias
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?php echo $total_categorias; ?></p>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col mb-3">
                <div class="card">
                    <div class="card-header">
                        Úsuarios
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p><?php echo $total_usuarios; ?></p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-4">
            <div class="col">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        
    </main>

    <script>
        // Gráfico de Barras
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Categorias', 'Portfólios', 'Usuários'],
                datasets: [{
                    label: 'Totais',
                    data: [<?php echo $total_categorias; ?>, <?php echo $total_portfolios; ?>, <?php echo $total_usuarios; ?>],
                    backgroundColor: ['#734043', '#E3BDB8', '#CF9E9A', '#F5F0EB', '#C7C4BE'],
                    borderColor: '#FFF',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

       
    </script>
     <script src="/service-worker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
