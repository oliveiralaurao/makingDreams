<?php
require_once('../../startup/connectBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_portfolio']) && is_array($_POST['id_portfolio'])) {
        $id_portfolios = $_POST['id_portfolio'];

        // Excluir registros da tabela favoritos que fazem referência aos portfólios
        $placeholders = implode(',', array_fill(0, count($id_portfolios), '?'));
        $sql_delete_favorites = "DELETE FROM favoritos WHERE portfolio_id_portfolio IN ($placeholders)";
        
        if ($stmt = $mysqli->prepare($sql_delete_favorites)) {
            $types = str_repeat('i', count($id_portfolios));
            $stmt->bind_param($types, ...$id_portfolios);
            $stmt->execute();
            $stmt->close();
        } else {
            header("Location: ../../frontBack/list/listPortfa.php?message=Erro ao excluir favoritos.");
            exit();
        }

        // Agora excluir os portfólios
        $sql_delete_portfolio = "DELETE FROM portfolio WHERE id_portfolio IN ($placeholders)";
        
        if ($stmt = $mysqli->prepare($sql_delete_portfolio)) {
            $types = str_repeat('i', count($id_portfolios));
            $stmt->bind_param($types, ...$id_portfolios);

            if ($stmt->execute()) {
                header("Location: ../../frontBack/list/listPortfa.php?message=Portfólios excluídos com sucesso");
                exit();
            } else {
                header("Location: ../../frontBack/list/listPortfa.php?message=Erro ao deletar os portfólios: " . urlencode($stmt->error));
                exit();
            }

            $stmt->close();
        } else {
            header("Location: ../../frontBack/list/listPortfa.php?message=Erro ao preparar a query para excluir portfólios.");
            exit();
        }
    } else {
        header("Location: ../../frontBack/list/listPortfa.php?message=Nenhum portfólio selecionado.");
        exit();
    }
} else {
    header("Location: ../../frontBack/list/listPortfa.php");
    exit();
}
