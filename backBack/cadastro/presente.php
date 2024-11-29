<?php

function cadastra_presente($mysqli, $nome_presente, $link_presente, $usuario_id_usuario) {
    if (!empty($nome_presente) && !empty($link_presente) && !empty($usuario_id_usuario)) {

        $query = "INSERT INTO lista_de_presentes (nome_presente, link_presente, usuario_id_usuario) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("sss", $nome_presente, $link_presente, $usuario_id_usuario);

            if ($stmt->execute()) {
                header("Location: ../public/meuspresentes.php?msg=" . urlencode("Presente cadastrado com sucesso!"));
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
