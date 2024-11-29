<?php

require_once('../startup/connectBD.php');

function cadastra_portfolio($mysqli, $nome_portfolio, $desc_portfolio, $image, $categoria_id_categoria) {

    if (!empty($nome_portfolio) && !empty($desc_portfolio) && !empty($image['name']) && !empty($categoria_id_categoria)) {

        $target_dir = __DIR__ . '/../upload/';
        $image_name = basename($image['name']);
        $target_file = $target_dir . $image_name;

        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0775, true)) {
                echo "Erro ao criar o diretório de upload.";
                return;
            }
        }
        if (move_uploaded_file($image['tmp_name'], $target_file)) {

            $query = "INSERT INTO portfolio (nome_portfolio, desc_portfolio, image, categoria_id_categoria) 
                      VALUES (?, ?, ?, ?)";

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("sssi", $nome_portfolio, $desc_portfolio, $image_name, $categoria_id_categoria);

                if ($stmt->execute()) {
                    header("Location: ../frontBack/list/listPortfa.php?message=" . urlencode("Portfólio criado com sucesso!"));

                    exit();
                } else {
                    echo "Erro ao inserir registro: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Erro ao preparar a query: " . $mysqli->error;
            }
        } else {
            echo "Erro ao fazer upload da imagem. Código de erro: " . $image['error'];
        }
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos!";
    }
}

?>
