    <?php
    require_once '../../startup/connectBD.php';

    header('Content-Type: application/json');

    $sql_portfolios = "SELECT * FROM `innerportfolio`";
    $result_portfolios = $mysqli->query($sql_portfolios);

    if ($result_portfolios) {
        $dados_portfolios = [];

        while ($portfolio = mysqli_fetch_array($result_portfolios)) {
            $dados_portfolios[] = array(
                'id' => $portfolio['id_portfolio'],
                'nome' => $portfolio['nome_portfolio'],
                'descricao' => $portfolio['desc_portfolio'],
                'imagem' => $portfolio['image'],
                'categoria' => $portfolio['nome_categoria']
            );
        }

        // Retorna os dados em formato JSON
        echo json_encode([  
            "success" => true,
            "data" => $dados_portfolios
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao buscar os portfólios: " . $mysqli->error
        ]);
    }
    ?>
