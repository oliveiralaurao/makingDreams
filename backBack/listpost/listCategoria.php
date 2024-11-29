<?php
require_once '../../startup/connectBD.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

// Consulta para obter categorias
$sql_categorias = "SELECT `id_categoria`, `nome_categoria`, `desc_categoria` FROM `categoria`";
$result_categorias = $mysqli->query($sql_categorias);

if ($result_categorias) {
    $dados_categorias = [];

    while ($categoria = mysqli_fetch_array($result_categorias)) {
        $dados_categorias[] = array(
            'id' => $categoria['id_categoria'],
            'nome' => $categoria['nome_categoria'],
            'descricao' => $categoria['desc_categoria']
        );
    }

    // Retorna os dados em formato JSON
    echo json_encode([
        "success" => true,
        "data" => $dados_categorias
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao buscar as categorias: " . $mysqli->error
    ]);
}
?>
