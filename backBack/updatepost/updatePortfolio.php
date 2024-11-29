<?php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') { // Troca para PATCH
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_portfolio'], $input['nome_portfolio'], $input['desc_portfolio'], $input['categoria_id_categoria'])) {
        $id_portfolio = $input['id_portfolio'];
        $nome_portfolio = $input['nome_portfolio'];
        $desc_portfolio = $input['desc_portfolio'];
        $categoria_id_categoria = $input['categoria_id_categoria'];

        $image_name = isset($input['image_atual']) ? $input['image_atual'] : ''; // Armazena a imagem atual por padrão

        // Tratamento do upload da nova imagem
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['new_image']['tmp_name'];
            $image_name = basename($_FILES['new_image']['name']);
            $upload_dir = __DIR__ . '/../../backBack/upload/'; 

            if (!is_writable($upload_dir)) {
                echo json_encode([
                    "success" => false,
                    "message" => "O diretório de upload não tem permissão de escrita."
                ], JSON_PRETTY_PRINT);
                exit();
            }

            $new_image = $upload_dir . $image_name;

            if (!move_uploaded_file($image_tmp_name, $new_image)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao carregar a imagem."
                ], JSON_PRETTY_PRINT);
                exit();
            }
        }

        $query = "UPDATE portfolio 
                  SET nome_portfolio = ?, desc_portfolio = ?, image = ?, categoria_id_categoria = ? 
                  WHERE id_portfolio = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssdii", $nome_portfolio, $desc_portfolio, $image_name, $categoria_id_categoria, $id_portfolio);

            if ($stmt->execute()) {
                echo json_encode([
                    "success" => true,
                    "message" => "Portfólio atualizado com sucesso!",
                    "data" => [
                        "id_portfolio" => $id_portfolio,
                        "nome_portfolio" => $nome_portfolio,
                        "desc_portfolio" => $desc_portfolio,
                        "image" => $image_name,
                        "categoria_id_categoria" => $categoria_id_categoria
                    ]
                ], JSON_PRETTY_PRINT);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Erro ao atualizar o portfólio: " . $stmt->error
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
