    <?php
    require_once('../../startup/connectBD.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id_categoria']) && is_array($_POST['id_categoria'])) {
            $id_categorias = $_POST['id_categoria'];
            
            $placeholders = implode(',', array_fill(0, count($id_categorias), '?'));
            $sql_delete = "DELETE FROM categoria WHERE id_categoria IN ($placeholders)";
    
            if ($stmt = $mysqli->prepare($sql_delete)) {
                $types = str_repeat('i', count($id_categorias));
                $stmt->bind_param($types, ...$id_categorias);
    
                if ($stmt->execute()) {
                    header("Location: ../../frontBack/list/listCategoris.php?msg=Categorias excluídas com sucesso");
                    exit();
                } else {
                    header("Location: ../../frontBack/list/listCategoris.php?msg=Erro ao deletar categorias.");
                    exit();
                }
    
                $stmt->close();
            } else {
                header("Location: ../../frontBack/list/listCategoris.php?msg=Erro ao preparar a query.");
                exit();
            }
        } else {
            header("Location: ../../frontBack/list/listCategoris.php?msg=Nenhuma categoria selecionada.");
            exit();
        }
    } else {
        header("Location: ../../frontBack/list/listCategoris.php");
        exit();
    }
    
