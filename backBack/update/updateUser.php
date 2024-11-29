<?php
require_once('../../startup/connectBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $rede_social = isset($_POST['rede_social']) ? $_POST['rede_social'] : '';
    $hobbie = isset($_POST['hobbie']) ? $_POST['hobbie'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $foto = isset($_POST['foto']) ? $_POST['foto'] : '';
    $user_level = $_POST['user_level'];

    $query = "UPDATE usuario SET nome_usuario = ?, sobrenome_usuario = ?, email_usuario = ?, tel_usuario = ?, senha_usuario = ?, rede_social_usuario = ?, hobbie_usuario = ?, desc_usuario = ?, foto_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssssssi", $nome, $sobrenome, $email, $telefone, $senha, $rede_social, $hobbie, $descricao, $foto, $user_level, $id);
        
        if ($stmt->execute()) {
            header("Location: ../../frontBack/list/listUser.php?msg=Usuário atualizado com sucesso!");
            exit;
        } else {
            header("Location: ../../frontBack/list/listUser.php?msg=Erro ao atualizar usuário!" . $stmt->error);
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a query: " . $mysqli->error;
    }

}
?>
