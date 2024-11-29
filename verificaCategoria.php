<?php
require_once('startup/connectBD.php');

if (isset($_POST['categoria'])) {
    $categoria = $_POST['categoria'];

    $query = "SELECT nome_categoria FROM categoria WHERE nome_categoria = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $categoria);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Erro ao preparar a consulta.']);
    }
}
?>
