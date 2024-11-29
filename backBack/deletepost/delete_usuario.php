<?php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {  // Alteração para DELETE
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id_usuario'])) {
        $id_usuario = $input['id_usuario'];  

        $sql_delete = "DELETE FROM usuario WHERE id_usuario = ?";  
        $stmt = $mysqli->prepare($sql_delete);
        $stmt->bind_param('i', $id_usuario);  

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Usuário deletado com sucesso!",
                "id_usuario" => $id_usuario
            ], JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erro ao deletar usuário: " . $stmt->error
            ], JSON_PRETTY_PRINT);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "ID do usuário não foi enviado."
        ], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método de requisição inválido. Use DELETE."
    ], JSON_PRETTY_PRINT);
}
?>
