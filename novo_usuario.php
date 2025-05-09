<?php 
    //sempre que for começar uma função de virificar no banco
    //devoemos conectar antes
    require('conexao.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        try{
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = password_hash(password: $_POST['senha'], algo: PASSWORD_BCRYPT);
             //criptografar a senha com a função password_hash
            // PASSWORD_BCRYPT é o algoritimo para a criptografia

              // inserção no banco de dados
            $stmt = $pdo->prepare("INSERT INTO usuarios(nome, email, senha)
                    VALUES (?,?,?)");
            if($stmt->execute([$nome, $email, $senha])){
                // DECLARAR OS PARAMETROS COMO ? PARA PREPARAR O BANCO
                header("location: index.php?cadastro=true");                                               // NA ESTRUTURA DA TABELA
            }              // isso que incrementa no banco de dados 
            else{
                echo "<p> Erro ao inserir o usuario</p>";
            }               
        }catch (Exception $e){
            echo "erro ao inserir usuario". $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
</head>
<body>
    <form action="post">
        <div >

        </div>
    </form>    
</body>
</html>