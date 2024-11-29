<?php
session_start();
require_once '../../startup/connectBD.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_checklist']) && !empty($_POST['id_checklist'])) {
        $id_checklist = intval($_POST['id_checklist']);
        
        $sql_delete = "DELETE FROM checklist WHERE id_checklist = ?";
        
        if ($stmt = $mysqli->prepare($sql_delete)) {
            $stmt->bind_param("i", $id_checklist);
            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Checklist excluído com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao excluir o checklist: " . $mysqli->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensagem'] = "Erro ao preparar a exclusão: " . $mysqli->error;
        }
    } else {
        $_SESSION['mensagem'] = "ID do checklist inválido.";
    }
}
header("Location: ../../public/checklist.php"); // Redireciona para a página do checklist
exit();

?>
