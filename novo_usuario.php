<?php
//sempre que for começar uma função de virificar no banco
//devoemos conectar antes
require('conexao.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash(password: $_POST['senha'], algo: PASSWORD_BCRYPT);
        //criptografar a senha com a função password_hash
        // PASSWORD_BCRYPT é o algoritimo para a criptografia

        // inserção no banco de dados
        $stmt = $pdo->prepare("INSERT INTO usuarios(nome, email, senha)
                    VALUES (?,?,?)");
        if ($stmt->execute([$nome, $email, $senha])) {
            // DECLARAR OS PARAMETROS COMO ? PARA PREPARAR O BANCO
            header("location: index.php?cadastro=true");                                               // NA ESTRUTURA DA TABELA
        }              // isso que incrementa no banco de dados 
        else {
            echo "<p> Erro ao inserir o usuario</p>";
        }
    } catch (Exception $e) {
        echo "erro ao inserir usuario" . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./src/css/estilos.css">
</head>
<body>
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
    <div class="row">
        <div class="col-5 mt-5 mx-auto cadastro">
            <form action="post">
                <h2 class="nomenclaturas">Bem-Vindo ao Cadastro de Novos Usuários</h2>
                <form action="" method="post">
                    <div class="mb-3 text-center"> <!--Nome-->
                        <label for="nome" class="nomenclaturas form-label ">Informe o Nome de Usuário</label>
                        <input type="text" id="nome" name="nome" class="form-control" required="" placeholder="Nome de Usuário">
                    </div>
                    <div class="mb-3 text-center"> <!--Email-->
                        <label for="nome" class="nomenclaturas form-label ">Informe o Nome de Usuário</label>
                        <input type="text" id="email" name="email" class="form-control" required="" placeholder="slotly@novousuario.com">
                    </div>
                    <div class="mb-3 text-center"><!--Senha-->
                        <label for="senha" class="form-label nomenclaturas">Crie sua Senha de Login</label>
                        <input type="password" id="senha" name="senha" class="form-control" required="" placeholder="Senha de Login">
                    </div>
                    <div class="botoes">
                        <button type="button" class="btn voltar" onclick="history.back();">Voltar</button>
                        <button type="submit" class="btn confirmar">Cadastrar</button>
                    </div>
                </form>
        </div>
    </div>
</body>

</html>