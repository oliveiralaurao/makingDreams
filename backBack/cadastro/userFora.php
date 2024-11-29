<?php
require_once('../startup/connectBD.php');

function cadastra($mysqli, $nome, $sobrenome, $email, $telefone, $senha, $foto) {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $pastaDestino = __DIR__ . '/../upload/';
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nomeFoto = uniqid('', true) . '.' . $extensao;
        $caminhoFoto = $pastaDestino . $nomeFoto;

        $tiposValidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($extensao), $tiposValidos)) {
            echo "<script>alert('Somente imagens JPG, PNG ou GIF são permitidas.');</script>";
            return;
        }

        if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('A foto deve ter no máximo 2MB.');</script>";
            return;
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoFoto)) {
        } else {
            echo "<script>alert('Erro ao fazer o upload da foto.');</script>";
            return;
        }
    } else {
        $nomeFoto = 'default.jpg';
    }

    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuario (nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, senha_usuario, foto_usuario) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $sobrenome, $email, $telefone, $senha_hash, $nomeFoto);

    if ($stmt->execute()) {
        header("Location: ../public/login.php?msg=" . urlencode("Usuário criado com sucesso! Faça login."));
        exit();
    } else {
        echo "<script>alert('Erro ao realizar o cadastro. Tente novamente mais tarde.');</script>";
    }
}
?>
