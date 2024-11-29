<?php
$mensagemModal = ""; // Variável para armazenar a mensagem do modal

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    $para = 'lila.anaclara69@gmail.com';
    $assunto = 'Novo contato de ' . $nome;

    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

    $corpo = "<h2>Novo contato recebido</h2>";
    $corpo .= "<p><strong>Nome:</strong> $nome</p>";
    $corpo .= "<p><strong>E-mail:</strong> $email</p>";
    $corpo .= "<p><strong>Mensagem:</strong></p>";
    $corpo .= "<p>$mensagem</p>";

    if (mail($para, $assunto, $corpo, $headers)) {
        $mensagemModal = "Mensagem enviada com sucesso!";
    } else {
        $mensagemModal = "Falha ao enviar a mensagem. Tente novamente mais tarde.";
    }
} else {
    $mensagemModal = "Método inválido.";
}

header("Location: ../public/contato.php?msg=" . urlencode($mensagemModal));
exit();
?>
