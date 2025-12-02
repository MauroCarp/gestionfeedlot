<div class="row-fluid">

  <div class="span12 tablaMixer">  

    <table class="table table-striped datatable-auto" style="box-shadow:0px 7px 6px 0px #cbcbcb">

        <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
          <tr>
            <th>Fecha</th>
            <th>Operario</th>
            <th>Formula</th>
            <th>Kilos</th>
            <th></th>
            <th></th>
          </tr>
        </thead>

        <tbody id="paginadoMixer">
          <form action="raciones.php?accion=ingresoMixer" method="POST">
            <tr>
              <td><input type="date" class="form-control" id="fecha" name="fecha"></td>
              <td>
                <select class="form-control" id="operario" name="operario">
                  <option value="">Seleccionar Operario</option>
                </select>
                <input type="text" class="form-control" id="otroOperario" name="otroOperario"  placeholder="Otro Operario">
              </td>
              <td>
                <select class="form-control" id="formula" name="formula">
                  <option value="">Seleccionar Formula</option>
                </select>
              </td>
              <td><input type="number" class="form-control input-small" id="kilos" name="kilos" placeholder="Kilos"></td>
              <td colspan="2"><button class="btn btn-primary btn-block" id="cargarMixer">Cargar</button></td>
            </tr>
          </form>
          <?php
          $sqlAllMixer = "SELECT * FROM mixer WHERE feedlot = '$feedlot' ORDER BY fecha DESC";
          $queryAllMixer = mysqli_query($conexion,$sqlAllMixer);
          while($rowMix = mysqli_fetch_array($queryAllMixer)){
            $id = $rowMix['id'];
            $fecha = formatearFecha($rowMix['fecha']);
            $formula = nombreFormula($rowMix['formula'],$conexion);
            $operario = $rowMix['operario'];
            $kilos = $rowMix['kilos'];
            ?>
            <tr>
              <td><b><?php echo $fecha; ?></b></td>
              <td><b><?php echo $operario; ?></b></td>
              <td><b><?php echo $formula; ?></b></td>
              <td><b><?php echo $kilos; ?> Kg</b></td>
              <td><button class='btn' data-toggle='modal' data-target='#modalVerMixer' onclick='verModalMixer(<?php echo $id; ?>)'><span class='icon-eye'></span></button></td>
              <td><a href='raciones.php?accion=eliminarMixer&id=<?php echo $id; ?>' class='btn' onclick="return confirm('Eliminar Registro?');"><span class='icon-bin2'></span></a></td>
            </tr>
            <?php
          }
          ?>
        </tbody>

    </table> 

    <!-- Paginación manejada por DataTables (datatable-auto) -->

  </div>

</div>

<div class="modal fade" id="modalVerMixer" tabindex="-1" role="dialog" aria-labelledby="modalVerMixer" aria-hidden="true" style="width:1150px;margin-left:-575px;margin-top:60px;z-index:99">

  <div class="modal-content">

    <div class="modal-body">

      <h3 id="exampleModalLabel" style="margin-top: 5px;">Formula <span id="nombreFormula"></span></h3>

      <form method="POST" action="" id="formModalMixer">

        <div class="row-fluid">

          <div class="span12">

            <b>Composici&oacute;n de la dieta en base a <span id="kilosDieta"></span> Kilos  -  Margen de Error: <input type="number" step="0.01" name="margenError" id="margenError" class="input-mini" value=""/> %</b>    

          </div>

        </div> 

        <div class="row-fluid">
          <div class="span12" id="loaderModalMixer">

          </div>
        </div>
        <div class="row-fluid" style="border-bottom: 2px solid #7D7D7D">

          <div class="span2"><b>Producto</b></div>
          
          <div class="span1" style="line-height: 1em;"><b>% en la Dieta</b></div>
          
          <div class="span1"><b>% MS</b></div>
          
          <div class="span1"><b>Kilos</b></div>
          
          <div class="span1"><b>Kg Real</b></div>
          
          <div class="span1" style="line-height: 1em;"><b>Dieta Final</b></div>
          
          <div class="span1"><b>Dif. Kg</b></div>
          
          <div class="span1"><b>Dif. %</b></div>
          
          <div class="span1" style="line-height: 1em;"><b>% MS Insumo</b></div>
          
          <div class="span1"><b>Kg MS</b></div>
          
          <div class="span1" style="line-height: 1em;"><b>% MS en Dieta</b></div>

        </div>


        <div class="row-fluid" id="totalesMixer">

          <div class="span2"><b>TOTALES</b></div>

          <div class="span1"><b id="totalCantPorc"></b></div>

          <div class="span1"><b id="porceTCtotal"></b></div>

          <div class="span1"><b id="totalCantKilos"></b></div>

          <div class="span1"><b id="totalKilosReal"></b></div>

          <div class="span1"><b id="dietaFinal"></b></div>

          <div class="span1"></div>

          <div class="span1"></div>

          <div class="span1"></div>

          <div class="span1"><b id="kilosMS"></b></div>

          <div class="span1"><b id="totalMSporc"></b></div>

        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Cargar</button>


        <button class="btn btn-primary" style=": right;margin-top: 10px;margin-right: 5px;" id="btnImprimirMixer">Imprimir</button>
        <br><br>

      </form>
    
    </div>

  </div>

</div>



<script>

$(document).ready(function() {
    
    $('#otroOperario').css('display','none');

    $('#operario').change(function(){

      var valor = $(this).val();

      if(valor == 'otroOperario'){

        $('#otroOperario').css('display','block');
        
      }else{
        
        $('#otroOperario').css('display','none');

      }

    });

    var feedlot = '<?php echo $feedlot?>';
        
    cargarSelect('formulas',feedlot);
    
    cargarSelect('operarios',feedlot);

});



</script>