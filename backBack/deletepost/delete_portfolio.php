<?php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {  // Alteração para DELETE
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_portfolio'])) {
        $id_portfolio = $input['id_portfolio'];

        $sql_delete = "DELETE FROM portfolio WHERE id_portfolio = ?";
        $stmt = $mysqli->prepare($sql_delete);
        $stmt->bind_param('i', $id_portfolio);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Portfólio deletado com sucesso!",
                "id_portfolio" => $id_portfolio
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao deletar o portfólio: " . $stmt->error
            ], JSON_PRETTY_PRINT);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "ID do portfólio não foi enviado."
        ], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método de requisição inválido. Use DELETE."
    ], JSON_PRETTY_PRINT);
}
?>
