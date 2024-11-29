<?php
require_once('../../startup/connectBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_usuarios'])) {
        $id_usuarios = $_POST['id_usuarios'];
        
        $placeholders = rtrim(str_repeat('?,', count($id_usuarios)), ',');
        $sql_delete = "DELETE FROM usuario WHERE id_usuario IN ($placeholders)";

        $stmt = $mysqli->prepare($sql_delete);
        $stmt->bind_param(str_repeat('i', count($id_usuarios)), ...$id_usuarios);

        if ($stmt->execute()) {
            header("Location: ../../frontBack/list/listUser.php?msg=" . urlencode('Usuários deletados com sucesso!'));
            exit();
        } else {
            header("Location: ../../frontBack/list/listUser.php?msg=" . urlencode('Erro ao deletar usuários.'));
            exit();
        }

        $stmt->close();
    } else {
        header("Location: ../../frontBack/list/listUser.php?msg=" . urlencode('Nenhum usuário selecionado.'));
        exit();
    }
} else {
    header("Location: ../../frontBack/list/listUser.php?msg=" . urlencode('Método inválido.'));
    exit();
}

