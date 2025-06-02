<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
function retornaProfissionais()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM barbeiros";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os profissionais: " . $e->getMessage());
    }
}

$profissionais = retornaProfissionais();
function retornaServicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos AS servicos";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os Serviços Disponíveis: " . $e->getMessage());
    }
}

$servico = retornaServicos();

?>

<div class="col-5 mt-5 mx-auto">
    <h4>Editar Profissional</h4>
        <!--cirar um campo que vai ser escondido 
            e vai armazena ro id da chave para depois 
            passar e poder alterar-->
    <form method="post">
    <form method="post" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?= $procedimento['id'] ?>">
        <div class="mb-3">
            <label for="profissional" class="form-label">Informe o Nome do Profissional</label>
            <input type="text" id="profissional" name="profissional" class="form-control">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Inserir Foto do Profissional</label>
            <input type="file" id="foto" name="foto" class="form-control">
        </div>
        <div class="mb-3">
            <?php foreach ($servico as $s): ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="servicos[]" value="<?= $s['id'] ?>" id="servico<?= $s['id'] ?>">
                    <label class="form-check-label" for="servico<?= $s['id'] ?>"><?= $s['nome'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php
require_once("rodape.php");
?>