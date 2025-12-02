<?php /** @var array $data */ ?>
<div class="row-fluid">
  <div class="span12">
    <h3>Ingresos por Balanza</h3>
  </div>
  <div class="span12">
    <ul class="totales" style="background-color:transparent!important;">
      <li><b>- Total Ingresos: </b><?php echo number_format($data['cantIng'],0,',','.'); ?> Animales</li>
      <li><b>- Kg Neto Ingreso: </b><?php echo number_format($data['pesoTotalIng'],0,',','.'); ?> Kg</li>
      <li><b>- Kg Ingreso Promedio: </b><?php echo number_format($data['kgIngProm'],0,',','.'); ?> Kg</li>
      <li><b>- Peso Min: </b><?php echo ($data['kgMinIng'] == 1000000) ? '0 Kg' : number_format($data['kgMinIng'],0,',','.').' Kg'; ?></li>
      <li><b>- Peso Max: </b><?php echo number_format($data['kgMaxIng'],0,',','.'); ?> Kg</li>
      <li style="float:right;">
        <a href="imprimir/stockGeneral.php" style="font-size:18px;" class="btn btn-primary" target="_blank">
          <span class="icon-printer iconos"></span>
        </a>
      </li>
    </ul>
  </div>
</div>
<hr>
<div class="row-fluid">
  <div class="span12">
    <h4>Listado de Ingresos</h4>
    <table class="table table-striped table-bordered table-condensed">
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Cantidad</th>
          <th>Peso</th>
        </tr>
      </thead>
      <tbody>
      <?php if(!empty($data['listado'])): foreach($data['listado'] as $row): ?>
        <tr>
          <td><?php echo isset($row['id']) ? (int)$row['id'] : ''; ?></td>
          <td><?php echo isset($row['fecha']) ? date('d-m-Y', strtotime($row['fecha'])) : ''; ?></td>
          <td><?php echo isset($row['cantidad']) ? number_format($row['cantidad'],0,',','.') : ''; ?></td>
          <td><?php echo isset($row['peso']) ? number_format($row['peso'],0,',','.') : ''; ?></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="4">Sin registros</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
    <div style="text-align:center;">
      <?php echo pagination_links($data['page'], $data['totalPages'], 'ingresos'); ?>
    </div>
  </div>
</div>
