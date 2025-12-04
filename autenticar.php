<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    // echo "Email:$email - Senha:$senha";

    //Validar os Campos
    if (empty($email) || empty($senha)) {
        header('Location: login.php');
        exit;
    }

    //Buscar usuario no Banco de Dados
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    // Verificar se o usuário existe e se a senha esta correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        $_SESSION['usuaio_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $usuario['senha'];
        $_SESSION['usuaio_email'] = $usuario['email'];

        header('locantion: index.php');
        exit;
    } else {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
