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
?>
<div class="col-5 mx-auto gap-2">
    <!--CRIAMOS AS TABELAS NO GERADOR E ADICIONAMOS NA PAGINA QUE CORRESPONDE-->
    <!--PARA CADA TABELA 4 PAGINAS, TABELA, ADICIONAR, EDITAR, CONSULTAR-->
    <table class="tabelas table table-hover table-striped " id="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <?php
                foreach ($profissionais as $p): //$p recebe a variavel a cada laço que passa,1,2,3 ...
                    //mostragem do produto.

                ?>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['foto'] ?></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="editar_profissional.php?id=<?= $p['id'] ?>" class="btn btn-warning">Editar</a>
                            <a href="consultar_profissional.php?id=<?= $p['id'] ?>" class="btn btn-info">Consultar</a>
                        </div>
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