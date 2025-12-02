<div id="myTableMuertes" style="background:#fff; padding:15px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.15);">

    <table class="table table-striped" id="tablaMuertes" data-datatable="stock" data-dt-order-col="0" data-dt-page-length="25" style="box-shadow:0px 7px 6px 0px #cbcbcb">
        
        <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
            <tr>
                <th scope="col">Fecha Muerte</th>
                <th scope="col">Origen</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Causa Muerte</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody id="paginadoMuertes">
        <?php
        $sqlAllMuertes = "SELECT * FROM muertes WHERE feedlot = '$feedlot' ORDER BY fecha DESC";
        $queryAllMuertes = mysqli_query($conexion,$sqlAllMuertes);
        while($rowM = mysqli_fetch_array($queryAllMuertes)){
                ?>
                <tr>
                    <td><?php echo formatearFecha($rowM['fecha']); ?></td>
                    <td style="text-align:left;"><?php echo $rowM['origen']; ?></td>
                    <td style="text-align:left;"><?php echo $rowM['proveedor']; ?></td>
                    <td><?php echo $rowM['causaMuerte']; ?></td>
                    <td><a style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modalEditarCausa" onclick="editarCausa('<?php echo $rowM['id']; ?>')"><span class="icon-pencil iconos"></span></a></td>
                    <td><a href="stock.php?accion=eliminarMuerte&id=<?php echo $rowM['id']; ?>&tropa=<?php echo $rowM['tropa']; ?>" onclick="return confirm('¿Eliminar Registro?');"><span class="icon-bin2 iconos"></span></a></td>
                </tr>
                <?php
        }
        ?>
        </tbody>
        
    </table>

</div>

<div class="modal fade" style="top:100px;z-index:99!important;" id="modalEditarCausa" tabindex="-1" role="dialog" aria-labelledby="modalEditarCausa" aria-hidden="true">

    <div class="modal-dialog" style="width:auto;" role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h2 class="modal-title">Editar Causa</h2>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

            <div class="row-fluid">
                
                <div class="span12">
                    
                    <div class="control-group"> 
                    
                        <label class="control-label" style="font-size:1.1em;"><b>Causa de Muerte:</b></label>
                    
                        <div class="controls">
                    
                            <select id="causaMuerteEdit" class="form-control input-large">
                        
                                <option value="">Seleccionar Causa Muerte</option>
                        
                                <option value="Accidente">Accidente</option>
                        
                                <option value="Digestivo">Digestivo</option>
                        
                                <option value="Ingreso">Ingreso</option>
                        
                                <option value="Nervioso">Nervioso</option>
                        
                                <option value="Rechazo">Rechazo</option>
                        
                                <option value="Respiratorio">Respiratorio</option>
                        
                                <option value="Sin Diagnostico">Sin Diagnostico</option>
                        
                                <option value="Sin Hallazgo">Sin Hallazgo</option>
                        
                                <option value="Otro">Otro</option>
                        
                            </select>
                        
                        </div>
                    
                    </div>           
                    
                </div>

            </div>

            <div class="row-fluid">
            
                <div class="span12">

                    <div class="control-group"> 
                                            
                        <div class="controls">
                    
                            <button class="btn btn-primary" id="btnEditarCausa" idMuerte="">Editar Causa</button>
            
                        </div>
                    
                    </div>        

                </div>

            </div>

        </div>

    </div>

    </div>

</div>

<!-- Inicialización centralizada via public/js/datatables-init.js -->