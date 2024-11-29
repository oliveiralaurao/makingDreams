<?php
// update_user.php
require_once('../../startup/connectBD.php');

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] == 'PATCH') { // Troca para PATCH
    // Coleta os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    $id = isset($input['id']) ? (int)$input['id'] : null;
    $nome = isset($input['nome']) ? $input['nome'] : '';
    $sobrenome = isset($input['sobrenome']) ? $input['sobrenome'] : '';
    $telefone = isset($input['telefone']) ? $input['telefone'] : '';
    $email = isset($input['email']) ? $input['email'] : '';
    $senha = isset($input['senha']) ? $input['senha'] : '';
    $user_level = isset($input['user_level']) ? $input['user_level'] : '';
    $rede_social = isset($input['rede_social']) ? $input['rede_social'] : '';
    $hobbie = isset($input['hobbie']) ? $input['hobbie'] : '';
    $descricao = isset($input['descricao']) ? $input['descricao'] : '';
    
    $foto = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_name = basename($_FILES['foto']['name']);
        $upload_dir = __DIR__ . '/../../backBack/upload/';

        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0775, true)) {
                echo json_encode(["success" => false, "message" => "Erro ao criar o diretório de upload."]);
                exit();
            }
        }

        if (!is_writable($upload_dir)) {
            echo json_encode(["success" => false, "message" => "O diretório de upload não tem permissão de escrita."]);
            exit();
        }

        $foto_path = $upload_dir . $foto_name;

        if (move_uploaded_file($foto_tmp_name, $foto_path)) {
            $foto = $foto_name; 
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao carregar a foto."]);
            exit();
        }
    } else {
        $foto = isset($input['foto_atual']) ? $input['foto_atual'] : null;
    }

    $query = "UPDATE usuario SET nome_usuario = ?, sobrenome_usuario = ?, email_usuario = ?, tel_usuario = ?, senha_usuario = ?, rede_social_usuario = ?, hobbie_usuario = ?, desc_usuario = ?, foto_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssssssi", $nome, $sobrenome, $email, $telefone, $senha, $rede_social, $hobbie, $descricao, $foto, $user_level, $id);

        if ($stmt->execute()) {
            // Retorna os dados enviados pelo usuário junto com a mensagem de sucesso
            echo json_encode([
                "success" => true,
                "message" => "Usuário atualizado com sucesso!",
                "data" => [
                    "id" => $id,
                    "nome" => $nome,
                    "sobrenome" => $sobrenome,
                    "telefone" => $telefone,
                    "email" => $email,
                    "user_level" => $user_level,
                    "rede_social" => $rede_social,
                    "hobbie" => $hobbie,
                    "descricao" => $descricao,
                    "foto" => $foto
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao atualizar o usuário: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao preparar a query: " . $mysqli->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método de requisição inválido. Use PATCH."]);
}
?>
