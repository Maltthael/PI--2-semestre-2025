<!DOCTYPE html>
<html lang="pt">
<head>
    <?php
        include '../Classes/layout.php';
        echo $head;
    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php
  echo $navbar_adm_relatorio;



  $nomes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'];
  $valores = [100, 200, 150, 90, 80, 900];
  $valores1 = [190, 220, 180, 100, 100, 650];
?>

<!-- ===== GRÁFICO 1 ===== -->
<div class="container mt-5 pt-4">
  <h2 class="text-center mb-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-database" viewBox="0 0 16 16">
      <path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313Z"/>
    </svg>
    Gráfico de Vendas
  </h2>

  <div class="card shadow-sm p-3 mb-4" style="margin-top: 20px;">
    <canvas id="meuGrafico" width="400" height="180"></canvas>
  </div>
</div>

<script>
  const labels = <?= json_encode($nomes) ?>;
  const valores = <?= json_encode($valores) ?>;
  const valores1 = <?= json_encode($valores1)?>;

  new Chart(document.getElementById('meuGrafico'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Vendas 2024',
          data: valores,
          backgroundColor: '#a200b7'
        },
        {
          label: 'Vendas 2025',
          data: valores1,
          backgroundColor: '#00b7a2'
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

<!--  GRÁFICO 2  -->
<?php
  $mes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'];
  $troca = [100, 200, 150, 90, 80, 99];
  $venda = [190, 220, 180, 100, 100, 80];
?>

<div class="container mt-5 pt-4">
  <h2 class="text-center mb-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
      <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2z"/>
    </svg>
    Gráfico de Trocas e Vendas
  </h2>

  <div class="card shadow-sm p-3 mb-4" style="margin-top: 20px;">
    <canvas id="grafico_venda" width="400" height="180"></canvas>
  </div>
</div>

<script>
  const mes = <?= json_encode($mes) ?>;
  const qtd_troca = <?= json_encode($troca) ?>;
  const qtd_venda = <?= json_encode($venda)?>;

  new Chart(document.getElementById('grafico_venda'), {
    type: 'bar',
    data: {
      labels: mes,
      datasets: [
        {
          label: 'Trocas Realizadas',
          data: qtd_troca,
          backgroundColor: '#a200b7'
        },
        {
          label: 'Vendas Realizadas',
          data: qtd_venda,
          backgroundColor: '#00b7a2'
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });  
</script>

<?php

  $situacoes = ['Encerrados', 'Abertos', 'Pendente Cliente'];
  $quantidades = [45, 30, 25]; // Quantidade de cada tipo
?>

<<div class="container mt-5 pt-5">
  <h2 class="text-center mb-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pie-chart" viewBox="0 0 16 16">
      <path d="M7.5 1.018a7 7 0 1 0 7.481 7.481A7.001 7.001 0 0 0 7.5 1.018m.5 7.482h7.001A6 6 0 0 1 8 14V8.5M8 2a6 6 0 0 1 6 6H8z"/>
    </svg>
    Situação dos Chamados
  </h2>

  <div class="card shadow-sm p-4 mb-4 grafico_pizza" >
    <!-- Canvas sem width/height inline -->
    <canvas id="grafico_pizza" style="max-width: 500px; max-height: 500px;"></canvas>
  </div>
</div>

<script>
  // Recebe arrays do PHP
  const situacoes = <?= json_encode($situacoes) ?>;
  const quantidades = <?= json_encode($quantidades) ?>;

  // Criação do gráfico de pizza
  new Chart(document.getElementById('grafico_pizza'), {
    type: 'pie',
    data: {
      labels: situacoes,
      datasets: [{
        label: 'Chamados',
        data: quantidades,
        backgroundColor: [
      
          '#00b7a2', // Encerrados
          '#a200b7', // Abertos
          '#ffc107'  // Pendente Cliente
        ],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#000',
            font: { size: 14 }
          }
        },
        title: { display: false }
      }
    }
  });
</script>


</body>




    <?php
        echo $footer_adm;
    ?>
</body>
</html>