<?php
require_once("cabecalho.php");

function retornaServicos()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os Serviços Disponíveis: " . $e->getMessage());
    }
}
$procedimentos = retornaServicos();
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
<div class="container">
    <div>
        <h4 class="mb-3 nomenclaturas">SELECIONE UM PROFISSIONAL:</h4>
        <div class="snap-container" id="listaprofissionais">
            <?php foreach ($profissionais as $p): ?>
                <div class="snap-item" onclick="selecionar(this, '<?= $p['nome']; ?>')">
                    <img src="src/img/<?= $p['foto']; ?>" alt="<?= $p['nome']; ?>" class="img-fluid" style="height:100px;">
                    <div><?= $p['nome']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
            <a href="novo_profissional.php" class="btn novo"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="profissionais.php" class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>
    </div>
    <div>
        <h4 class="mb-3 nomenclaturas">SELECIONE OS SERVIÇOS:</h4>
        <div class="snap-container" id="listaServicos">
            <?php
            foreach ($procedimentos as $pp):
            ?>
                <div class="snap-item" onclick="selecionar(this, '<?= $pp['nome']; ?>')">
                    <img src="src/img/slotly logo.png?text=Corte" alt="<?= $pp['nome']; ?>">
                    <div><?= $pp['nome']; ?></div>
                    <div class="servico-info">
                        <span><?= $pp['preco']; ?></span><span><?= $pp['tempo']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2">
            <a href="novo_servicos.php" class="btn novo"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="servicos.php" class="btn editar"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>
    </div>

    <div class="col-5 mt-5 mx-auto">
        <form method="post">
            <div class="mb-3">
                <label for="data" class="form-label">Selecione o dia para o procedimento</label>
                <input type="date" id="data" name="data" class="form-control" required>
            </div>
        </form>
    </div>

    <button id="enviar" class="btn btn-secondary col-5 mx-auto mt-4 d-block" onclick="enviarServicos()">Enviar</button>

</div>

<script>
    const selecionados = [];

    function selecionar(element, nome) {
        element.classList.toggle('selecionado');
        if (selecionados.includes(nome)) {
            selecionados.splice(selecionados.indexOf(nome), 1);
        } else {
            selecionados.push(nome);
        }
    }
</script>

</body>

</html>

<?php
require_once("rodape.php");
?>