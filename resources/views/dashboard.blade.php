<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .painel { max-width: 800px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="painel">
        <h2>Dashboard Gerencial</h2>
        <div id="grafico"></div>
    </div>

    <script>
        var options = {
            series: [{
                name: 'Acessos',
                data: {!! $dados !!} 
            }],
            chart: {
                type: 'bar', // Se quiser linha, mude para 'line'
                height: 350
            },
            xaxis: {
                categories: {!! $meses !!}
            }
        };

        var chart = new ApexCharts(document.querySelector("#grafico"), options);
        chart.render();
    </script>

</body>
</html>