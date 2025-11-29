<?php
include '../Classes/layout.php';
include '../Classes/conecta.php';

$pdo = conecta_bd::getInstance()->getConnection();

$nomes = [];
$valores2024 = [];
$valores2025 = [];

$meses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
    4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
    7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
    10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

$stmt = $pdo->prepare("CALL sp_vendas_por_mes(:ano)");
$stmt->execute(['ano' => 2024]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nomes[]       = $meses[$row['mes']];
    $valores2024[] = (float)$row['total'];
}
$stmt->closeCursor();

$stmt = $pdo->prepare("CALL sp_vendas_por_mes(:ano)");
$stmt->execute(['ano' => 2025]);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valores2025[] = (float)$row['total'];
}
$stmt->closeCursor();

$mes_comp = [];
$troca_comp = [];
$venda_comp = [];

$stmt = $pdo->query("CALL sp_comparativo_custo_venda()");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mes_comp[]   = $meses[$row['mes']];
    $troca_comp[] = (float)$row['custo_total'];
    $venda_comp[] = (float)$row['venda_total'];
}
$stmt->closeCursor();

$situacoes = [];
$quantidades = [];
$mapStatus = ['aberto', 'em_andamento', 'concluido', 'cancelado'];

$stmt = $pdo->prepare("CALL sp_status_chamados()");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $status = strtolower($row['status']);
    if (in_array($status, $mapStatus)) {
        $situacoes[]   = $status;
        $quantidades[] = (int)$row['qtd'];
    }
}
$stmt->closeCursor();

$pdo = null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php echo $head; ?>
    <meta charset="UTF-8">
    <title>Relatórios Gerenciais</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<?php echo $navbar_adm_relatorio; ?>

<div class="container mt-5 pt-4">

    <div class="chart-container">
        <h2 class="text-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-database" viewBox="0 0 16 16">
                <path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313Z"/>
            </svg>
            Gráfico de Vendas
        </h2>
        <div class="card shadow-sm p-3 mb-4">
            <canvas id="graficoVendas" width="400" height="180"></canvas>
        </div>
    </div>

    <div class="chart-container">
        <h2 class="text-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
                <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2z"/>
            </svg>
            Gráfico de Trocas e Vendas
        </h2>
        <div class="card shadow-sm p-3 mb-4">
            <canvas id="graficoComparativo" width="400" height="180"></canvas>
        </div>
    </div>

    <div class="chart-container">
        <h2 class="text-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pie-chart" viewBox="0 0 16 16">
                <path d="M7.5 1.018a7 7 0 1 0 7.481 7.481A7.001 7.001 0 0 0 7.5 1.018m.5 7.482h7.001A6 6 0 0 1 8 14V8.5M8 2a6 6 0 0 1 6 6H8z"/>
            </svg>
            Situação dos Chamados
        </h2>
        <div class="card shadow-sm p-4 mb-4 d-flex justify-content-center align-items-center">
            <div style="width: 500px; max-width: 100%;">
                <canvas id="graficoPizza"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    const labelsVendas = <?= json_encode($nomes) ?>;
    const dados2024 = <?= json_encode($valores2024) ?>;
    const dados2025 = <?= json_encode($valores2025) ?>;

    new Chart(document.getElementById('graficoVendas'), {
        type: 'bar',
        data: {
            labels: labelsVendas,
            datasets: [
                { label: 'Vendas 2024', data: dados2024, backgroundColor: '#a200b7' },
                { label: 'Vendas 2025', data: dados2025, backgroundColor: '#00b7a2' }
            ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    const labelsComp = <?= json_encode($mes_comp) ?>;
    const dadosTroca = <?= json_encode($troca_comp) ?>;
    const dadosVenda = <?= json_encode($venda_comp) ?>;

    new Chart(document.getElementById('graficoComparativo'), {
        type: 'bar',
        data: {
            labels: labelsComp,
            datasets: [
                { label: 'Trocas Realizadas', data: dadosTroca, backgroundColor: '#a200b7' },
                { label: 'Vendas Realizadas', data: dadosVenda, backgroundColor: '#00b7a2' }
            ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    const labelsStatus = <?= json_encode($situacoes, JSON_UNESCAPED_UNICODE) ?>;
    const dadosStatus = <?= json_encode($quantidades) ?>;

    new Chart(document.getElementById('graficoPizza'), {
        type: 'pie',
        data: {
            labels: labelsStatus,
            datasets: [{
                label: 'Chamados',
                data: dadosStatus,
                backgroundColor: ['#00b7a2', '#a200b7', '#ffc107', '#dc3545'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#000', font: { size: 14 } } },
                title: { display: false }
            }
        }
    });
</script>

</body>
</html>