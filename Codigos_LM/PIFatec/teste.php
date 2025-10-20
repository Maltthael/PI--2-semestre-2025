<?php
// Variáveis PHP simples
$nomes = ['Janeiro', 'Fevereiro', 'Março'];
$valores = [100, 200, 150];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gráfico Simples</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <h3>Gráfico simples com PHP</h3>
  <canvas id="meuGrafico" width="400" height="200"></canvas>

  <script>
    // Recebendo variáveis do PHP
    const labels = <?= json_encode($nomes) ?>;
    const valores = <?= json_encode($valores) ?>;

    new Chart(document.getElementById('meuGrafico'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Vendas',
          data: valores,
          backgroundColor: 'skyblue'
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>

</body>
</html>
