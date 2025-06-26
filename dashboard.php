<?php
require_once('cabecalho.php');

function retornarTodosBarbeirosComAgendamentos()
{
    require("conexao.php");
    try {
        $sql = "
            SELECT b.nome AS barbeiro, COUNT(a.id) AS total_agendamentos
            FROM barbeiros b
            LEFT JOIN agendamentos a 
                ON a.barbeiro_id = b.id 
            GROUP BY b.nome
            ORDER BY total_agendamentos DESC
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar agendamentos: " . $e->getMessage());
    }
}

$dados = retornarTodosBarbeirosComAgendamentos();
?>

<h1>Dashboard</h1>
<a href="relatorio.php">Relatório de Agendamentos</a>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div" style="height: 500px;"></div>

<script>
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Barbeiro', 'Agendamentos'],
            <?php foreach ($dados as $d): ?>['<?= $d['barbeiro'] ?>', <?= $d['total_agendamentos'] ?>],
            <?php endforeach; ?>
        ]);

        var options = {
            title: 'Agendamentos por Barbeiro (Mês Atual)',
            chartArea: {
                width: '60%'
            },
            hAxis: {
                title: 'Total de Agendamentos',
                minValue: 0,
                maxValue: 50,
                gridlines: {
                    count: 6
                }
            },
            vAxis: {
                title: 'Barbeiro'
            },
            colors: ['#007bff']
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<?php require_once('rodape.php'); ?>