<div class="row-fluid">

    <div class="span12">
                    
        <div id="myTableEgresos" style="background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.15);">

            <table class="table table-striped" id="tablaEgresos" data-datatable="stock" data-dt-order-col="0" data-dt-page-length="25" style="box-shadow:0px 7px 6px 0px #cbcbcb">
            
                <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
                    <tr>
                        <th>Fecha Egreso</th>
                        <th style="text-align:center;">Cantidad</th>
                        <th>Peso Prom.</th>
                        <th>GMD Prom</th>
                        <th>GPV Prom</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="paginadoEgr">
                <?php
                // Carga completa egresos balanza (registroegresos) para mantener columnas GMD/GPV
                $sqlAllEgr = "SELECT * FROM registroegresos WHERE feedlot = '$feedlot' ORDER BY fecha DESC, tropa DESC";
                $queryAllEgr = mysqli_query($conexion,$sqlAllEgr);
                while($rowEgr = mysqli_fetch_array($queryAllEgr)){
                    ?>
                    <tr>
                      <td><?php echo formatearFecha($rowEgr['fecha']); ?></td>
                      <td style="text-align:center;">&nbsp;<?php echo $rowEgr['cantidad']; ?></td>
                      <td><?php echo number_format($rowEgr['pesoPromedio'],2,",",".")." Kg"; ?></td>
                      <td><?php echo number_format($rowEgr['gmdPromedio'],2,",",".")." Kg"; ?></td>
                      <td><?php echo number_format($rowEgr['gpvPromedio'],2,",",".")." Kg"; ?></td>
                      <td><a href="verTropa.php?tropa=<?php echo $rowEgr['tropa']; ?>&seccion=egresos"><span class="icon-eye iconos"></span></a></td>
                      <td><a href="stock.php?accion=eliminarEgreso&id=<?php echo $rowEgr['id']; ?>&tropa=<?php echo $rowEgr['tropa']; ?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>

            </table>

        </div>

    </div>

</div>
        <!-- Inicialización centralizada via public/js/datatables-init.js -->