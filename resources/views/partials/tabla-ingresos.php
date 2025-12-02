<div class="row-fluid">

    <div class="span12">

        <div id="myTableIngresos" style="background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.15);">

            <table class="table table-striped" id="tablaIngresos" data-datatable="stock" data-dt-order-col="1" data-dt-page-length="25" style="box-shadow:0px 7px 6px 0px #cbcbcb">

                <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
                    <tr>
                        <th scope="col" style="text-align: center;">Tropa</th>
                        <th scope="col" style="min-width:100px;">Ingreso</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col" style="width:100px;">Peso Prom.</th>
                        <th scope="col">Renspa</th>
                        <th scope="col">ADPV</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col"><b>Stock</b></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody style="font-size:.8em">
                <?php
                // Carga completa sin paginador legacy
                // $sqlAllIng = "SELECT * FROM registroingresos WHERE feedlot = '$feedlot' ORDER BY fecha DESC, tropa DESC";
                // $queryAllIng = mysqli_query($conexion,$sqlAllIng);
                // while($rowIng = mysqli_fetch_array($queryAllIng)){
                //         $tropa = $rowIng['tropa'];
                //         ?>
                <!-- //         <tr>
                //             <td style="text-align: center;"><?php //echo $tropa; ?></td>
                //             <td style="min-width:100px;"><?php //echo formatearFecha($rowIng['fecha']); ?></td>
                //             <td style="text-align:center;"><?php //echo $rowIng['cantidad']; ?></td>
                //             <td><?php //echo number_format($rowIng['pesoPromedio'],2,",",".")." Kg"; ?></td>
                //             <td><?php //echo $rowIng['renspa']; ?></td>
                //             <td><?php //echo $rowIng['adpv']." Kg"; ?></td>
                //             <td><?php //echo $rowIng['estado']; ?></td>
                //             <td><?php //echo strtoupper($rowIng['proveedor']); ?></td>
                //             <td><?php //echo stock($rowIng['fecha'],$feedlot,$conexion); ?></td>
                //             <td><a href="verTropa.php?tropa=<?php //echo $rowIng['tropa']; ?>&seccion=ingresos"><span class="icon-eye iconos"></span></a></td>
                //             <td><a href="stock.php?accion=eliminarIngreso&id=<?php //echo $rowIng['id']; ?>&tropa=<?php //echo $rowIng['tropa']; ?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td> -->
                <!-- //         </tr> -->
                        <?php
                // }
                ?>
                <tr>
                    <td style="text-align:center;">HX001</td>
                    <td style="min-width:100px;">21-11-2025</td>
                    <td style="text-align:center;">48</td>
                    <td>318,40 Kg</td>
                    <td>RS-55555</td>
                    <td>15,6 Kg</td>
                    <td>En proceso</td>
                    <td>PROV EJEMPLO</td>
                    <td>412</td>
                    <td><a href="#"><span class="icon-eye iconos"></span></a></td>
                    <td><a href="#"><span class="icon-bin2 iconos"></span></a></td>
                </tr>
                <tr>
                    <td style="text-align:center;">HX002</td>
                    <td style="min-width:100px;">20-11-2025</td>
                    <td style="text-align:center;">52</td>
                    <td>322,10 Kg</td>
                    <td>RS-55556</td>
                    <td>16,1 Kg</td>
                    <td>Terminado</td>
                    <td>PROV DEMO</td>
                    <td>430</td>
                    <td><a href="#"><span class="icon-eye iconos"></span></a></td>
                    <td><a href="#"><span class="icon-bin2 iconos"></span></a></td>
                </tr>
                </tbody>

            </table> 

        </div>        
                
    </div>

</div>

<!-- Inicialización centralizada via public/js/datatables-init.js -->