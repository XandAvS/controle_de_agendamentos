<?php
session_start(); // muito importante para acessar $_SESSION
require_once("cabecalho.php");

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

function retornaServicosPorBarbeiro($barbeiro_id)
{
    require("conexao.php");
    try {
        $sql = "SELECT p.*
                FROM procedimentos p
                INNER JOIN barbeiro_servico bs ON p.id = bs.servico_id
                WHERE bs.barbeiro_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$barbeiro_id]);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os serviços do barbeiro: " . $e->getMessage());
    }
}

$profissionais = retornaProfissionais();
$barbeiroSelecionado = isset($_POST['barbeiro_id']) ? $_POST['barbeiro_id'] : null;
$procedimentos = $barbeiroSelecionado ? retornaServicosPorBarbeiro($barbeiroSelecionado) : [];

// Salvar agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data']) && isset($_POST['servicos'])) {
    require("conexao.php");

    $usuarioId = $_SESSION['id'];
    $barbeiroId = $_POST['barbeiro_id'];
    $data = $_POST['data'];
    $hora = date("H:i:s");
    $clienteNome = $_SESSION['nome'] ?? 'Cliente';

    // Inserir agendamento
    $sql1 = "INSERT INTO agendamentos (usuario_id, barbeiro_id, data_agendada, hora, cliente_nome)
             VALUES (?, ?, ?, ?, ?)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$usuarioId, $barbeiroId, $data, $hora, $clienteNome]);

    $agendamentoId = $pdo->lastInsertId();

    // Inserir serviços do agendamento
    foreach ($_POST['servicos'] as $servicoId) {
        $sql2 = "INSERT INTO agendamento_servico (agendamento_id, servico_id) VALUES (?, ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$agendamentoId, $servicoId]);
    }

    echo "<div class='alert alert-success text-center mt-3'>Agendamento realizado com sucesso!</div>";
}
?>
<div class="container mt-4">
    <!-- PROFISSIONAIS -->
    <h4 class="mb-3 nomenclaturas">SELECIONE UM PROFISSIONAL:</h4>
    <form method="post">
        <input type="hidden" name="barbeiro_id" id="barbeiro_id" value="<?= $barbeiroSelecionado ?>">
        <div class="snap-container">
            <?php foreach ($profissionais as $p): ?>
                <div class="snap-item <?= $barbeiroSelecionado == $p['id'] ? 'selecionado' : '' ?>"
                     onclick="selecionarBarbeiro(this, <?= $p['id']; ?>)">
                    <img src="src/img/<?= $p['foto']; ?>" alt="<?= $p['nome']; ?>">
                    <div><?= $p['nome']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2 text-center">
            <a href="novo_profissional.php" class="btn"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="profissionais.php" class="btn"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>

        <!-- SERVIÇOS -->
        <h4 class="mb-3 mt-5 nomenclaturas">SELECIONE OS SERVIÇOS:</h4>
        <div class="snap-container">
            <?php foreach ($procedimentos as $pp): ?>
                <div class="snap-item" onclick="selecionarServico(this, <?= $pp['id']; ?>)">
                    <input type="checkbox" name="servicos[]" value="<?= $pp['id']; ?>" hidden>
                    <img src="src/img/slotly logo.png" alt="<?= $pp['nome']; ?>">
                    <div><?= $pp['nome']; ?></div>
                    <div class="servico-info">
                        <span><?= $pp['preco']; ?></span><span><?= $pp['tempo']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="dica">ARRASTE PARA O LADO PARA VER MAIS</div>
        <div class="col-5 mx-auto mt-4 d-block gap-2 text-center">
            <a href="novo_servicos.php" class="btn"><i class="bi bi-plus-lg"></i> Novo</a>
            <a href="servicos.php" class="btn"><i class="bi bi-pencil-fill"></i> Editar</a>
        </div>

        <!-- DATA + SUBMIT -->
        <div class="col-5 mt-5 mx-auto">
            <label for="data" class="form-label">Escolha uma data:</label>
            <input type="date" id="data" name="data" class="form-control" required>
            <button type="submit" class="btn btn-success mt-3 w-100">Agendar</button>
        </div>
    </form>
</div>

<script>
    function selecionarBarbeiro(elemento, id) {
        document.getElementById('barbeiro_id').value = id;
        document.querySelectorAll('.snap-container .snap-item').forEach(el => el.classList.remove('selecionado'));
        elemento.classList.add('selecionado');
        document.forms[0].submit();
    }

    function selecionarServico(elemento, id) {
        let checkbox = elemento.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        elemento.classList.toggle('selecionado');
    }
</script>

<?php require_once("rodape.php"); ?>
