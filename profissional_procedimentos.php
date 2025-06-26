<?php
require_once("cabecalho.php");

function retornaBarbeiroServicos()
{
    require("conexao.php");
    try {
        $sql = "
            SELECT bs.barbeiro_id, bs.servico_id,
                   b.nome AS nome_barbeiro, b.foto,
                   s.nome AS nome_servico, s.preco, s.tempo
            FROM barbeiro_servico bs
            JOIN barbeiros b ON bs.barbeiro_id = b.id
            JOIN procedimentos s ON bs.servico_id = s.id
            ORDER BY b.nome, s.nome
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os vínculos entre barbeiros e serviços: " . $e->getMessage());
    }
}

$vinculos = retornaBarbeiroServicos();
?>

<div class="col-8 mx-auto gap-2">
    <table class="tabelas table table-hover table-striped" id="tabela">
        <thead>
            <tr>
                <th>Barbeiro</th>
                <th>Serviço</th>
                <th>Preço</th>
                <th>Duração</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vinculos as $v): ?>
                <tr>
                    <td><?= $v['nome_barbeiro']?></td>
                    <td><?= $v['nome_servico'] ?></td>
                    <td>R$ <?= $v['preco'] ?></td>
                    <td><?= $v['tempo'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once("rodape.php"); ?>
