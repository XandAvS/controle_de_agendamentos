<?php
session_start();  // <== Inicia sessão logo no topo
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Salva dados na sessão
            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['nome'] = $usuario['nome'];   // ESSENCIAL para o nome no agendamento
            $_SESSION['acesso'] = true;
            $_SESSION['id'] = $usuario['id'];

            header('location: home.php');
            exit;
        } else {
            $mensagem['erro'] = "Usuário e/ou senha incorretos!";
        }
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        die();
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Slotly</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div class="col-5 mt-5 mx-auto">
        <h1 class="mt-5 text-center">Slotly</h1>

        <?php if (isset($mensagem['erro'])): ?>
            <div class="alert alert-danger mt-3 mb-3"><?= $mensagem['erro'] ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['mensagem']) && $_GET['mensagem'] == "acesso_negado"): ?>
            <div class="alert alert-danger mt-3 mb-3">
                Você precisa informar seus dados de acesso para acessar o sistema!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="row">
                <div class="col mb-3 text-center">
                    <label for="email" class="form-label">Informe o email</label>
                    <input id="email" name="email" class="form-control" type="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3 text-center">
                    <label for="senha" class="form-label">Informe a senha</label>
                    <input id="senha" name="senha" class="form-control" type="password" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3 mx-auto text-center">
                    <button type="submit" class="btn btn-primary">Acessar</button>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3 mx-auto text-center">
                    Não possui acesso? Clique <a href="novo_usuario.php">aqui</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
