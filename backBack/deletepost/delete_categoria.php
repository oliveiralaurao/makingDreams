<?php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {  // Troca para DELETE
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_categoria'])) {  
        $id_categoria = $input['id_categoria'];  

        $sql_delete = "DELETE FROM categoria WHERE id_categoria = ?";  
        $stmt = $mysqli->prepare($sql_delete);
        $stmt->bind_param('i', $id_categoria);  

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Categoria deletada com sucesso!",
                "id_categoria" => $id_categoria
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao deletar categoria: " . $stmt->error
            ], JSON_PRETTY_PRINT);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "ID da categoria não foi enviado."
        ], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método de requisição inválido. Use DELETE."
    ], JSON_PRETTY_PRINT);
}
?>
