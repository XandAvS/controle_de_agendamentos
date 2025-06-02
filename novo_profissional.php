<?php
require_once("cabecalho.php");

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['profissional'] ?? '';
    $servicos = $_POST['servicos'] ?? [];

    if (empty($nome)) {
        echo "<div class='alert alert-warning col-5 mt-5 mx-auto'>O nome do profissional é obrigatório.</div>";
    } else {
        // Upload da imagem
        $fotoNome = $_FILES['foto']['name'];
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $caminho = "src/img/" . basename($fotoNome);

        if (move_uploaded_file($fotoTmp, $caminho)) {
            try {
                require("conexao.php");

                // Inserir profissional
                $sql = "INSERT INTO barbeiros (nome, foto) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $fotoNome]);

                $barbeiroId = $pdo->lastInsertId();

                // Inserir serviços
                foreach ($servicos as $idServico) {
                    $sql2 = "INSERT INTO barbeiro_servico (barbeiro_id, servico_id) VALUES (?, ?)";
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->execute([$barbeiroId, $idServico]);
                }

                header('location: profissionais.php?cadastro=true');
                exit;
            } catch (Exception $e) {
                echo "<div class='alert alert-danger col-5 mt-5 mx-auto'>Erro ao salvar no banco de dados: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger col-5 mt-5 mx-auto'>Erro ao enviar a imagem.</div>";
        }
    }
}
?>

<div class="col-5 mt-5 mx-auto">
    <h4>Novo Profissional</h4>
    <form method="post" enctype="multipart/form-data">
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