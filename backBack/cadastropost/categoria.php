<?php

require_once('../../startup/connectBD.php');

function cadastra_categoria($mysqli, $nome_categoria, $descricao_categoria) {
    $response = array(); 
    if (!empty($nome_categoria) && !empty($descricao_categoria)) {

        $query = "INSERT INTO categoria (nome_categoria, desc_categoria) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ss", $nome_categoria, $descricao_categoria);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Categoria inserida com sucesso!';
                $response['data'] = array(
                    'nome_categoria' => $nome_categoria,
                    'descricao_categoria' => $descricao_categoria
                );
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Erro ao inserir registro: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao preparar a query: ' . $mysqli->error;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Todos os campos obrigatórios devem ser preenchidos!';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cadastra_categoria($mysqli, $_POST['nome'], $_POST['descricao']);
}
?>
