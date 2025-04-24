<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Controle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #428ce2;">
    <div class="container-fluid"> <!-- 100% da largura -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img width="125" src="src/img/slotly logo.png" alt="">
        </a>
        </div>
</nav>
<body class="container mt-5">
    <div class="row">
        <div class="col-5 mt-5 mx-auto">
            <h1 class="mt-5 text-center">Sistema de controle</h1>
            <?php
            require_once('conexao.php');
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                try {
                    $email = $_POST['email'];
                    $senha = $_POST['senha'];
                    // vamos buscar no banco de dados quais emails estão cadastrados
                    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
                    
                    $stmt->execute([$email]); // execultar a consulta
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($usuario && password_verify($senha, $usuario['senha'])) {
                        // verifica se o email e a senha que foi informada está cadasrtada na tabela
                        session_start();
                        $_SESSION['usuario'] = $usuario['nome'];
                        $_SESSION['acesso'] = true;
                        $_SESSION['id'] = $usuario['id'];
                        header('location: principal.php');
                    } else {
                        $mensagem['erro'] = "Usuário e/ou senha incorretos!";
                    }
                } catch (Exception $e) {
                    echo "Erro" . $e->getMessage();
                    die();
                }
            }

            ?>
            <?php if (isset($mensagem['erro'])): ?>
                <div class="alert alert-danger mt-3 mb-3">
                    <?= $mensagem['erro'] ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['menssagem']) && ($mensagem == "acesso_negado")): ?>
                <div class="alert alert-danger mt-3 mb-3">
                    Você precisa informar seus dados de acesso para acessar o sistema!
                </div>
            <?php endif; ?>


            <form action="" method="POST">

                <div class="row">
                    <div class="col mb-3 text-center">
                        <label for="email" class="form-label">Informe o email</label>
                        <input id="email" name="email" class="form-control" type="text">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3 text-center">
                        <label for="senha" class="form-label">Informe a senha</label>
                        <input id="senha" name="senha" class="form-control" type="password">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>