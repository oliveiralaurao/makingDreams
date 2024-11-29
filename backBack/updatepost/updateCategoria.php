<?php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_categoria'], $input['nome_categoria'], $input['desc_categoria'])) {
        $id_categoria = $input['id_categoria'];
        $nome_categoria = $input['nome_categoria'];
        $desc_categoria = $input['desc_categoria'];

        $query = "UPDATE categoria SET nome_categoria = ?, desc_categoria = ? WHERE id_categoria = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssi", $nome_categoria, $desc_categoria, $id_categoria);

            if ($stmt->execute()) {
                echo json_encode([
                    "success" => true,
                    "message" => "Categoria atualizada com sucesso!",
                    "id_categoria" => $id_categoria,
                    "nome_categoria" => $nome_categoria,
                    "desc_categoria" => $desc_categoria
                ], JSON_PRETTY_PRINT);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao atualizar a categoria: " . $stmt->error
                ], JSON_PRETTY_PRINT);
            }

            $stmt->close();
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao preparar a query: " . $mysqli->error
            ], JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Todos os campos obrigatórios devem ser preenchidos!"
        ], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método de requisição inválido. Use PATCH."
    ], JSON_PRETTY_PRINT);
}
?>
