<?php
require_once("cabecalho.php");

// Função que busca os dados do procedimento (serviço)
function consultarProcedimento($id) {
    require("conexao.php");
    try {
        $sql = "SELECT * FROM procedimentos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $procedimento = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$procedimento) {
            die("Procedimento não encontrado.");
        }
        return $procedimento;
    } catch (Exception $e) {
        die("Erro ao consultar procedimento: " . $e->getMessage());
    }
}

// Função que exclui vínculos do procedimento com barbeiros
function excluirVinculosProcedimento($id) {
    require("conexao.php");

    try {
        $stmt = $pdo->prepare("DELETE FROM barbeiro_servico WHERE servico_id = ?");
        $stmt->execute([$id]);
    } catch (Exception $e) {
        die("Erro ao excluir vínculos do procedimento: " . $e->getMessage());
    }
}

// Função que exclui o procedimento
function excluirProcedimento($id) {
    require("conexao.php");
    try {
        $stmt = $pdo->prepare("DELETE FROM procedimentos WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (Exception $e) {
        die("Erro ao excluir procedimento: " . $e->getMessage());
    }
}

// Exclusão via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    excluirVinculosProcedimento($id);
    $ok = excluirProcedimento($id);
    if ($ok) {
        header("Location: servicos.php?exclusao=true");
    } else {
        header("Location: servicos.php?exclusao=false");
    }
    exit;
}

// Carregamento inicial via GET
if (!isset($_GET['id'])) {
    die("ID do serviço não informado.");
}

$id = $_GET['id'];
$procedimento = consultarProcedimento($id);
?>

<div class="col-5 mt-5 mx-auto">
    <h4>Excluir Serviço</h4>
    <form method="post">
        <input type="hidden" name="id" value="<?= $procedimento['id']?>">

        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input value="<?= $procedimento['nome'] ?>" type="text" id="servico" name="servico" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea id="descricao" name="descricao" class="form-control" rows="4"><?= $procedimento['descricao'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Preço</label>
            <input value="<?= $procedimento['preco'] ?>" type="text" id="preco" name="preco" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Duração</label>
            <input value="<?= $procedimento['tempo'] ?>" type="text" id="duracao" name="duracao" class="form-control">
        </div>

        <p class="text-danger">Tem certeza que deseja excluir este serviço?</p>

        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="servicos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once("rodape.php"); ?>
