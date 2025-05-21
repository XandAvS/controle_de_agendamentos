<?php
//include("cabecalho.php"); // se tiver erro apresenta o erro, e roda o resto que não deu erro
require_once("cabecalho.php"); //se der erro não execulta mais nada, mais seguro
//require_onde verifica se o conteudo ja foi incuido e não repete
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
<div class="col-5 mx-auto gap-2">
<!--CRIAMOS AS TABELAS NO GERADOR E ADICIONAMOS NA PAGINA QUE CORRESPONDE-->
<!--PARA CADA TABELA 4 PAGINAS, TABELA, ADICIONAR, EDITAR, CONSULTAR-->
<table class="tabelas table table-hover table-striped " id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Tempo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <?php
            foreach ($servico as $s): //$p recebe a variavel a cada laço que passa,1,2,3 ...
                //mostragem do produto.

            ?>
                <td><?= $s['id'] ?></td>
                <td><?= $s['nome'] ?></td>
                <td><?= $s['descricao'] ?></td>
                <td><?= $s['preco'] ?></td>
                <td><?= $s['tempo'] ?></td>
                <td>
                    <a href="editar_produto.php?id=<?= $s['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_produto.php?id=<?= $s['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
        </tr>
    <?php
            endforeach;
    ?>
    </tbody>
</table>
</div>
<?php
require_once("rodape.php");
?>