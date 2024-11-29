<?php

require_once("../../startup/connectBD.php");

function cadastra($mysqli, $nome, $sobrenome, $email, $telefone, $senha, $senha_repetida, $rede_social, $hobbie, $descricao, $foto) {
    $response = array(); 
    
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone) && !empty($senha) && !empty($senha_repetida)) {
        
        if ($senha === $senha_repetida) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $query = "INSERT INTO usuario (nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, senha_usuario, rede_social_usuario, hobbie_usuario, desc_usuario, foto_usuario) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("sssssssss", $nome, $sobrenome, $email, $telefone, $senha_hash, $rede_social, $hobbie, $descricao, $foto);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Usuário cadastrado com sucesso!';
                    $response['data'] = array(
                        'nome' => $nome,
                        'sobrenome' => $sobrenome,
                        'email' => $email,
                        'telefone' => $telefone,
                        'rede_social' => $rede_social,
                        'hobbie' => $hobbie,
                        'descricao' => $descricao,
                        'foto' => $foto
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
            $response['message'] = 'As senhas não coincidem!';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Todos os campos obrigatórios devem ser preenchidos!';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

cadastra(
    $mysqli, 
    $_POST['nomeCompleto'], 
    $_POST['sobrenome'], 
    $_POST['email'], 
    $_POST['telefone'], 
    $_POST['inputPassword6'], 
    $_POST['inputPassword7'], 
    $_POST['rede_social'] ?? null,  
    $_POST['hobbie'] ?? null,
    $_POST['descricao'] ?? null,
    $_POST['foto'] ?? null
);


?>
