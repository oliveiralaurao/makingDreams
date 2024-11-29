<?php
session_start();
require_once('../../startup/connectBD.php');

// Verifica se o usuário está logado e tem um ID de usuário na sessão
if (!isset($_SESSION['id_usuario'])) {
    die("Usuário não autenticado!");
}

$usuarioId = $_SESSION['id_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo_checklist'];
    $data = $_POST['data_checklist'];
    $hora = $_POST['hora_checklist'];
    $descricao = $_POST['desc_checklist'];
    $estado = $_POST['estado_checklist'];

    // Preparar e executar a instrução SQL
    $stmt = $mysqli->prepare("INSERT INTO checklist (titulo_checklist, data_checklist, estado_checklist, hora_checklist, desc_checklist, usuario_id_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $titulo, $data, $estado, $hora, $descricao, $usuarioId);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Checklist adicionado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro: " . $stmt->error;
    }

    // Fechar a instrução e conexão
    $stmt->close();
    $mysqli->close();

    // Redirecionar para a página principal
    header("Location: ../../public/checklist.php"); // ajuste o caminho para a página HTML
    exit();
}
?>
