<?php
require_once '../startup/connectBD.php';

// Consulta para Galeria
$sql_galeria = "SELECT * FROM fotos LIMIT 4;";
$result_galeria = $mysqli->query($sql_galeria);
$dados_galeria = []; // Inicializa como um array vazio

if ($result_galeria && mysqli_num_rows($result_galeria) > 0) {
    while ($categoria = mysqli_fetch_array($result_galeria)) {
        $dados_galeria[] = array(
            'id_portfolio' => $categoria['id_portfolio'],
            'nomeP' => $categoria['nome_portfolio'],
            'descricao' => $categoria['desc_portfolio'],
            'image' => $categoria['image'],
            'categoria' => $categoria['categoria_id_categoria'],
            'nome' => $categoria['nome_categoria']
        );
    }
} else {
    $mensagem_galeria = 'Nenhum registro de galeria encontrado.';
}

// Consulta para Temas
$sql_temas = "SELECT * FROM fototema LIMIT 4;";
$result_temas = $mysqli->query($sql_temas);
$dados_temas = []; // Inicializa como um array vazio

if ($result_temas && mysqli_num_rows($result_temas) > 0) {
    while ($tema = mysqli_fetch_array($result_temas)) {
        $dados_temas[] = array(
            'id_portfolio' => $tema['id_portfolio'],
            'nomeP' => $tema['nome_portfolio'],
            'descricao' => $tema['desc_portfolio'],
            'image' => $tema['image'],
            'categoria' => $tema['categoria_id_categoria'],
            'nome' => $tema['nome_categoria']
        );
    }
} else {
    $mensagem_temas = 'Nenhum registro de temas encontrado.';
}

// Consulta para Paletas de Cores
$sql_paletas = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `categoria_id_categoria` FROM `portfolio` WHERE categoria_id_categoria = 18 LIMIT 4;";
$result_paletas = $mysqli->query($sql_paletas);
$dados_paletas = []; // Inicializa como um array vazio

if ($result_paletas && mysqli_num_rows($result_paletas) > 0) {
    while ($paleta = mysqli_fetch_array($result_paletas)) {
        $dados_paletas[] = array(
            'id_portfolio' => $paleta['id_portfolio'],
            'nomeP' => $paleta['nome_portfolio'],
            'descricao' => $paleta['desc_portfolio'],
            'image' => $paleta['image'],
            'categoria' => $paleta['categoria_id_categoria']
        );
    }
} else {
    $mensagem_paletas = 'Nenhum registro de paletas encontrado.';
}

// Consulta para Buquês
$sql_buques = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `categoria_id_categoria` FROM `portfolio` WHERE categoria_id_categoria = 19 LIMIT 4;";
$result_buques = $mysqli->query($sql_buques);
$dados_buques = []; // Inicializa como um array vazio

if ($result_buques && mysqli_num_rows($result_buques) > 0) {
    while ($buque = mysqli_fetch_array($result_buques)) {
        $dados_buques[] = array(
            'id_portfolio' => $buque['id_portfolio'],
            'nomeP' => $buque['nome_portfolio'],
            'descricao' => $buque['desc_portfolio'],
            'image' => $buque['image'],
            'categoria' => $buque['categoria_id_categoria']
        );
    }
} else {
    $mensagem_buques = 'Nenhum registro de buquês encontrado.';
}
?>
