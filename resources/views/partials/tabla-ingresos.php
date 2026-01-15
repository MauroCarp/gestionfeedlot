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
                                    // Espera un arreglo $listado con filas de registroingresos
                                    $rows = isset($listado) ? $listado : (isset($data['listado']) ? $data['listado'] : []);
                                    if (!empty($rows)):
                                        foreach ($rows as $row):
                                            $tropa = isset($row['tropa']) ? $row['tropa'] : '';
                                            $fecha = isset($row['fecha']) ? date('d-m-Y', strtotime($row['fecha'])) : '';
                                            $cantidad = isset($row['cantidad']) ? (int)$row['cantidad'] : 0;
                                            $pesoProm = isset($row['pesoPromedio']) ? number_format($row['pesoPromedio'],2,',','.') . ' Kg' : '';
                                            $renspa = isset($row['renspa']) ? $row['renspa'] : '';
                                            $adpv = isset($row['adpv']) ? number_format($row['adpv'],1,',','.') . ' Kg' : '';
                                            $estado = isset($row['estado']) ? $row['estado'] : '';
                                            $proveedor = isset($row['proveedor']) ? $row['proveedor'] : '';
                                            $stock = isset($row['stock']) ? (int)$row['stock'] : '';
                                ?>
                                    <tr data-tropa="<?php echo htmlspecialchars($tropa); ?>" data-id="<?php echo htmlspecialchars($tropa); ?>">
                                        <td style="text-align:center;"><?php echo htmlspecialchars($tropa); ?></td>
                                        <td style="min-width:100px;"><?php echo htmlspecialchars($fecha); ?></td>
                                        <td style="text-align:center;"><?php echo number_format($cantidad,0,',','.'); ?></td>
                                        <td><?php echo htmlspecialchars($pesoProm); ?></td>
                                        <td><?php echo htmlspecialchars($renspa); ?></td>
                                        <td><?php echo htmlspecialchars($adpv); ?></td>
                                        <td><?php echo htmlspecialchars($estado); ?></td>
                                        <td><?php echo htmlspecialchars($proveedor); ?></td>
                                        <td><?php echo htmlspecialchars($stock); ?></td>
                                        <td><a href="#"><span class="icon-eye iconos"></span></a></td>
                                        <td><a href="#" class="btn-delete" title="Eliminar tropa"><span class="icon-bin2 iconos"></span></a></td>
                                    </tr>
                                <?php 
                                        endforeach;
                                    else:
                                        // Dejar tbody vacío para que DataTables muestre sEmptyTable
                                    endif; ?>
                                </tbody>

            </table> 

        </div>        
                
    </div>

</div>

<!-- Inicialización centralizada via public/js/datatables-init.js -->

<!-- SweetAlert2 (CDN) y lógica de eliminación -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var table = document.getElementById('tablaIngresos');
        if(!table) return;
        table.addEventListener('click', function(e){
            var target = e.target;
            // Si el clic es en el icono, subir al enlace
            if(target && target.classList.contains('icon-bin2')){
                target = target.closest('a');
            }
            if(target && target.classList && target.classList.contains('btn-delete')){
                e.preventDefault();
                var tr = target.closest('tr');
                var id = tr ? tr.getAttribute('data-id') : null;
                if(!id){
                    Swal.fire('Error', 'No se encontró el ID del registro.', 'error');
                    return;
                }
                Swal.fire({
                    title: 'Eliminar ingreso',
                    text: '¿Confirmás eliminar el registro #' + id + '?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(function(result){
                    if(!result.isConfirmed) return;
                    // Ejecutar eliminación vía AJAX (por tropa)
                    fetch('ajax/ingresos.delete-tropa.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'tropa=' + encodeURIComponent(id)
                    }).then(function(resp){ return resp.json(); })
                    .then(function(json){
                        if(json && json.ok){
                            // Eliminar fila de la tabla
                            tr.parentNode.removeChild(tr);
                            Swal.fire('Eliminado', 'La tropa y sus ingresos fueron eliminados.', 'success');
                        } else {
                            var msg = (json && json.msg) ? json.msg : 'No se pudo eliminar.';
                            Swal.fire('Error', msg, 'error');
                        }
                    }).catch(function(){
                        Swal.fire('Error', 'Fallo la comunicación con el servidor.', 'error');
                    });
                });
            }
        });
    });
</script>