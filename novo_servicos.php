<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
function inserirServicos($nome, $descricao, $preco, $tempo)
{
    require("conexao.php");
    try {
        $sql = "INSERT INTO procedimentos (nome, descricao, preco, tempo) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $preco, $tempo]))
            header('location: servicos.php?cadastro=true');
        else
            header('location: servicos.php?cadastro=false');
    } catch (Exception $e) {
        die("Erro ao inserir: " . $e->getMessage());
    }
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['servico'];       // campo do input
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $tempo = $_POST['duracao'];

        inserirServicos($nome, $descricao, $preco, $tempo);
    }
?>

<div class="col-5 mt-5 mx-auto">
    <h4>Novo Serviço</h4>
    <form method="post">
        <div class="mb-3">
            <label for="servico" class="form-label">Novo Serviço à Oferecer</label>
            <input type="text" id="servico" name="servico" class="form-control">
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="text" id="preco" name="preco" class="form-control">
        </div>
        <div class="mb-3">
            <label for="duracao" class="form-label">Duração</label>
            <input type="text" id="duracao" name="duracao" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary"
            onclick="history.back();">Voltar</button>
    </form>
</div>
<?php
require_once("rodape.php");
