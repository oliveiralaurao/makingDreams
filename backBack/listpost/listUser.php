<?php
require_once '../../startup/connectBD.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

// Verificação de sessão (descomentado caso necessário)
// if (!isset($_SESSION['email']) || ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_level'] !== 'master')) {
//     echo json_encode(["success" => false, "message" => "Acesso negado."]);
//     exit();
// }

$sql_usuarios = "SELECT `id_usuario`, `nome_usuario`, `sobrenome_usuario`, `email_usuario`, `tel_usuario`, `senha_usuario`, `tipo_usuario` FROM `usuario`";
$result_usuarios = $mysqli->query($sql_usuarios);

if ($result_usuarios) {
    $dados_usuarios = [];

    while ($usuario = mysqli_fetch_array($result_usuarios)) {
        $dados_usuarios[] = array(
            'id' => $usuario['id_usuario'],
            'nome' => $usuario['nome_usuario'],
            'sobrenome' => $usuario['sobrenome_usuario'],
            'email' => $usuario['email_usuario'],
            'telefone' => $usuario['tel_usuario'],
            'senha' => $usuario['senha_usuario'],
            'tipo' => $usuario['tipo_usuario']
        );
    }

    // Retorna os dados em formato JSON
    echo json_encode([
        "success" => true,
        "data" => $dados_usuarios
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao buscar os usuários: " . $mysqli->error
    ]);
}
?>
