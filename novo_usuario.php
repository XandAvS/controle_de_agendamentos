<?php
session_start(); // para usar sessão no futuro, melhor já iniciar
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO usuarios(nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt->execute([$nome, $email, $senha])) {
            header("location: index.php?cadastro=true");
            exit;
        } else {
            echo "<p>Erro ao inserir o usuário</p>";
        }
    } catch (Exception $e) {
        echo "Erro ao inserir usuário: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/estilos.css">
</head>
<body>
<nav class="navbar navbar-light" style="background-color: #428ce2;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img width="125" src="src/img/slotly logo.png" alt=""></a>
    </div>
</nav>

<div class="row">
    <div class="col-5 mt-5 mx-auto cadastro">
        <form method="post">
            <h2 class="nomenclaturas">Bem-Vindo ao Cadastro de Novos Usuários</h2>
            <div class="mb-3 text-center">
                <label for="nome" class="nomenclaturas form-label">Informe o Nome de Usuário</label>
                <input type="text" id="nome" name="nome" class="form-control" required placeholder="Nome de Usuário">
            </div>
            <div class="mb-3 text-center">
                <label for="email" class="nomenclaturas form-label">Informe o E-mail</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="slotly@novousuario.com">
            </div>
            <div class="mb-3 text-center">
                <label for="senha" class="form-label nomenclaturas">Crie sua Senha de Login</label>
                <input type="password" id="senha" name="senha" class="form-control" required placeholder="Senha de Login">
            </div>
            <div class="botoes">
                <button type="button" class="btn voltar" onclick="history.back();">Voltar</button>
                <button type="submit" class="btn confirmar">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
