<?php
require_once '../../startup/connectBD.php'; 

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturando os dados do formulário
    $id_checklist = $_POST['id_checklist']; // ID do checklist a ser editado
    $titulo_checklist = $_POST['titulo_checklist'];
    $data_checklist = $_POST['data_checklist'];
    $estado_checklist = $_POST['estado_checklist'];
    $hora_checklist = $_POST['hora_checklist'];
    $desc_checklist = $_POST['desc_checklist'];

    // Atualizando o checklist no banco de dados
    $sql_update = "UPDATE `checklist` SET 
                    `titulo_checklist` = ?, 
                    `data_checklist` = ?, 
                    `estado_checklist` = ?, 
                    `hora_checklist` = ?, 
                    `desc_checklist` = ? 
                    WHERE `id_checklist` = ?";

    $stmt = $mysqli->prepare($sql_update);
    $stmt->bind_param("sssssi", $titulo_checklist, $data_checklist, $estado_checklist, $hora_checklist, $desc_checklist, $id_checklist);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Checklist atualizado com sucesso.";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar checklist: " . $stmt->error;
    }

    $stmt->close();
    header("Location: ../../public/checklist.php"); // Redireciona para a página do checklist
    exit();
}
?>
