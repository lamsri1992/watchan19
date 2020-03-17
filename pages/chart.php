<?php $chart = $fnc->getCHart(); ?>
<!-- CHART -->
<div class="card card-info">
    <div class="card-body">
        <div class="chart">
            <canvas id="donutChart" style="display: block;height: 300;"></canvas>
        </div>
    </div>
</div>
<script>
var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
var donutData = {
    labels: [
        'A : รอตรวจสอบ',
        'B : กำลังรักษา',
        'C : หายแล้ว',
        'D : เสียชีวิต'
    ],
    datasets: [{
        data: [<?=$chart['count_a']?>, <?=$chart['count_b']?>, <?=$chart['count_c']?>, <?=$chart['count_d']?>],
        backgroundColor: ['#17a2b8', '#fd7e14', '#00a65a', '#dc3545'],
    }]
}
var donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
}
var donutChart = new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
})
</script>