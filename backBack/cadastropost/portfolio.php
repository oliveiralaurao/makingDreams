<?php

require_once('../../startup/connectBD.php');

function cadastra_portfolio($mysqli, $nome_portfolio, $desc_portfolio, $image, $categoria_id_categoria) {

    if (!empty($nome_portfolio) && !empty($desc_portfolio) && !empty($image['name']) && !empty($categoria_id_categoria)) {

        $target_dir = __DIR__ . '/../upload/';
        $image_name = basename($image['name']);
        $target_file = $target_dir . $image_name;

        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0775, true)) {
                echo json_encode([
                    "error" => "Erro ao criar o diretório de upload.",
                    "data" => $_POST
                ]);
                return;
            }
        }

        if (!is_writable($target_dir)) {
            echo json_encode([
                "error" => "O diretório de upload não tem permissão de escrita.",
                "data" => $_POST
            ]);
            return;
        }

        if (move_uploaded_file($image['tmp_name'], $target_file)) {

            $query = "INSERT INTO portfolio (nome_portfolio, desc_portfolio, image, categoria_id_categoria) 
                      VALUES (?, ?, ?, ?)";

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ssdi", $nome_portfolio, $desc_portfolio, $image_name, $categoria_id_categoria);

                if ($stmt->execute()) {
                    echo json_encode([
                        "success" => "Portfólio cadastrado com sucesso!",
                        "data" => [
                            "nome_portfolio" => $nome_portfolio,
                            "desc_portfolio" => $desc_portfolio,
                            "image" => $image_name,
                            "categoria_id_categoria" => $categoria_id_categoria
                        ]
                    ], JSON_PRETTY_PRINT);                    
                } else {
                    echo json_encode([
                        "error" => "Erro ao inserir registro: " . $stmt->error,
                        "data" => $_POST
                    ]);
                }

                $stmt->close();
            } else {
                echo json_encode([
                    "error" => "Erro ao preparar a query: " . $mysqli->error,
                    "data" => $_POST
                ]);
            }
        } else {
            echo json_encode([
                "error" => "Erro ao fazer upload da imagem. Código de erro: " . $image['error'],
                "data" => $_POST
            ]);
        }
    } else {
        $missing_fields = [];

        if (empty($nome_portfolio)) $missing_fields[] = "nome_portfolio";
        if (empty($desc_portfolio)) $missing_fields[] = "desc_portfolio";
        if (empty($image['name'])) $missing_fields[] = "image";
        if (empty($categoria_id_categoria)) $missing_fields[] = "categoria_id_categoria";

        echo json_encode([
            "error" => "Campos obrigatórios faltando: " . implode(", ", $missing_fields),
            "data" => $_POST
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cadastra_portfolio(
        $mysqli,
        $_POST['nome_portfolio'],
        $_POST['desc_portfolio'],
        $_FILES['image'],
        $_POST['categoria_id_categoria']
    );
}
?>
