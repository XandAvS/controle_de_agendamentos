<?php
session_start();
if (!$_SESSION['acesso']) {
    header("location: index.php?mensagem=acesso_negado");
    exit;
}

function retornarRelatorioBarbeirosAgendamentos()
{
    require("conexao.php");
    try {
        $sql = "
            SELECT b.id, b.nome AS barbeiro, COUNT(a.id) AS total_agendamentos
            FROM barbeiros b
            LEFT JOIN agendamentos a 
                ON a.barbeiro_id = b.id 
            GROUP BY b.id, b.nome
            ORDER BY b.nome
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar agendamentos: " . $e->getMessage());
    }
}

$barbeiros = retornarRelatorioBarbeirosAgendamentos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Agendamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }
        .no-print {
            display: block;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .voltar {
            background-color: #6c757d;
            color: #fff;
            margin-right: 10px;
        }
        .print-button {
            background: #007bff;
            color: white;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12px;
                padding: 0;
            }
            .tabela th {
                background-color: #e0e0e0 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        .titulo { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        .tabela { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .tabela th, .tabela td { border: 1px solid #000; padding: 6px 10px; text-align: left; }
        .tabela th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<div class="no-print">
    <button type="button" class="btn voltar" onclick="history.back();">Voltar</button>
    <button class="btn print-button" onclick="window.print()">Imprimir / Salvar como PDF</button>
</div>

<div class="titulo">Relatório de Agendamentos por Barbeiro (<?= date('m/Y') ?>)</div>
<div>Data de emissão: <?= date('d/m/Y') ?></div>

<table class="tabela">
    <thead>
        <tr>
            <th>ID do Barbeiro</th>
            <th>Nome do Barbeiro</th>
            <th>Total de Agendamentos no Mês</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($barbeiros as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['barbeiro'] ?></td>
                <td><?= $b['total_agendamentos'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    window.addEventListener('beforeprint', () => console.log("Preparando para impressão..."));
    window.addEventListener('afterprint', () => console.log("Impressão concluída"));
</script>
</body>
</html>
