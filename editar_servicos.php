<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
function consultarProcedimentos($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $procedimento = $stmt->fetch((PDO::FETCH_ASSOC));
        if (!$procedimento) {
            die("Erro ao Consultar Registro");
        } else {
            return $procedimento;
        }
    } catch (Exception $e) {
        die("Erro ao Consultar Procedimento" . $e->getMessage());
    }
}

//função alterar procedimentos
function alterarProcedimentos($nome, $descricao, $preco, $tempo, $id)
{
    require("conexao.php");
    try {
        $sql = "UPDATE procedimentos set nome = ?, descricao = ?, preco = ?, tempo = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $preco, $tempo, $id])) {
            header('location: servicos.php?alteracao=true');
        } else { //'location (caminho)? (criação da variavel para retorno do status) 
            header('location: procedimentos.php?alteracao=false');
        }
    } catch (Exception $e) {
        die("Erro ao inserir Categoria:" . $e->getMessage());
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['servico'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $tempo = $_POST['duracao'];
    $id = $_POST['id'];
    alterarProcedimentos($nome, $descricao, $preco, $tempo, $id);
} else {
    $procedimento = consultarProcedimentos($_GET['id']);
}

?>
<div class="col-5 mx-auto gap-2">
    <h2>Alterar Procedimentos</h2>
    <!--cirar um campo que vai ser escondido 
    e vai armazena ro id da chave para depois 
    passar e poder alterar-->
    <form method="post">
        <input type="hidden" name="id" value="<?= $procedimento['id'] ?>">
        <div class="mb-3">
            <label for="servico" class="form-label">Alterar Serviço à Oferecer</label>
            <input value="<?= $procedimento['nome'] ?>" type="text" id="servico" name="servico" class="form-control">
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <!--sempre que for puxar as informações dentro do 
            textarea tem que inserir 
            ele dentro das chaves >******< -->
            <textarea id="descricao" name="descricao" class="form-control" rows="4"><?= $procedimento['descricao'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input value="<?= $procedimento['preco'] ?>" type="text" id="preco" name="preco" class="form-control">
        </div>
        <div class="mb-3">
            <label for="duracao" class="form-label">Duração</label>
            <input value="<?= $procedimento['tempo'] ?>" type="text" id="duracao" name="duracao" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary"
            onclick="history.back();">Voltar</button>
    </form>
</div>
<?php
require_once("rodape.php");
