 <?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["nome"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensagem = htmlspecialchars($_POST["mensagem"]);

    // Aqui você pode salvar no banco ou enviar por e-mail:
    // mail('voce@seusite.com', 'Nova mensagem de contato', $mensagem);
    echo "<div class='alert alert-success text-center'>Mensagem enviada com sucesso, $nome!</div>";
}
?>

<div class="container mt-5">
    <div class="row align-items-center">
        <!-- Lado esquerdo com imagem/ilustração -->
        <div class="col-md-6 mb-4 text-center">
            <img src="src/img/contatoSlotly.png" class="img-fluid" alt="entre em contato">
        </div>

        <!-- Lado direito com formulário -->
        <div class="col-md-6">
            <h2 class="mb-4">Fale Conosco</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="nome" class="form-label">Seu Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Seu E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Sua Mensagem</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar Mensagem</button>
            </form>
        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
