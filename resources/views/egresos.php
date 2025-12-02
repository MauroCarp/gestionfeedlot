<?php /** @var array $data */ ?>
<div class="row-fluid">
  <div class="span12">
    <h3>Egresos por Balanza</h3>
  </div>
  <div class="span12">
    <ul class="totales" style="background-color:transparent!important;">
      <li><b>- Total Egresos: </b><?php echo number_format($data['cantEgr'],0,',','.'); ?> Animales</li>
      <li><b>- Kg Neto Egreso: </b><?php echo number_format($data['pesoTotalEgr'],0,',','.'); ?> Kg</li>
      <li><b>- Kg Egreso Promedio: </b><?php echo number_format($data['kgEgrProm'],0,',','.'); ?> Kg</li>
      <li><b>- Peso Min: </b><?php echo ($data['kgMinEgr'] == 1000000) ? '0 Kg' : number_format($data['kgMinEgr'],0,',','.').' Kg'; ?></li>
      <li><b>- Peso Max: </b><?php echo number_format($data['kgMaxEgr'],0,',','.'); ?> Kg</li>
      <li style="float:right;">
        <a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-primary" target="_blank">
          <span class="icon-printer iconos"></span>
        </a>
      </li>
    </ul>
  </div>
</div>
