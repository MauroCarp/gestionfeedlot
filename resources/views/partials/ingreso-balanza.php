<form name="f1" class="form-horizontal" method="POST" action="?route=stock&accion=uploadIngreso&seccion=ingreso" enctype="multipart/form-data"> 

  <div id="cargaBalanza">

    <h3>Ingresos por Balanza</h3>
    

      <div class="row-fluid">

        <div class="span5">

          <b>ADPV: </b>

          <input type="number" step="0.01" name="adpv" class="input-mini">

        </div>

          <div class="span7">
        
          <b>R.E.N.S.P.A:</b>
        
          <input type="text" name="renspa" placeholder="R.E.N.S.P.A">

        </div>

      </div>

      <br>

      <div class="row-fluid">
          
        <div class="span4">

            <label for="file-uploadIng" class="btn btn-primary btn-block">

              <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo

            </label>

            <input id="file-uploadIng" onchange="cambiar('file-uploadIng','infoIng')" type="file" name="fileIng" style='display: none;' required />

        </div>

        <div class="span5" id="infoIng" style="text-align: left;font-weight: bold;">Seleccionar archivo</div>

        
        <div class="span3">
          
          <button type="submit" class="btn btn-primary btn-block" name="submitIng"><b>Cargar</b></button>

        </div>

      </div>

  </div>
  <hr>
  <div id="cargaManual">

    <div class="row-fluid">
      
      <div class="span6">

        <div class="checkbox">  
          <label>
            <input type="checkbox" name="cargaManualIngresos" id="cargaManualIngresos"> Carga Manual
          </label>
        </div>

        <a href="#" data-toggle="modal" data-target="#modalCargaManual" class="descargarPlanillas" seccion="ingresos" data-feedlot="<?= $_SESSION['feedlot']??''?>"><h5>Descargar Planilla Ingresos Manual</h5></a>
      
        <div id="divInputCargaManual" style="display:none;">

          <b>Raza: </b>

          <select name="razaIngreso" id="razaIngreso">
            <?php if(!empty($razasIngresos)){ foreach($razasIngresos as $r){ echo "<option value='".htmlspecialchars($r,ENT_QUOTES)."'>".htmlspecialchars($r)."</option>"; } } ?>
            <option value='otraRaza'>Otra</option>
          </select>
              
          <input type="text" name="otraRaza" id="otraRaza" style="display:none;" placeholder="Otra Raza">
          
          <b>Origen:</b>

          <select name="origenIngreso" id="origenIngreso">
            <?php if(!empty($origenesIngresos)){ foreach($origenesIngresos as $o){ echo "<option value='".htmlspecialchars($o,ENT_QUOTES)."'>".htmlspecialchars($o)."</option>"; } } ?>
            <option value='otroOrigenIngresos'>Otro</option>
          </select>

          <input type="text" name="otroOrigenIngresos" id="otroOrigenIngresos" style="display:none;" placeholder="Otro Origen">

          <b>Destino:</b>

          <select name="destinoIngreso" id="destinoIngreso">
            <?php if(!empty($destinosIngresos)){ foreach($destinosIngresos as $d){ echo "<option value='".htmlspecialchars($d,ENT_QUOTES)."'>".htmlspecialchars($d)."</option>"; } } ?>
            <option value='otroDestinoIngresos'>Otro</option>
          </select>

          <input type="text" name="otroDestinoIngresos" id="otroDestinoIngresos" style="display:none;" placeholder="Otro Destino">

        </div>

      </div>
  
    </div>
    
  </div>
  
</form>