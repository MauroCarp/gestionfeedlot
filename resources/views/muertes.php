<?php /** @var array $data */ ?>
<div class="row-fluid">
  <div class="span12">
    <h3>Totales Muertes</h3>
  </div>
  <div class="span12">
    <ul class="totales" style="padding-top:10px;margin-bottom:10px;">
      <li><b>- Total Muertes: </b><?php echo number_format($data['cantMuertes'],0,',','.'); ?></li>
      <li>
        <div id="canvas-holder" style="max-width:420px;">
          <canvas id="chart-area"></canvas>
        </div>
      </li>
    </ul>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    if(window.Chart){
      var ctx = document.getElementById('chart-area').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: <?php echo json_encode($data['chartLabels']); ?>,
          datasets: [{
            data: <?php echo json_encode($data['chartCounts']); ?>,
            backgroundColor: ['#3366cc','#dc3912','#ff9900','#109618','#990099','#0099c6','#dd4477','#66aa00','#b82e2e','#316395']
          }]
        },
        options: { responsive:true, legend:{ position:'right' } }
      });
    } else {
      console.warn('Chart.js no disponible');
    }
  });
</script>
