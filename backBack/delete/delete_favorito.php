<?php
require_once '../../startup/connectBD.php';
session_start();

if (isset($_POST['portfolio_id']) && isset($_SESSION['id_usuario'])) {
    $usuario_id = $_SESSION['id_usuario'];
    $portfolio_id = intval($_POST['portfolio_id']);

    $stmt = $mysqli->prepare("DELETE FROM favoritos WHERE usuario_id_usuario = ? AND portfolio_id_portfolio = ?");
    $stmt->bind_param("ii", $usuario_id, $portfolio_id);

    if ($stmt->execute()) {
        header("Location: ../../public/perfil.php?msg=" . urlencode("Item removido dos favoritos com sucesso!"));
    } else {
        header("Location:../../public/perfil.php?msg=" . urlencode("Erro ao remover o item dos favoritos."));
    }

    $stmt->close();
} else {
    header("Location: ../../public/perfil.php?msg=" . urlencode("Parâmetros inválidos."));
    exit();
}
?>
