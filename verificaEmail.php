<?php
require_once('startup/connectBD.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $query = "SELECT id_usuario FROM usuario WHERE email_usuario = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $email);
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
