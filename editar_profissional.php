<?php
require_once("cabecalho.php");
// Consulta barbeiro pelo ID
function consultarBarbeiro($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM barbeiros WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $barbeiro = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$barbeiro) {
            die("Erro ao consultar barbeiro");
        } else {
            return $barbeiro;
        }
    } catch (Exception $e) {
        die("Erro ao consultar barbeiro: " . $e->getMessage());
    }
}
// Consulta serviços oferecidos por um barbeiro (apenas os IDs)
function retornaServicosDoBarbeiro($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT servico_id FROM barbeiro_servico WHERE barbeiro_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return array_column($stmt->fetchAll(), 'servico_id');
    } catch (Exception $e) {
        die("Erro ao consultar serviços: " . $e->getMessage());
    }
}
// Consulta todos os procedimentos disponíveis
function consultarProcedimentos()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar procedimentos: " . $e->getMessage());
    }
}
// Altera os dados do barbeiro
function alterarBarbeiro($id, $nome, $foto)
{
    require("conexao.php");
    try {
        $sql = "UPDATE barbeiros SET nome = ?, foto = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nome, $foto, $id]);
    } catch (Exception $e) {
        die("Erro ao alterar barbeiro: " . $e->getMessage());
    }
}
// Atualiza serviços marcados
function alterarBarbeiroServicos($id, $novosServicos)
{
    require("conexao.php");
    try {
        $pdo->beginTransaction();
        // Remove todos os serviços atuais do barbeiro
        $stmtDelete = $pdo->prepare("DELETE FROM barbeiro_servico WHERE barbeiro_id = ?");
        $stmtDelete->execute([$id]);
        // Reinsere apenas os selecionados
        if (!empty($novosServicos)) {
            $stmtInsert = $pdo->prepare("INSERT INTO barbeiro_servico (barbeiro_id, servico_id) VALUES (?, ?)");
            foreach ($novosServicos as $servicoId) {
                $stmtInsert->execute([$id, $servicoId]);
            }
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro ao atualizar serviços do barbeiro: " . $e->getMessage());
    }
}


// TRATAMENTO DE POST (ENVIO DO FORMULÁRIO)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['profissional'];
    $servicos = isset($_POST['servicos']) ? $_POST['servicos'] : [];
    $foto = $_FILES['foto']['name'];
    $tmpFoto = $_FILES['foto']['tmp_name'];
    if (empty($foto)) {
        $barbeiro = consultarBarbeiro($id);
        $foto = $barbeiro['foto'];
    } else {
        move_uploaded_file($tmpFoto, 'src/img/' . $foto);
    }
    $okBarbeiro = alterarBarbeiro($id, $nome, $foto);
    alterarBarbeiroServicos($id, $servicos); // sempre executa, com ou sem alterações
    if ($okBarbeiro) {
        header('location: profissionais.php?alteracao=true');
    } else {
        header('location: profissionais.php?alteracao=false');
    }
    exit;
}
 else {
    // TRATAMENTO DE GET (CARREGAMENTO INICIAL)
    $id = $_GET['id'];
    $barbeiro = consultarBarbeiro($id);
    $servicosSelecionados = retornaServicosDoBarbeiro($id);
    $procedimentos = consultarProcedimentos();
}
?>
<div class="col-5 mt-5 mx-auto">
    <h4>Novo Profissional</h4>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $barbeiro['id'] ?>">
        <div class="mb-3">
            <label for="profissional" class="form-label">Nome do Profissional</label>
            <input value="<?= $barbeiro['nome'] ?>" type="text" id="profissional" name="profissional" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Atual</label>
            <img src="src/img/<?= $barbeiro['foto'] ?>" alt="<?= $barbeiro['nome'] ?>" style="max-width:150px;">
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Alterar Foto (opcional)</label>
            <input type="file" id="foto" name="foto" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Serviços Oferecidos</label>
            <?php foreach ($procedimentos as $proc): ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="servicos[]" value="<?= $proc['id'] ?>"
                        id="servico<?= $proc['id'] ?>" <?= in_array($proc['id'], $servicosSelecionados) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="servico<?= $proc['id'] ?>"><?= $proc['nome'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
    </form>
</div>

<?php require_once("rodape.php"); ?>
