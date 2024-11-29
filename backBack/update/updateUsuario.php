<?php
require_once('../../startup/connectBD.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['id_usuario'];

    // Consulta para buscar os dados atuais do usuário
    $sql_current = "SELECT nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, rede_social_usuario, hobbie_usuario, desc_usuario, foto_usuario FROM usuario WHERE id_usuario = ?";
    $stmt_current = mysqli_prepare($mysqli, $sql_current);
    mysqli_stmt_bind_param($stmt_current, 'i', $user_id);
    mysqli_stmt_execute($stmt_current);
    $result_current = mysqli_stmt_get_result($stmt_current);
    $current_user = mysqli_fetch_assoc($result_current);

    // Obtém os dados do formulário ou mantém os valores atuais
    $nome = !empty($_POST['nome']) ? $_POST['nome'] : $current_user['nome_usuario'];
    $sobrenome = !empty($_POST['sobrenome']) ? $_POST['sobrenome'] : $current_user['sobrenome_usuario'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $current_user['email_usuario'];
    $telefone = !empty($_POST['telefone']) ? $_POST['telefone'] : $current_user['tel_usuario'];
    $rede_social = !empty($_POST['rede_social']) ? $_POST['rede_social'] : $current_user['rede_social_usuario'];
    $hobbie = !empty($_POST['hobbie']) ? $_POST['hobbie'] : $current_user['hobbie_usuario'];
    $descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : $current_user['desc_usuario'];

    // Processa a foto, se for enviada; caso contrário, mantém a foto existente
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_nome = basename($_FILES['foto']['name']);
        $foto_caminho = "../upload/" . $foto_nome;
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_caminho);
    } else {
        // Mantém a foto existente
        $foto_nome = $current_user['foto_usuario'];
    }

    $sql = "UPDATE usuario 
            SET nome_usuario=?, sobrenome_usuario=?, email_usuario=?, tel_usuario=?, rede_social_usuario=?, hobbie_usuario=?, desc_usuario=?, foto_usuario=?
            WHERE id_usuario=?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssi', $nome, $sobrenome, $email, $telefone, $rede_social, $hobbie, $descricao, $foto_nome, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Redireciona de volta ao perfil com sucesso
        header("Location: ../../public/perfil.php?success=1");
        exit();
    } else {
        echo "Erro ao atualizar perfil: " . mysqli_error($mysqli);
    }
}
?>
