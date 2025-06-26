<?php
require_once("cabecalho.php");

// Função que retorna os dados do barbeiro
function consultarBarbeiro($id) {
    require("conexao.php");
    try {
        $sql = "SELECT * FROM barbeiros WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $barbeiro = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$barbeiro) {
            die("Profissional não encontrado.");
        }
        return $barbeiro;
    } catch (Exception $e) {
        die("Erro ao consultar barbeiro: " . $e->getMessage());
    }
}

// Função que exclui os vínculos do barbeiro com os serviços
function excluirServicosDoBarbeiro($id) {
    require("conexao.php");
    try {
        $stmt = $pdo->prepare("DELETE FROM barbeiro_servico WHERE barbeiro_id = ?");
        $stmt->execute([$id]);
    } catch (Exception $e) {
        die("Erro ao excluir serviços do barbeiro: " . $e->getMessage());
    }
}

// Função que exclui o barbeiro em si
function excluirBarbeiro($id) {
    require("conexao.php");
    try {
        $stmt = $pdo->prepare("DELETE FROM barbeiros WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (Exception $e) {
        die("Erro ao excluir barbeiro: " . $e->getMessage());
    }
}

// Exclusão via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    excluirServicosDoBarbeiro($id);
    $ok = excluirBarbeiro($id);
    if ($ok) {
        header("Location: profissionais.php?exclusao=true");
    } else {
        header("Location: profissionais.php?exclusao=false");
    }
    exit;
}

// Carregamento inicial via GET
if (!isset($_GET['id'])) {
    die("ID do profissional não informado.");
}

$id = $_GET['id'];
$barbeiro = consultarBarbeiro($id);
?>

<div class="col-5 mt-5 mx-auto">
    <h4>Excluir Profissional</h4>
    <form method="post">
        <input type="hidden" name="id" value="<?= $barbeiro['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" id="profissional" name="profissional" class="form-control" value="<?= $barbeiro['nome'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Foto</label><br>
            <img src="src/img/<?= $barbeiro['foto'] ?>" alt="<?= $barbeiro['nome'] ?>" style="max-width:150px;">
        </div>
        <p class="text-danger">Tem certeza que deseja excluir este profissional?</p>
        <button type="submit" class="btn btn-danger">Sim, excluir</button>
        <a href="profissionais.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once("rodape.php"); ?>
