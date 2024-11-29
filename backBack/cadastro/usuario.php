<?php

function cadastra($mysqli, $nome, $sobrenome, $email, $telefone, $senha, $senha_repetida, $rede_social, $hobbie, $descricao, $foto) {
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone) && !empty($senha) && !empty($senha_repetida)) {
        // Verifica se as senhas coincidem
        if ($senha !== $senha_repetida) {
            echo "As senhas não coincidem!";
            return;
        }

        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Processamento do upload da foto
        $foto_path = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../upload/';
            $uploadFile = $uploadDir . basename($_FILES['foto']['name']);

            // Cria o diretório se não existir
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move o arquivo enviado para o diretório
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                $foto_path = $uploadFile;
            } else {
                echo "Erro ao salvar a foto.";
                return;
            }
        }

        // Query de inserção
        $query = "INSERT INTO usuario (nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, senha_usuario, rede_social_usuario, hobbie_usuario, desc_usuario, foto_usuario) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sssssssss", $nome, $sobrenome, $email, $telefone, $senha_hash, $rede_social, $hobbie, $descricao, $foto_path);

            if ($stmt->execute()) {
                // Verifica de onde o usuário veio
                $referer = $_SERVER['HTTP_REFERER'];
                
                if (strpos($referer, 'login.php') !== false) {
                    header("Location: ../public/login.php?msg=" . urlencode("Usuário criado com sucesso! Faça login."));
                } elseif (strpos($referer, 'usuariocadastro.php') !== false) {
                    header("Location: ../frontBack/list/listUser.php?msg=" . urlencode("Usuário criado com sucesso! Você pode continuar."));
                } else {
                    header("Location: ../frontBack/list/listUser.php?msg=" . urlencode("Usuário criado com sucesso!"));
                }
                
                exit();
            } else {
                echo "Erro ao inserir registro: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao preparar a query: " . $mysqli->error;
        }
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos!";
    }
}

?>
