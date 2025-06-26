<?php
require_once("cabecalho.php");

function retornaAgendamentosAgrupados()
{
    require("conexao.php");
    try {
        $sql = "
            SELECT 
                b.nome AS barbeiro,
                a.id AS agendamento_id,
                a.cliente_nome,
                a.data_agendada,
                a.hora,
                s.nome AS servico
            FROM agendamentos a
            JOIN barbeiros b ON a.barbeiro_id = b.id
            JOIN agendamento_servico ags ON a.id = ags.agendamento_id
            JOIN procedimentos s ON ags.servico_id = s.id
            ORDER BY b.nome, a.data_agendada, a.hora
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os agendamentos: " . $e->getMessage());
    }
}

$dados = retornaAgendamentosAgrupados();

// Organiza em estrutura: [barbeiro][agendamento_id] = info
$agendamentos = [];

foreach ($dados as $d) {
    $barbeiro = $d['barbeiro'];
    $agendamentoId = $d['agendamento_id'];

    if (!isset($agendamentos[$barbeiro])) {
        $agendamentos[$barbeiro] = [];
    }

    if (!isset($agendamentos[$barbeiro][$agendamentoId])) {
        $agendamentos[$barbeiro][$agendamentoId] = [
            'cliente' => $d['cliente_nome'],
            'data' => date('d/m/Y', strtotime($d['data_agendada'])),
            'hora' => substr($d['hora'], 0, 5),
            'servicos' => [],
        ];
    }

    $agendamentos[$barbeiro][$agendamentoId]['servicos'][] = $d['servico'];
}
?>

<div class="col-10 mx-auto mt-4">
    <?php foreach ($agendamentos as $barbeiro => $agendamentosBarbeiro): ?>
        <h4 class="text-primary mt-4 border-bottom pb-1"><?= $barbeiro ?></h4>
        <ul class="list-group mb-4">
            <?php foreach ($agendamentosBarbeiro as $agendamento): ?>
                <li class="list-group-item">
                    <strong>Cliente:</strong> <?= $agendamento['cliente'] ?> |
                    <strong>Data:</strong> <?= $agendamento['data'] ?> |
                    <strong>Hora:</strong> <?= $agendamento['hora'] ?> |
                    <strong>Serviços:</strong> <?= implode(', ', $agendamento['servicos']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>

<?php require_once("rodape.php"); ?>
