<?php
require_once('../../startup/connectBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_categoria'], $_POST['nome_categoria'], $_POST['desc_categoria'])) {
        $id_categoria = $_POST['id_categoria'];
        $nome_categoria = trim($_POST['nome_categoria']);
        $desc_categoria = trim($_POST['desc_categoria']);

        // Validação simples
        if (empty($nome_categoria) || empty($desc_categoria)) {
            header("Location: ../../frontBack/list/listCategoris.php?msg=" . urlencode('Todos os campos obrigatórios devem ser preenchidos!'));
            exit();
        }

        $query = "UPDATE categoria SET nome_categoria = ?, desc_categoria = ? WHERE id_categoria = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssi", $nome_categoria, $desc_categoria, $id_categoria);

            if ($stmt->execute()) {
                header("Location: ../../frontBack/list/listCategoris.php?msg=" . urlencode('Categoria atualizada com sucesso!'));
                exit();
            } else {
                header("Location: ../../frontBack/list/listCategoris.php?msg=" . urlencode('Erro ao atualizar a categoria: ' . $stmt->error));
                exit();
            }

            $stmt->close();
        } else {
            header("Location: ../../frontBack/list/listCategoris.php?msg=" . urlencode('Erro ao preparar a query: ' . $mysqli->error));
            exit();
        }
    } else {
        header("Location: ../../frontBack/list/listCategoris.php?msg=" . urlencode('Todos os campos obrigatórios devem ser preenchidos!'));
        exit();
    }
} else {
    header("Location: ../../frontBack/list/listCategoris.php");
    exit();
}
