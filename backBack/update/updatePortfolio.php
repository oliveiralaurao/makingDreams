<?php
require_once('../../startup/connectBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_portfolio'], $_POST['nome_portfolio'], $_POST['desc_portfolio'], $_POST['categoria_id_categoria'])) {
        $id_portfolio = $_POST['id_portfolio'];
        $nome_portfolio = $_POST['nome_portfolio'];
        $desc_portfolio = $_POST['desc_portfolio'];
        $categoria_id_categoria = $_POST['categoria_id_categoria'];

        $query = "SELECT image FROM portfolio WHERE id_portfolio = ?";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("i", $id_portfolio);
            $stmt->execute();
            $result = $stmt->get_result();
            $portfolio = $result->fetch_assoc();
            $image_name = $portfolio['image'] ?? '';

            $stmt->close();
        }

        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['new_image']['tmp_name'];
            $image_name = basename($_FILES['new_image']['name']);
            
            $check = getimagesize($image_tmp_name);
            if ($check === false) {
                echo 'O arquivo não é uma imagem válida.';
                exit();
            }

            $upload_dir = __DIR__ . '/../../backBack/upload/'; 

            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0775, true)) {
                    echo 'Erro ao criar o diretório de upload.';
                    exit();
                }
            }

            if (!is_writable($upload_dir)) {
                echo 'O diretório de upload não tem permissão de escrita.';
                exit();
            }

            $new_image = $upload_dir . $image_name;

            if (!move_uploaded_file($image_tmp_name, $new_image)) {
                echo 'Erro ao carregar a imagem.';
                exit();
            }
        } else {
            $image_name = $portfolio['image'];
        }

        $query = "UPDATE portfolio 
                  SET nome_portfolio = ?, desc_portfolio = ?, image = ?, categoria_id_categoria = ? 
                  WHERE id_portfolio = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sssii", $nome_portfolio, $desc_portfolio, $image_name, $categoria_id_categoria, $id_portfolio);

            if ($stmt->execute()) {
                header("Location: ../../frontBack/list/listPortfa.php?message=" . urlencode("Portfólio atualizado com sucesso!"));
                exit();
            } else {
                echo 'Erro ao atualizar o portfólio: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            echo 'Erro ao preparar a query: ' . $mysqli->error;
        }
    } else {
        echo 'Todos os campos obrigatórios devem ser preenchidos!';
    }
} else {
    header("Location: ../../frontBack/list/listPortfa.php");
    exit();
}
?>
