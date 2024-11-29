<?php

function cadastra_categoria($mysqli, $nome_categoria, $descricao_categoria) {
    $output = ""; // Variável para armazenar o resultado

    if (!empty($nome_categoria) && !empty($descricao_categoria)) {

        $query = "INSERT INTO categoria (nome_categoria, desc_categoria) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $nome_categoria, $descricao_categoria);

            if ($stmt->execute()) {
                header("Location: ../frontBack/list/listCategoris.php?msg=" . urlencode("Categoria criada com sucesso!"));
                exit();
            } else {
                $output = "Erro ao inserir registro: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $output = "Erro ao preparar a query: " . $mysqli->error;
        }
    } else {
        $output = "Todos os campos obrigatórios devem ser preenchidos!";
    }

    return $output; // Retornar o resultado
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = cadastra_categoria($mysqli, $_POST['nome_categoria'], $_POST['descricao_categoria']);
}

?>
