<?php
require_once '../../startup/connectBD.php';
session_start();

if (isset($_POST['usuario_id']) && isset($_POST['portfolio_id'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $portfolio_id = intval($_POST['portfolio_id']);

    // Verificar se já está nos favoritos
    $check_stmt = $mysqli->prepare("SELECT * FROM favoritos WHERE usuario_id_usuario = ? AND portfolio_id_portfolio = ?");
    $check_stmt->bind_param("ii", $usuario_id, $portfolio_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Remover dos favoritos
        $delete_stmt = $mysqli->prepare("DELETE FROM favoritos WHERE usuario_id_usuario = ? AND portfolio_id_portfolio = ?");
        $delete_stmt->bind_param("ii", $usuario_id, $portfolio_id);
        if ($delete_stmt->execute()) {
            echo "removed";
        } else {
            echo "error";
        }
        $delete_stmt->close();
    } else {
        // Adicionar aos favoritos
        $insert_stmt = $mysqli->prepare("INSERT INTO favoritos (usuario_id_usuario, portfolio_id_portfolio) VALUES (?, ?)");
        $insert_stmt->bind_param("ii", $usuario_id, $portfolio_id);
        if ($insert_stmt->execute()) {
            echo "added";
        } else {
            echo "error";
        }
        $insert_stmt->close();
    }

    $check_stmt->close();
} else {
    echo "invalid";
}
?>
